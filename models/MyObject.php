<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "my_object".
 *
 * @property int $id
 * @property string $name
 * @property string $image_path
 * @property int|null $parent_id
 *
 * @property MyObject $my_objects
 * @property Task[] $tasks
 */
class MyObject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'my_object';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'image_path'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 512],
            [['image_path'], 'string', 'max' => 1024],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => MyObject::class, 'targetAttribute' => ['parent_id' => 'id']],
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
            'image_path' => Yii::t('app', 'Image Path'),
            'parent_id' => Yii::t('app', 'Parent ID'),
        ];
    }

    /**
     * Gets query for [[MyObjects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMyObjects(): \yii\db\ActiveQuery
    {
        return $this->hasMany(MyObject::class, ['parent_id' => 'id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery*/
    public function getParent(): \yii\db\ActiveQuery
    {
        return $this->hasOne(MyObject::class, ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Task::class, ['my_object_id' => 'id']);
    }
    public function fields(): array
    {
        return[
            'id',
            'name',
            'imagePath'=>'image_path',

        ];
    }

    public function extraFields(): array
    {
        return [
        'childObject'=>function(){
      return $this->getMyObjects();
    },
            'tasks'=>function(){
            return $this->getTasks();
            }

    ];
    }

    public static function create(string $name,string $imagePath,?int $parentId ):self
    {
        $model = new self();
        $model->name =$name;
        $model->image_path = $imagePath;
        $model->parent_id = $parentId ? $parentId : 0;
        return $model;
    }
    public function updateData(string $name,string $imagePath,?int $parentId)
    {
        $this->name = $name;
        $this->image_path = $imagePath;
        $this->parent_id = $parentId ? $parentId : 0;
    }
}
