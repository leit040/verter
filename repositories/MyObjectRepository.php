<?php
namespace app\repositories;

use app\models\MyObject;
use yii\base\Request;
use yii\data\ActiveDataProvider;


interface MyObjectRepository
{
  public function getAll(Request $request): ActiveDataProvider;

  public function get(int $id):MyObject;

  public function store(MyObject $myObject):void;

  public function delete(MyObject $myObject):void;

  public function findById($id):?MyObject;


}