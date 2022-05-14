<?php

namespace App\Bot\Commands;

use Longman\TelegramBot\Request;
use Longman\TelegramBot\Commands\SystemCommand;

/**
 * Callback query command
 *
 * This command handles all callback queries sent via inline keyboard buttons.
 *
 * @see InlinekeyboardCommand.php
 */
class CallbackqueryCommand extends SystemCommand
{

    /**
     *
     * @var string
     */
    protected $name = 'callbackquery';

    /**
     *
     * @var string
     */
    protected $description = 'Reply to callback query';

    /**
     *
     * @var string
     */
    protected $version = '1.0';

    /**
     * Command execute method
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute(): \Longman\TelegramBot\Entities\ServerResponse
    {
        if (! $this->getCallbackQuery()) {
            return Request::emptyResponse();
        }

        $chat_id = $this->getCallbackQuery()
            ->getMessage()
            ->getChat()
            ->getId();

        $message_id = $this->getCallbackQuery()->getMessage()->getMessageId();

        // 1. Delete message to hide buttons
        Request::deleteMessage([
            'chat_id' => $chat_id,
            'message_id' => $message_id
        ]);

        // 2. Send text to chat
        $callback_query = $this->getCallbackQuery();
        $callback_query_id = $callback_query->getId();
        $callback_data = $callback_query->getData();

        $data = [
            'text' => 'You picked' . $callback_data,
            'channel_id' => $chat_id
        ];
        Request::sendMessage($data); // Not working :-(

        // 3. Answer callbackquery
        // Debug
        $data = [
            'callback_query_id' => $callback_query_id,
            'cache_time' => 5
        ];

        return Request::answerCallbackQuery($data);
    }
}
