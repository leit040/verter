<?php
namespace app\repositories;

use app\models\Task;

interface TaskRepository
{
  public function get(int $id):Task;

  public function store(Task $task):void;

  public function delete(Task $task):void;


}