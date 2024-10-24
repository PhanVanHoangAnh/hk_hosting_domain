<?php
namespace App\Logging;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class UserActivityLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $logger = new Logger('custom');

        $date = date('Y_m_d');
        $logFile = storage_path("logs/user_activity/{$date}.log");

        $logger->pushHandler(new StreamHandler($logFile));

        return $logger;
    }
}