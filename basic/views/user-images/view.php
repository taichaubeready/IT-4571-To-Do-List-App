<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\UserImages $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="user-images-view my-5 py-5">

    <h1><?= Html::encode($this->title) ?></h1>

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

    <?php
    // $images = json_decode($model->file, true);
    
    // Yii::getAlias('@web/user_images/') . $model->user_id . '/uploads' . '/' . $images[0]
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'file',
            [
                'attribute' => 'photo',
                'value' => function ($model) {
                    $html = '';
                    $images = json_decode($model->file, true);
                    foreach ($images as $image) {
                        //here your stuff
                        $path = Yii::getAlias('@web/user_images/') . $model->user_id . '/uploads' . '/' . $image;

                        $html .= Html::img($path, ['width' => '100px', 'height' => '100px']) . "<br>";
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