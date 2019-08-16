<?php

namespace testAsk\logManager;

use testAsk\logManager\components\Logger;

class Log
{
    private static $_logger;

    /**
     * @return mixed
     */
    private static function getLogger()
    {
        if (static::$_logger !== null) {
            return static::$_logger;
        }

        return static::$_logger = \Yii::$app->logger;
    }

    /**
     * @param $message
     * @param string $category
     */
    public static function error($message, $category)
    {
        static::getLogger()->log($message, Logger::LEVEL_ERROR, $category);
    }

    /**
     * @param $message
     * @param string $category
     */
    public static function warning($message, $category)
    {
        static::getLogger()->log($message, Logger::LEVEL_WARNING, $category);
    }

    /**
     * @param $message
     * @param string $category
     */
    public static function info($message, $category)
    {
        static::getLogger()->log($message, Logger::LEVEL_INFO, $category);
    }
}
