<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UserImages $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-images-form" x-data="{ 
        imagePreview: null,
        previewImage() {
            const reader = new FileReader()
            reader.onload = (e) => this.imagePreview = e.target.result
 
            reader.readAsDataURL(this.$refs.image.files[0])
        }
     }">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>

    <div>
        <?= $form->field($model, 'file[]')->fileInput([
            'class' => 'input',
            'placeholder' => 'Input...',
            'x-ref' => 'image',
            'x-on:change' => 'previewImage',
            'multiple'=> true,
            'accept' => 'image/*',
        ]) ?>
        <template x-if="imagePreview">
            <img x-bind:src="imagePreview" alt="" class="image">
        </template>
    </div>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>