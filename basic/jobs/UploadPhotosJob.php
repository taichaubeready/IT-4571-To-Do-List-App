<?php

namespace app\jobs;

use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use app\models\User;
use WebPConvert\WebPConvert;

class UploadPhotosJob extends BaseObject implements JobInterface
{
    public $model;

    public function execute($queue)
    {
        $user_id = $this->model->user_id;
        $user_name = User::find()->where(['id' => $user_id])->one()->username;

        $data_files = []; // Array Data Files

        // Using File Helper to create folder
        $path = Yii::getAlias('@webroot/user_photos/') . $user_name . '/uploads';
        FileHelper::createDirectory($path);

        $this->model->photos = UploadedFile::getInstances($this->model, 'photos');

        // Multiple files use foreach
        foreach ($this->model->photos as $key => $files) {
            # code...
            $files_name = Yii::$app->security->generateRandomString(16);
            $files->saveAs($path . '/' . $files_name . '.' . $files->extension); // Save in folder uploads
            $data_files[$key] = $files_name . '.' . $files->extension;

            // Convert JPG, PNG to Webp
            $source = $path . '/' . $files_name . '.' . $files->extension;
            $destination = $path . '/' . 'webp/' . $files_name . '.webp';
            $options = [];
            WebPConvert::convert($source, $destination, $options);
        }

        $this->model->photos = json_encode($data_files); // Save in DB

        // $model->save();

        if ($this->model->save()) {
            Yii::$app->session->setFlash('success', "User Photos created successfully.");
        } else {
            Yii::$app->session->setFlash('error', "User Photos not saved.");
        }

    }
}