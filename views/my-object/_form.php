<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\forms\MyObjectForm */
/* @var $myObjects array */
/* @var $tasks2 array */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="my-object-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imagePath')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'parentId')->dropDownList(
        \yii\helpers\ArrayHelper::map($myObjects, 'id', 'name'),
        [
            'prompt' => 'Select Parent',
        ]
    ) ?>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 4, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $tasks2[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'name',
            'tasksList[]'
        ],
    ]); ?>
    <div class="container-items"><!-- widgetContainer -->
        <?php foreach ($tasks2 as $i => $task): ?>
            <div class="item panel panel-default"><!-- widgetBody -->
                <div class="panel-heading">
                    <h3 class="panel-title pull-left">Tasks</h3>
                    <div class="pull-right">
                        <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                        <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">

                    <?= $form->field($task, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($task, "[{$i}]tasksList[]")->textInput(['maxlength' => true]) ?>

                        </div>

                    </div><!-- .row -->
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php DynamicFormWidget::end(); ?>
</div>
</div>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
