<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RegistrationForm - это модель, лежащая в основе формы регистрации.
 *
 * @package app\models
 */
class SignupForm extends Model
{
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $password_repeat;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'email', 'password', 'password_repeat'], 'required', 'message' => 'Заполните поле'],
            ['firstname', 'string', 'min' => 3, 'max' => 255],
            ['lastname', 'string', 'min' => 3, 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Такая почта уже существует'],
            ['email', 'email'],
            ['password', 'string', 'min'=>3, 'max'=>30],
            ['password_repeat', 'compare', 'compareAttribute'=>'password'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
        ];
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        if ($this->validate()) {
            $passwordHash = Yii::$app->getSecurity()->generatePasswordHash($this->password);

            $user = new User();
            $user->setAttribute('firstname', $this->firstname);
            $user->setAttribute('lastname', $this->lastname);
            $user->setAttribute('email', $this->email);
            $user->setAttribute('password', $passwordHash);

            return $user->save();
        }
        return false;
    }
}