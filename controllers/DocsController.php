<?php

declare(strict_types=1);

namespace app\controllers;

use OpenApi\Generator;
use Yii;
use yii\web\Response;

final class DocsController extends BaseController
{
    /**
     * @OA\Info(title="Simple microservice API docs", version="0.1")
     */
    public function actionJson(): string
    {


         $openapi = Generator::scan([Yii::getAlias('@app/controllers'),Yii::getAlias('@app/Definitions')]);
            \Yii::$app->getResponse()->format = Response::FORMAT_RAW;
            \Yii::$app->getResponse()->getHeaders()->set('Content-Type', 'application/json');

            return $openapi->toJson();





    }

    protected function verbs(): array
    {
        return [];
    }
}
