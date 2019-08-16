<?php

namespace testAsk\logManager\components\targets;

/**
 * Class EventDbTarget
 * @package app\modules\event\components\targets
 */
class TelegramTarget extends Target
{
    public $token;

    public $chatId;

    /**
     * @param string $message
     * @param int $level
     */
    public function export(string $message, int $level)
    {
        $data = [
            'text' => $message,
            'chat_id' => $this->chatId
        ];

        file_get_contents("https://api.telegram.org/bot{$this->token}/sendMessage?" . http_build_query($data));
    }
}
