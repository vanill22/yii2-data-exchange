<?php

declare(strict_types=1);

namespace app\exchanges\products;

use app\exchanges\base\BaseExchange;
use app\models\Product;
use yii\db\Exception;

class ProductDeltaImport extends BaseExchange
{
    protected function handle(array $data): void
    {
        foreach ($data['product'] as $item) {
            $p = Product::findOne(['id' => $item['id']]) ?: new Product();
            $p->attributes = $item;
            try {
                if (!$p->save()) {
                    $this->logger->error("Ошибка сохранения продукта ID={$item['id']}");
                } else {
                    $this->logger->info("Продукт ID={$item['id']} сохранён");
                }
            } catch (Exception $e) {
            }
        }
    }
}