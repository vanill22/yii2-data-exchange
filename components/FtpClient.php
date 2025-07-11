<?php

declare(strict_types=1);

namespace app\components;

class FtpClient
{
    public function connect(): void
    {
        // Логика подключения к FTP
    }

    public function download(string $remotePath, string $localPath): bool
    {
        // Скачивание файла
    }

    public function upload(string $localPath, string $remotePath): bool
    {
        // Загрузка файла
    }

    public function listFiles(string $directory): array
    {
        // Получение списка файлов
    }

    public function delete(string $remotePath): bool
    {
        // Удаление файла
    }
}