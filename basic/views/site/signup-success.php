<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\SignupForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Sign Up';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup my-5 py-5">
    <h1><?= Html::encode($this->title) ?> Notification</h1>

    <div class="my-5 py-5">
        <p class="text-[30px] text-center font-bold text-white bg-blue-400 p-3 m-3 rounded-xl">"Your New Account had been created"</p>
    </div>

</div>
</div>