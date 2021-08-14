<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\service\MyObjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'My Objects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-object-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create My Object'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'label' => 'Image',
                'format' => 'raw',
                'value' => function($data){
                    return Html::img($data->image_path,[
                        'alt'=>'No image',
                        'style' => 'width:150px;'
                    ]);
                },
            ],
            ['label' =>'Parent Object','value' =>'parent.name'],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
