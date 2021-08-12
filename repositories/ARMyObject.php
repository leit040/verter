<?php

namespace app\repositories;

use app\models\MyObject;
use yii\web\NotFoundHttpException;

class ARMyObject implements MyObjectRepository
{

    /**
     * @throws NotFoundHttpException
     */
    public function get(int $id): MyObject
    {
        if(($model = MyObject::findOne($id)) === null){
            throw new NotFoundHttpException(sprintf("Object not found with id '%s'", $id));
        }
    return $model;
    }

    public function store(MyObject $myObject): void
    {
        $myObject->save(false);
    }

    public function delete(MyObject $myObject): void
    {
       MyObject::deleteAll(['id' => $myObject->id]);
    }
}