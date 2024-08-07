<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "job".
 *
 * @property int $id
 * @property string $action
 * @property int $user_id
 * @property string $status
 * @property int $is_deleted
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 */
class Job extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['action', 'user_id', 'status'], 'required'],
            [['user_id', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['action', 'status'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'action' => 'Action',
            'user_id' => 'User ID',
            'status' => 'Status',
            'is_deleted' => 'Is Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
