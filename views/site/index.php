<?php

use app\models\FeedbackForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model FeedbackForm */

$this->title = 'ТЗ Yii2';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <h3>Форма обратной связи</h3>
            <div class="col-lg-4">
                <?php $form = ActiveForm::begin(['action' => '/site/feedback']); ?>
                <?= Html::csrfMetaTags() ?>
                <?= $form->field($model, 'firstname') ?>

                <?= $form->field($model, 'lastname') ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'phone')
                    ->widget(MaskedInput::className(),['mask'=>'+7 (999) 999-99-99'])
                    ->textInput(['placeholder'=>'+7 (999) 999-99-99'])
                    ->label('Ваш Телефон') ?>

                <?= $form->field($model, 'body')->textarea() ?>

                <?= $form->field($model, 'reCaptcha')->widget(
                    \himiklab\yii2\recaptcha\ReCaptcha2::className()
                ) ?>
                <div class="form-group">
                    <?= Html::submitButton('оптравить',['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>
