<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_images".
 *
 * @property int $id
 * @property string $file
 * @property int $user_id
 */
class UserImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['file'], 'string', 'max' => 255],

            [
                ['file'],
                'file',
                'extensions' => 'jpg, png, webp',
                'skipOnEmpty' => false,
                'maxFiles' => 4,
                'maxSize' => 1024 * 1024 * 2,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'File',
            'user_id' => 'User ID',
        ];
    }
}
