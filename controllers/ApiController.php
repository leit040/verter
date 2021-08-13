<?php

namespace app\controllers;

use app\forms\MyObjectForm;
use app\forms\TaskForm;
use app\models\MyObject;
use app\models\Task;
use app\repositories\MyObjectRepository;
use app\Response\EmptyResponse;
use app\useCase\MyObjectManagementService;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;


class ApiController extends BaseController
{

    protected function verbs(): array
    {
        return [
            'create' => ['POST'],
            'update' => ['PUT'],
            'delete' => ['DELETE'],
            'index' => ['GET'],
            'view' => ['GET'],
        ];
    }

    /**
     * @OA\Get(
     *     path="/myobjects/list",
     *     tags={"MyObjects"},
     *     summary="Get Myobjects",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/MyObject")),
     *              @OA\Property(property="_meta", type="object", ref="#/components/schemas/Meta"),
     *          )
     *     )
     * )
     */

    public function actionIndex(MyObjectRepository $myObjectRepository): ActiveDataProvider
    {

        return $myObjectRepository->getAll($this->request);


    }

    /**
     * @OA\Get(
     *     path="/myobjekts/view",
     *     tags={"MyOObjects"},
     *     summary="Get specific MyObject",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/MyObject")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="MyObject id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )),
     *     @OA\Parameter(
     *         name="expand",
     *         in="query",
     *         description="tasks",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )),
     *     )
     * )
     */


    public function actionView(int $id, MyObjectRepository $myObjectRepository): MyObject
    {
        return $myObjectRepository->get($id);

    }


    /**
     * @OA\Post(
     *     path="/MyObject/create",
     *     tags={"MyObject"},
     *     summary="Create MyObject member",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/MyObject")),
     *     @OA\RequestBody(
     *         description="Requested body",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/MyObjectCreateForm"),
     *     )
     * )
     */


    public function actionCreate(MyObjectManagementService $myObjectManagementService, MyObjectRepository $myObjectRepository): MyObject|MyObjectForm
    {

        $form = new MyObjectForm();
        $this->load($form);
        if ($myObjectData = \Yii::$app->getRequest()->getBodyParam('tasks') !== null) {
            $form->tasks = ArrayHelper::getColumn($form->tasks, function ($arrayData) {
                return new TaskForm($arrayData);
            });
        }


        if ($form->validate()) {
            return $myObjectManagementService->save($form);

        }
        return $form;

    }


    public function actionUpdate(int $id, MyObjectManagementService $myObjectManagementService, MyObjectRepository $myObjectRepository): MyObjectForm|MyObject
    {

        $form = new MyObjectForm();
        $this->load($form);
        if ($myObjectData = \Yii::$app->getRequest()->getBodyParam('tasks') !== null) {
            $form->tasks = ArrayHelper::getColumn($form->tasks, function ($arrayData) {
                return new TaskForm($arrayData);
            });
        }


        if ($form->validate()) {
            return $myObjectManagementService->update($id,$form);

        }
        return $form;

    }


    public function actionDelete(int $id, MyObjectRepository $myObjectRepository): EmptyResponse
    {
        $myObjectRepository->delete($myObjectRepository->get($id));

        return new EmptyResponse(204);
    }


}