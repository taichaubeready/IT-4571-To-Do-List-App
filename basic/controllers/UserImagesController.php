<?php

namespace app\controllers;

use Yii;
use app\models\UserImages;
use app\models\UserImagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

// require 'basic/vendor/autoload.php';
use WebPConvert\WebPConvert;

/**
 * UserImagesController implements the CRUD actions for UserImages model.
 */
class UserImagesController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all UserImages models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserImagesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserImages model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserImages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new UserImages();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                // $imageFiles = UploadedFile::getInstance($model,'file');
                // if (isset($imageFiles->size)) {
                //     $imageFiles->saveAs('uploads/'.$imageFiles->baseName.'.'.$imageFiles->extension);   
                // }

                // $model->file = UploadedFile::getInstances($model, 'file');
                // $model->file->saveAs(Yii::getAlias('@webroot/uploads/') . $model->file->baseName . '.' . $model->file->extension); // Save in folder uploads

                // $model->file = $model->file->baseName . '.' . $model->file->extension; // Save in DB

                $data_files = []; // Array Data Files

                // Using File Helper to create folder
                $path = Yii::getAlias('@webroot/user_images/') . $model->user_id . '/uploads';
                FileHelper::createDirectory($path);

                $model->file = UploadedFile::getInstances($model, 'file');

                // Multiple files use foreach
                foreach ($model->file as $key => $files) {
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

                // $model->file = json_encode($data_files); // Save in DB

                $model->file = json_encode($data_files); // Save in DB

                $model->save();

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserImages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserImages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserImages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UserImages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserImages::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
