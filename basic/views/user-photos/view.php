<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i>Saved!</h4>
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i>Saved!</h4>
            <?= Yii::$app->session->getFlash('error') ?>
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
                foreach ($images as $image) {
                    //here your stuff
                    $path = Yii::getAlias('@web/user_photos/') . $model->user_id . '/uploads' . '/' . $image;

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