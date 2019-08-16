<?php

namespace testAsk\logManager\components\targets;

use yii\base\Component;

abstract class Target extends Component
{
    abstract public function export(string $message, int $level);
}