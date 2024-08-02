<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    // Initialize Variable
    public $username;
    public $fullname;
    public $email;
    public $password;
    public $re_password;
    public $verifyCode;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'fullname', 'email'], 'trim'],
            [['username', 'fullname', 'email', 'password', 're_password', 'verifyCode'], 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            [['username', 'fullname', 'email'], 'string', 'min' => 5, 'max' => 255],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],

            [['password', 're_password'], 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            [['password', 're_password'], 'match', 'pattern' => '/^(?=.*[0-9])(?=.*[A-Z])(?=.*[@%&*])([a-zA-Z0-9]+)([^<>\!\#\$\^\(\)]*){8,}$/'],

            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            're_password' => 'Re_Password',
            'verifyCode' => 'Verification_Code',
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        // if (!$this->validate()) {
        //     return null;
        //    // return false;
        // }

        $user = new User();
        $user->username = $this->username;
        $user->fullname = $this->fullname;
        $user->email = $this->email;
        $user->password = $this->password;
        $user->setPassword($this->password);
        $user->generatePasswordResetToken();
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        
        // return $user->save() && $this->sendEmail($user);
        if ($this->password === $this->re_password) {
            return $user->save();
        }
        // return false;

        // return $user->save();
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}