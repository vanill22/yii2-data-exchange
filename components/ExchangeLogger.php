<?php

declare(strict_types=1);

namespace app\components;

class ExchangeLogger
{
    private string $file;

    public function __construct(string $name)
    {
        $dir = \Yii::getAlias('@app/runtime/exchange-logs');
        if (!is_dir($dir)) mkdir($dir, 0775, true);
        $this->file = "$dir/$name.log";
    }

    public function info(string $msg): void
    {
        $this->write('INFO', $msg);
    }

    public function error(string $msg): void
    {
        $this->write('ERROR', $msg);
    }

    private function write(string $level, string $msg): void
    {
        file_put_contents($this->file, date('c') . " [$level] $msg\n", FILE_APPEND);
    }
}