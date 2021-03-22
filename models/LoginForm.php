<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm - это модель, лежащая в основе формы входа.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array правила проверки.
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['email', 'email'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Проверяет пароль.
     * Этот метод служит встроенной проверкой пароля.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Выполняет вход пользователя, используя предоставленные имя пользователя и пароль.
     * @return bool успешно ли вошел пользователь в систему
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->setAttribute('auth_status', true);
            $user->save();

            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Находит пользователя по [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
