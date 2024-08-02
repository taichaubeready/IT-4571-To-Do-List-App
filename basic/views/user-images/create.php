<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UserImages $model */

$this->title = 'Create User Images';
$this->params['breadcrumbs'][] = ['label' => 'User Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-images-create my-5 py-5">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
