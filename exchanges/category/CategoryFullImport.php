<?php

declare(strict_types=1);

namespace app\exchanges\category;

use app\exchanges\base\BaseExchange;
use app\models\Category;

class CategoryFullImport extends BaseExchange
{
    protected function handle(array $data): void
    {
        Category::deleteAll();
        $this->logger->info("Удалены все старые категории");

        foreach ($data['category'] as $item) {
            $category = new Category();
            $category->attributes = $item;
            if (!$category->save()) {
                $this->logger->error("Ошибка сохранения категории ID={$item['id']}");
            } else {
                $this->logger->info("Категория ID={$item['id']} успешно сохранена");
            }
        }
    }
}