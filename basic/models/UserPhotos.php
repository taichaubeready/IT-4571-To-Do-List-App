<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_photos".
 *
 * @property int $id
 * @property string $photos
 * @property int $user_id
 *
 * @property User $user
 */
class UserPhotos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_photos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['photos', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['photos'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],

            [
                ['photos'],
                'file',
                'extensions' => 'jpg, png, webp',
                'skipOnEmpty' => false,
                'maxFiles' => 4,
                'maxSize' => 1024 * 1024 * 2,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photos' => 'Photos',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
