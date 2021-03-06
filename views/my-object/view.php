<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\MyObject */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'My Objects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="my-object-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'label' => 'Image',
                'format' => 'raw',
                'value' => function($data){
                    return Html::img($data->image_path,[
                        'alt'=>'No image',
                        'style' => 'width:300px;'
                    ]);
                },
            ],
            ['label' =>'Parent Object','value' =>$model->parent->name],

        ],
    ]) ?>

    <?php
    foreach ($model->tasks as $task){
        echo DetailView::widget([
            'model' => $task,
            'attributes' => [
                'id',
                'name',
                'task_list'


            ],
        ]);

    }
    ?>

</div>


