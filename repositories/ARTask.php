<?php

namespace app\repositories;

use app\models\Task;
use yii\web\NotFoundHttpException;

class ARTask implements TaskRepository
{

    /**
     * @throws NotFoundHttpException
     */
    public function get(int $id): Task
    {
        if(($model = Task::findOne($id)) === null){
            throw new NotFoundHttpException(sprintf("Task not found with id '%s'", $id));
        }
    return $model;
    }

    public function store(Task $task): void
    {
        $task->save(false);
    }

    public function delete(Task $task): void
    {
       Task::deleteAll(['id' => $task->id]);
    }

    public function findById($id): ?Task
    {
        return Task::findOne($id);
    }
}