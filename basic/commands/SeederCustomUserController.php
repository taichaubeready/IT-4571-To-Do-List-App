<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;


class SeederCustomUserController extends Controller
{
    /**
     * Hàm tạo 2 records mẫu cho bảng custom_user
     */
    public function actionSeederCtUser()
    {
        for ($i = 1; $i <= 2; $i++) {
            # code...
            echo ($i < 10) ? 'Inserted New User Record 0' . $i . PHP_EOL : 'Inserted New User Record ' . $i . PHP_EOL;
            $sql = Yii::$app->db->createCommand()->insert('custom_user', [
                // 'id' => ($i < 10) ? "0" . $i : $i,
                'fullname' => ($i < 10) ? 'Test0' . $i : 'Test' . $i,
                'email' => ($i < 10) ? 'test0' . $i . '@gmail.com' : 'test' . $i . '@mail.com',
                'password' => ($i < 10) ? 'password0' . $i : 'password' . $i,
            ])->execute();
        }

        echo 'Seeder Custom User is Done.' . "\n";

        return ExitCode::OK;
    }
}