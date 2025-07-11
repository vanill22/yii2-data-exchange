<?php

declare(strict_types=1);

namespace app\exchanges\orders;

use app\exchanges\base\BaseExchange;
use app\models\Order;
use yii\db\Exception;

class OrderImport extends BaseExchange
{
    protected function handle(array $data): void
    {
        foreach ($data['order'] as $item) {
            if (!$order = Order::findOne(['external_id' => $item['external_id']])) {
                $order = new Order();
            }
            $order->attributes = $item;
            try {
                if (!$order->save()) {
                    $this->logger->error("Ошибка сохранения заказа {$item['external_id']}");
                } else {
                    $this->logger->info("Заказ {$item['external_id']} сохранён");
                }
            } catch (Exception $e) {
            }
        }
    }
}