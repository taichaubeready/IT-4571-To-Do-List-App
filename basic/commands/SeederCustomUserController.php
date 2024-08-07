<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;


class SeederCustomUserController extends Controller
{
    /**
     * Hàm tạo 25 records mẫu cho bảng user
     */
    public function actionSeederCtUser()
    {

        for ($i = 1; $i <= 25; $i++) {
            # code...
            $user = new User();
            $user->id = ($i < 10) ? "0" . $i : $i;
            $user->username = ($i < 10) ? 'test0' . $i : 'test' . $i;
            $user->email = ($i < 10) ? 'test0' . $i . '@mail.com' : 'test' . $i . '@mail.com';
            $user->fullname = ($i < 10) ? 'Test0' . $i : 'Test' . $i;
            $user->password = ($i < 10) ? 'Test0' . $i . '@%&*' : 'Test' . $i . '@%&*';
            $user->setPassword($user->password);
            $user->generatePasswordResetToken();
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $user->status = 10;
            $user->created_at = time();
            $user->updated_at = time();
            $sql = Yii::$app->db->createCommand()->insert('user', [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'fullname' => $user->fullname,
                'password' => $user->password,
                'password_hash' => $user->password_hash,
                'password_reset_token' => $user->password_reset_token,
                'auth_key' => $user->auth_key,
                'verification_token' => $user->verification_token,
                'status' => $user->status,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ])->execute();
            echo ($i < 10) ? 'Inserted a New User Record 0' . $i . PHP_EOL : 'Inserted a New User Record ' . $i . PHP_EOL;
        }

        echo 'Seeder Custom User is Done.' . "\n";

        return ExitCode::OK;
    }
}