<?php

namespace app\forms;

use app\models\MyObject;

class TaskForm extends \yii\base\Model

    /**
     * @OA\Schema(
     *     required={"name","taskLists","myObjectId"},
     *     title="Create Task form"
     * )
     */

{
    /**
     * @OA\Property(
     *     format="int",
     * )
     */
    public int $id = 0;
    /**
     * @OA\Property(
     *     format="string",
     * )
     */
public string $name = "";


    /**
     * @OA\Property(
     *     property="tasksList",
     *     type="array",
     *     @OA\Items(format="string"),
     * )
     */

public array $tasksList = [];

    /**
     * @OA\Property(
     *     format="integer",
     * )
     */
public ?int $myObjectId = 0;

    public function rules(): array
    {
        return [
            [['name', 'tasksList', 'myObjectId'], 'required'],
            [['tasksList'], 'safe'],
            [['myObjectId'], 'integer'],
            [['name'], 'string', 'max' => 512],
       //     [['myObjectId'], 'exist', 'skipOnError' => true, 'targetClass' => MyObject::class, 'targetAttribute' => ['myObjectId' => 'id']],
        ];
    }


}