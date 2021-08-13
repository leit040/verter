<?php

declare(strict_types=1);

namespace app\UseCase;




use App\Forms\TaskForm;
use app\models\Task;
use app\repositories\TaskRepository;

final class TaskManagementService

{

    private TaskRepository $TaskRepository;


    public function __construct(TaskRepository $TaskRepository)
    {

        $this->TaskRepository = $TaskRepository;

    }

    public function save(TaskForm  $form): Task
    {
        $task = Task::create($form->name, implode(";",$form->tasksList),$form->myObjectId);

            $this->TaskRepository->store($task);

        return $task;
    }

    public function update(int $id, TaskForm $form): Task
    {
        $task = $this->TaskRepository->get($id);

            $task->updateData($form->name, implode(";",$form->tasksList),$form->myObjectId);
            $this->TaskRepository->store($task);

        return $task;
    }



}