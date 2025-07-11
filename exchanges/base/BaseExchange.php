<?php

declare(strict_types=1);

namespace app\exchanges\base;

use app\components\ExchangeLogger;
use app\components\FtpClient;
use app\components\XmlJsonHelper;

abstract class BaseExchange
{
    protected FtpClient $ftp;
    protected ExchangeLogger $logger;
    protected string $remoteDir;
    protected string|false $localDir;

    public function __construct()
    {
        $this->ftp = new FtpClient();
        $this->logger = new ExchangeLogger(static::class);
        $this->remoteDir = '/ftp/exchange/' . static::class;
        $this->localDir = \Yii::getAlias('@runtime/exchange/' . str_replace('\\', '_', static::class));
        @mkdir($this->localDir, 0775, true);
    }

    public function process(): void
    {
        try {
            $this->ftp->connect();
            $files = $this->ftp->listFiles($this->remoteDir);
            foreach ($files as $f) {
                $local = "{$this->localDir}/$f";
                if (!$this->ftp->download("$this->remoteDir/$f", $local)) {
                    $this->logger->error("Не удалось скачать $f");
                    continue;
                }
                $this->logger->info("Скачан $f");
                $data = XmlJsonHelper::parse($local);
                $this->handle($data);
                unlink($local);
                $this->ftp->delete("$this->remoteDir/$f");
            }
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }

    abstract protected function handle(array $data): void;
}