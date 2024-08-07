<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\UserPhotos $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Photos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-photos-view my-5 py-5">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="alert alert-success alert-dismissable">
            <h4><i class="icon fa fa-check"></i>Saved!</h4>
            <?= Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>



    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'photos',
            [
                'attribute' => 'Album Photos',
                'value' => function ($model) {
                $html = '';
                $images = json_decode($model->photos, true);
                $user_id = $model->user_id;
                $user_name = User::find()->where(['id' => $user_id])->one()->username;
                foreach ($images as $image) {
                    //here your stuff
                    $path = Yii::getAlias('@web/user_photos/') . $user_name . '/uploads' . '/' . $image;

                    $html .= Html::img($path, ['width' => '100px', 'height' => '100px', 'class' => 'image' ]) . "<br>";
                }
                return $html;                // here's returned value
            },
                // 'format' => ['image', ['width' => '100', 'height' => '100']],
                'format' => 'raw',
            ],
            'user_id',
        ],
    ]) ?>

</div>