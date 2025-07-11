<?php

declare(strict_types=1);

namespace app\components;

use Yii;

class ExchangeManager
{
    public function runAll(): void
    {
        $config = require Yii::getAlias('@app/config/exchange.php');
        foreach ($config['exchanges'] as $name => $exchangeConfig) {
            $this->run($name);
        }
    }

    public function run(string $exchangeName): void
    {
        $config = require Yii::getAlias('@app/config/exchange.php');
        if (!isset($config['exchanges'][$exchangeName])) {
            throw new \Exception("Exchange '$exchangeName' not found");
        }

        $class = $config['exchanges'][$exchangeName]['class'];
        /** @var \app\exchanges\base\BaseExchange $exchange */
        $exchange = new $class();
        $exchange->process();
    }
}