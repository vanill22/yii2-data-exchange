<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%product}}';
    }

    public function rules(): array
    {
        return [['name', 'price'], 'required'];
    }
}