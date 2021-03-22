<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel */

use yii\grid\GridView;

$this->params['breadcrumbs'][] = ['label' => 'Backend', 'url' => '/backend/index'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="body-content">
    <div class="row">
        <div class="col-lg-12">
            <h3><?= $this->title ?></h3>
            <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
            ]);
            ?>
        </div>
    </div>
</div>
