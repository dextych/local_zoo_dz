<?php

declare(strict_types=1);

namespace App;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger as MonologLogger;

final class Logger
{
    private static ?MonologLogger $logger = null;

    public static function get(): MonologLogger
    {
        if (self::$logger === null) {
            $directory = __DIR__ . '/../logs';

            if (!is_dir($directory)) {
                mkdir($directory, 0775, true);
            }

            self::$logger = new MonologLogger('trello');
            self::$logger->pushHandler(
                new StreamHandler(
                    $directory . '/app.log',
                    Level::Debug
                )
            );
        }

        return self::$logger;
    }
}
