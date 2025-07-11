<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%order}}';
    }

    public function rules(): array
    {
        return [['external_id', 'status'], 'required'];
    }
}