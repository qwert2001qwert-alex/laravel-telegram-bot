<?php

namespace App\Bot\Commands;

use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class StartCommand extends UserCommand
{
    protected $name = 'start';
    protected $description = 'Запуск бота';
    protected $usage = '/start';

    public function execute(): ServerResponse
    {
        $chat_id = $this->getMessage()
            ->getChat()
            ->getId();

        $inline_keyboard = new InlineKeyboard([
            [
                'text' => 'Chicken',
                'callback_data' => 'command_chicken'
            ],
            [
                'text' => 'Beef',
                'callback_data' => 'command_beef'
            ]
        ]);
        $inline_keyboard->setSelective(true);
        $inline_keyboard->setOneTimeKeyboard(true);

        $data = [
            'chat_id' => $chat_id,
            'text' => 'Pick your choice',
            'reply_markup' => $inline_keyboard,
            'reply_to_message_id' => $this->getMessage()->getMessageId(),
            'selective' => true
        ];

        return Request::sendMessage($data);


    }
}
