<?php

declare(strict_types=1);

namespace app\exchanges\orders;

use app\exchanges\base\BaseExchange;
use app\models\Order;

class OrderExport extends BaseExchange
{
    protected function handle(array $data = []): void
    {
        $orders = Order::find()->where(['status' => 'new'])->asArray()->all();
        $payload = ['orders' => $orders];
        $file = "{$this->localDir}/export-".time().".json";
        file_put_contents($file, json_encode($payload, JSON_PRETTY_PRINT));
        $remote = $this->remoteDir . '/' . basename($file);
        if ($this->ftp->upload($file, $remote)) {
            $this->logger->info("Экспорт отправлен: {$remote}");
            foreach ($orders as $o) {
                $m = Order::findOne($o['id']);
                $m->status = 'sent';
                $m->save(false);
            }
        } else {
            $this->logger->error("Ошибка выгрузки заказа файл {$file}");
        }
    }
}