<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * ContactForm is the model behind the contact form.
 */

/**
 * Class FeedbackForm
 * @package app\models
 */
class FeedbackForm extends ActiveRecord
{
    public $reCaptcha;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'email', 'phone', 'body'], 'required'],
            ['firstname', 'string', 'min' => 3, 'max' => 255],
            ['lastname', 'string', 'min' => 3, 'max' => 255],
            ['email', 'email'],
            [['phone'], 'match', 'pattern' => '/^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/'],
            ['body', 'string', 'min' => 100],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator2::className(),
                'uncheckedMessage' => 'Подтвердите, что вы не бот.'],
        ];
    }
}
