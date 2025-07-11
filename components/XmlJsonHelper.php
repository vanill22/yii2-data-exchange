<?php

declare(strict_types=1);

namespace app\components;

class XmlJsonHelper
{
    public static function parse(string $file): array
    {
        $data = file_get_contents($file);
        if (stripos($file, '.xml')) {
            $xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
            return json_decode(json_encode($xml), true);
        }
        return json_decode($data, true);
    }
}