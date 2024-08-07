<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UserPhotos $model */

$this->title = 'Update User Photos id: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Photos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-photos-update my-5 py-5">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>