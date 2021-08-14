<?php

namespace app\controllers;

use app\Filesystem\UrlGenerator;
use app\forms\MyObjectForm;
use app\forms\TaskForm;
use app\models\MyObject;
use app\models\service\MyObjectSearch;
use app\repositories\MyObjectRepository;
use app\useCase\MyObjectManagementService;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MyObjectController implements the CRUD actions for MyObject model.
 */
class MyObjectController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all MyObject models.
     * @return mixed
     */
    public function actionIndex(MyObjectRepository $myObjectRepository)
    {
        $searchModel = new MyObjectSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
       // $dataProvider =  $myObjectRepository->getAll($this->request);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MyObject model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id, MyObjectRepository $myObjectRepository): string
    {
        return $this->render('view', [
            'model' => $myObjectRepository->findById($id),
        ]);
    }

    /**
     * Creates a new MyObject model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(MyObjectManagementService $myObjectManagementService)
    {
        $form = new MyObjectForm;
        $tasks2 =  [ new TaskForm];

        if ($this->request->isPost) {
           $form->load(Yii::$app->getRequest()->getBodyParams());

        if (\Yii::$app->getRequest()->getBodyParam('TaskForm') !== null) {
            $form->tasks = ArrayHelper::getColumn(\Yii::$app->getRequest()->getBodyParam('TaskForm'), function ($arrayData) {
                return new TaskForm($arrayData);
            });
        }

        if ($form->validate()) {
            $model = $myObjectManagementService->save($form);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        }
        $myObjects = MyObject::find()->all();
            return $this->render('create', [
            'model' => $form,
            'myObjects' => $myObjects,
            'tasks2' => (empty($tasks2)) ? [new TaskForm()] : $tasks2
        ]);
    }

    /**
     * Updates an existing MyObject model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MyObject model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MyObject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MyObject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MyObject::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function load(Model $model)
    {
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
    }
}
