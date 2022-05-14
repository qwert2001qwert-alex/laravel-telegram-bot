<?php

namespace App\Http\Controllers;

use App\Bot\Contracts\PhpTelegramBotContract;
use Longman\TelegramBot\Request;

class TestController extends Controller
{
    public function index(PhpTelegramBotContract $telegram)
    {

        $response = $telegram->getBotUsername();
        dd($response);

        return $this->responder->success(

        );
    }

    public function getUpdates(PhpTelegramBotContract $telegram)
    {
        try {
            $telegram->useGetUpdatesWithoutDatabase();
            $telegram->handleGetUpdates();
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }
}