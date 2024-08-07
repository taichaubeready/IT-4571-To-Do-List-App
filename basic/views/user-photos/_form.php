<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UserPhotos $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
        class="alert alert-danger alert-dismissable">
        <h4><i class="icon fa fa-check"></i>Not Saved!</h4>
        <?= Yii::$app->session->getFlash('error'); ?>
    </div>
<?php endif; ?>

<div class="user-photos-form my-5 py-5" x-data="{ 
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
        <?= $form->field($model, 'photos[]')->fileInput([
            'class' => 'input',
            'placeholder' => 'Input...',
            'x-ref' => 'image',
            'x-on:change' => 'previewImage',
            'multiple' => true,
            'accept' => 'image/*',
        ]) ?>
        <template x-if="imagePreview">
            <img x-bind:src="imagePreview" alt="" class="image">
        </template>
    </div>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save Photos', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>