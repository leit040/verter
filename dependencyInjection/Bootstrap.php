<?php

declare(strict_types=1);

namespace app\DependencyInjection;

use app\filesystem\UrlGenerator;
use app\models\TransactionManager;
use app\repositories\ARMyObject;
use app\repositories\ARTask;
use app\repositories\MyObjectRepository;
use app\repositories\TaskRepository;
use app\useCase\MyObjectManagementService;
use app\useCase\TaskManagementService;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemWriter;
use League\Flysystem\Local\LocalFilesystemAdapter;
use yii\base\BootstrapInterface;
use yii\web\UrlManager;

final class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;
        $container->setSingleton(TransactionManager::class);
        $container->setSingleton(MyObjectManagementService::class);
        $container->setSingleton(TaskManagementService::class);
        $container->setSingleton(TaskRepository::class,ARTask::class);
        $container->setSingleton(MyObjectRepository::class,ARMyObject::class);
        $container->setSingleton(Filesystem::class, function () {
            $adapter = new LocalFilesystemAdapter(\dirname(__DIR__) . '/../web/storage');

            return new Filesystem($adapter);
        });
        $container->setSingleton(FilesystemWriter::class, Filesystem::class);
        $container->setSingleton(UrlManager::class, $app->urlManager);
        $container->setSingleton(UrlGenerator::class, UrlGenerator::class);
    }
}
