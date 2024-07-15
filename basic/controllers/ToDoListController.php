<?php

namespace app\controllers;

class ToDoListController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = "todolist.php";

        return $this->render('index');
    }

}
