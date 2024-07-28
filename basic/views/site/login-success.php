<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\User;

$this->title = 'Information User';
$this->params['breadcrumbs'][] = $this->title;
$user_id = Yii::$app->user->id;
$user_name = User::find()->where(['id' => $user_id])->one()->username;
$user_fullname = User::find()->where(['id' => $user_id])->one()->fullname;
$user_email = User::find()->where(['id' => $user_id])->one()->email;
?>
<div class="site-login my-5 py-5">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <!-- The Table  -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Username
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Fullname
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?php echo $user_name ?>
                            </th>
                            <td class="px-6 py-4">
                                <?php echo $user_fullname ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo $user_name ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>
    </div>