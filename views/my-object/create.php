<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\forms\MyObjectForm */
/* @var $myObjects array */
/* @var $tasks2 array */

$this->title = Yii::t('app', 'Create My Object');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'My Objects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-object-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'myObjects' => $myObjects,
        'tasks2' => $tasks2,
    ]) ?>

</div>
