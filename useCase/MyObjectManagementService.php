<?php

declare(strict_types=1);

namespace app\useCase;



use app\filesystem\UrlGenerator;
use app\forms\MyObjectForm;
use app\models\MyObject;
use app\models\TransactionManager;
use app\repositories\MyObjectRepository;
use app\repositories\TaskRepository;
use yii\helpers\ArrayHelper;

final class MyObjectManagementService

{
    private TransactionManager $transactionManager;
    private MyObjectRepository $myObjectRepository;
    private TaskRepository $taskRepository;
    private TaskManagementService $taskManagementService;
    private UrlGenerator $urlGenerator;




    public function __construct(TransactionManager $transactionManager, MyObjectRepository $myObjectRepository,
                                 TaskRepository $taskRepository,TaskManagementService $taskManagementService,UrlGenerator $urlGenerator)
    {
        $this->transactionManager = $transactionManager;
        $this->myObjectRepository = $myObjectRepository;
        $this->taskRepository = $taskRepository;
        $this->taskManagementService = $taskManagementService;
        $this->urlGenerator = $urlGenerator;

    }

    public function save(MyObjectForm $form): MyObject
    {


        $myObject = MyObject::create($form->name, $this->urlGenerator->getPublicUrl($form->imagePath), $form->parentId);
        $this->transactionManager->wrap(function () use ($myObject,$form) {
            $this->myObjectRepository->store($myObject);

        foreach ($form->tasks as $task) {
            $task->myObjectId = $myObject->id;
            $this->taskManagementService->save($task);

        }

        });




        return $myObject;
    }


    public function update(int $myObjectId, MyObjectForm $form): MyObject
    {

        $myObject = $this->myObjectRepository->get($myObjectId);
        $oldIDs = ArrayHelper::map($myObject->tasks, 'id', 'id');
        $deleteIDs = array_diff($oldIDs, ArrayHelper::map($form->tasks, 'id', 'id'));

        if (!empty($deleteIDs)) {

            foreach ($deleteIDs as $id) {
            $model = $this->taskRepository->get($id);
            $this->taskRepository->delete($model);
           }
        }




      //  $this->transactionManager->wrap(function () use ($form, $myObject) {
            $myObject->updateData($form->name, $form->imagePath, $form->parentId);
            $this->myObjectRepository->store($myObject);

                      foreach ($form->tasks as $task) {
                if ($model = $this->taskRepository->findById($task->id)) {
                    $model = $this->taskManagementService->update($task->id, $task);
                } else {
                    if($task->id==0){
                    $task->myObjectId = $myObject->id;
                    $this->taskManagementService->save($task);
                    }
                }
            }



    //   });
        return $myObject;

    }

}