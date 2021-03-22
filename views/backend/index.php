<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;

$this->title = 'Backend';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <div class="body-content">
        <?= Html::a(
                'Все письма обратной связи',
                '/backend/list-feedback-all',
                ['class' => 'btn btn-primary']
        ) ?>
        <?= Html::a(
            'Письма обратной связи только авторизированых пользователей',
            '/backend/list-feedback-for-authorized',
            ['class' => 'btn btn-primary']
        ) ?>
    </div>
</div>
