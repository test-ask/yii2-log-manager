<?php

namespace testAsk\logManager\components;

use yii\base\Component;
use yii\di\Instance;

class Logger extends Component
{
    public const LEVEL_ERROR = 1;
    public const LEVEL_WARNING = 2;
    public const LEVEL_INFO = 3;

    public static $levels = [
        self::LEVEL_ERROR => 'error',
        self::LEVEL_WARNING => 'warning',
        self::LEVEL_INFO => 'info',
    ];

    /**
     * @var $dispatcher Dispatcher
     */
    public $dispatcher;

    public $categories = [];

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (!$this->dispatcher instanceof Dispatcher) {
            $this->dispatcher = Instance::ensure($this->dispatcher, Dispatcher::class);
        }
    }

    public function getDispatcher(): Dispatcher
    {
        return $this->dispatcher;
    }

    public function log($message, $level, $category)
    {
        $this->dispatcher->dispatch($message, $level, $category);
    }
}
