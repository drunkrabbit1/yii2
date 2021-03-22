<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{

    public function rules()
    {
        return [
            [['firstname', 'lastname', 'email', 'password', 'auth_key', 'access_token'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Находит пользователя по электронной почте
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getAttribute('id');
    }

    public function getFullName()
    {
        return "$this->firstname $this->lastname";
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }


    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->setAttribute('auth_key', \Yii::$app->security->generateRandomString());
            }
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($auth_key)
    {
        return $this->getAuthKey() === $auth_key;
    }

    /**
     * Проверяет пароль
     *
     * @param string $password пароль для проверки
     * @return bool если предоставленный пароль действителен для текущего пользователя
     */
    public function validatePassword($password)
    {
        if(is_null($this->getAttribute('password'))) {
            return false;
        }

        return \Yii::$app->security->validatePassword($password, $this->getAttribute('password'));
    }
}
