<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UserPhotos $model */

$this->title = 'Create User Photos';
$this->params['breadcrumbs'][] = ['label' => 'User Photos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-photos-create my-5 py-5">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
