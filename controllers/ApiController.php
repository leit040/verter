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
     *     path="/my-objects/list",
     *     tags={"MyObjects"},
     *     summary="Get MyObjects",
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
     *     tags={"MyObjects"},
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
     *     tags={"MyObjects"},
     *     summary="Create MyObject ",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/MyObjectForm")),
     *     @OA\RequestBody(
     *         description="Requested body",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/MyObject"),
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


    /**
     * @OA\Put(
     *     path="/MyObject/update",
     *     tags={"MyObjects"},
     *     summary="Update MyObject ",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/MyObject")),
     *     @OA\RequestBody(
     *         description="Requested body",
     *         required=true,
     *          @OA\JsonContent(ref="#/components/schemas/MyObjectForm")),
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="MyObject id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     )
     * )
     */

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

    /**
     * @OA\Delete (
     *     path="/MyObject/delete",
     *     tags={"MyObjects"},
     *     summary="Update MyObject ",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="MyObject id",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="successful operation"
     *     )
     * )
     */

    public function actionDelete(int $id, MyObjectRepository $myObjectRepository): EmptyResponse
    {
        $myObjectRepository->delete($myObjectRepository->get($id));

        return new EmptyResponse(204);
    }


}