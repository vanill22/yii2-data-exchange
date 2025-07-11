<?php

declare(strict_types=1);

namespace app\exchanges\products;

use app\exchanges\base\BaseExchange;
use app\models\Product;

class ProductFullImport extends BaseExchange
{
    protected function handle(array $data): void
    {
        Product::deleteAll();
        $this->logger->info("Удалены все старые товары");

        foreach ($data['product'] as $item) {
            $product = new Product();
            $product->attributes = $item;
            if (!$product->save()) {
                $this->logger->error("Ошибка сохранения товара ID={$item['id']}");
            } else {
                $this->logger->info("Товар ID={$item['id']} успешно сохранён");
            }
        }
    }
}