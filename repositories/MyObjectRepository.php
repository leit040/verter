<?php
namespace app\repositories;

use app\models\MyObject;

interface MyObjectRepository
{
  public function get(int $id):MyObject;

  public function store(MyObject $myObject):void;

  public function delete(MyObject $myObject):void;


}