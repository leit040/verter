<?php

namespace app\forms;

use app\models\MyObject;
use yii\base\Model;

class MyObjectForm extends \yii\base\Model

    /**
     * @OA\Schema(
     *     required={"name","imagePath","parentId"},
     *     title="Create MyObject form"
     * )
     */

{
    /**
     * @OA\Property(
     *     format="string",
     * )
     */
public string $name = "";

    /**
     * @OA\Property(
     *     format="string",
     * )
     */
    public string $imagePath = "";


    /**
     * @OA\Property(property="employeeFamily", type="array", @OA\Items(ref="#/components/schemas/TaskForm")),
     * )
     */

public array $tasks = [];

    /**
     * @OA\Property(
     *     format="integer",
     * )
     */
public ?int $parentId = 0;

    public function rules(): array
    {
        return [
            [['name','imagePath'  ], 'required'],
            [['parentId'], 'parentIdValidator'],
            [['name'], 'string', 'max' => 512],
            [['tasks'], 'tasksValidator'],
        ];
    }

    public function parentIdValidator($attribute,$params){
        if($this->parentId == 0){
            return true;
        }
        if(!MyObject::findOne($this->parentId))
        {
            $this->addError('parentId', \Yii::t('app', 'Invalid parentId.'));
        }
            }

    public function tasksValidator($attribute,$params)
    {

        if (!Model::validateMultiple($this->tasks)) {
            {
                $this->addError('tasks', \Yii::t('app', 'Invalid input on tasks.'));

            }

        }
    }

}