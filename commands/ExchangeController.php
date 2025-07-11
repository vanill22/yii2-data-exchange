<?php

declare(strict_types=1);

namespace app\commands;

use yii\web\Controller;
use app\components\ExchangeManager;

class ExchangeController extends Controller
{
    public function actionFullProducts(string|null $name = null): void
    {
        $manager = new ExchangeManager();

        if ($name) {
            $manager->run($name);
        } else {
            $manager->runAll();
        }
    }
}