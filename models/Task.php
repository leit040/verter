<?php
declare(strict_types=1);

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $name
 * @property string $task_list
 * @property int $my_object_id
 *
 * @property MyObject $myObject
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'task_list', 'my_object_id'], 'required'],
            [['task_list'], 'string'],
            [['my_object_id'], 'integer'],
            [['name'], 'string', 'max' => 512],
            [['my_object_id'], 'exist', 'skipOnError' => true, 'targetClass' => MyObject::class, 'targetAttribute' => ['my_object_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'task_list' => Yii::t('app', 'Task List'),
            'my_object_id' => Yii::t('app', 'My Object ID'),
        ];
    }

    /**
     * Gets query for [[MyObject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMyObject(): \yii\db\ActiveQuery
    {
        return $this->hasOne(MyObject::class, ['id' => 'my_object_id']);


    }

    public function fields()
    {
        return [
            'id',
            'name',
            'tasksList'=>'task_list'
        ];
    }

    public static function create(string $name, string $taskList,int $objectId):self
    {
        $model = new self();
        $model->name = $name;
        $model->task_list = $taskList;
        $model->my_object_id = $objectId;
        return $model;

    }
    public function updateData(string $name, string $tasksList,int $objectId)
    {
        $this->name = $name;
        $this->task_list = $tasksList;
    }

}
