<?php

use app\models\UserPhotos;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UserPhotosSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'User Photos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-photos-index my-5 py-5">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User Photos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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

                    $html .= Html::img($path, ['width' => '100px', 'height' => '100px', 'class' => 'image']) . "<br>";
                }
                return $html;                // here's returned value
            },
                // 'format' => ['image', ['width' => '100', 'height' => '100']],
                'format' => 'raw',
            ],
            'user_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, UserPhotos $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
            ],
        ],
    ]); ?>


</div>