<?php

namespace testAsk\logManager\components;

use testAsk\logManager\components\targets\Target;
use testAsk\logManager\models\search\TargetSettingsSearch;
use testAsk\logManager\models\TargetSettingsModel;
use yii\base\Component;
use yii\di\Instance;

class Dispatcher extends Component
{
    public $targets = [];
    public $filteredTargets = [];
    public $storage;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if ($this->storage && !$this->storage instanceof Storage) {
            $this->storage = Instance::ensure($this->storage, Storage::class);
        }
    }

    public function getStorage(): Storage
    {
        return $this->storage;
    }

    public function dispatch($message, $level, $category)
    {
        if ($this->storage) {
            $this->getStorage()->save($message, $level, $category);
        }

        //todo is first message
        $this->filterTargets($category);

        foreach ($this->filteredTargets as $target) {
            $target->export($message, $level);
        }
    }

    public function filterTargets($category)
    {
        $targetClasses = array_column($this->targets, 'class');

        $targetSettings = TargetSettingsModel::getEnabledTargetSettings($targetClasses, $category);

        //todo cache targets
        foreach ($targetSettings as $targetSetting) {
            $conf = [
                'class' => $targetSetting->class
            ];
            $conf = array_merge(json_decode($targetSetting->params, true), $conf);
            $this->filteredTargets[$targetSetting->id] = \Yii::createObject($conf);
        }
    }
}