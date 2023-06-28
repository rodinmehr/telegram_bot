<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Models\TelegraphChat;

class TelegramController extends Controller
{
    private $telegram_token;
    private $telegram_name;
    private $telegram_chat_id;
    private $telegram_bot_log_id;
    private $telegram_sms_bot_log_id;

    public function __construct()
    {
        $this->telegram_token = env('TELEGRAM_TOKEN', '0');
        $this->telegram_name = env('TELEGRAM_NAME', '0');
        $this->telegram_chat_id = env('TELEGRAM_CHAT_ID', '0');
        $this->telegram_bot_log_id = env('TELEGRAM_BOT_LOG_ID', '0');
        $this->telegram_sms_bot_log_id = env('TELEGRAM_SMS_BOT_LOG_ID', '0');
    }

    public function index()
    {
        $bot = TelegraphBot::where('token', $this->telegram_token)->first();
        if ($bot == null) {
            $bot = TelegraphBot::create([
                'token' => $this->telegram_token,
                'name' => $this->telegram_name,
            ]);
        }

        $chat = $bot->chats->where('chat_id', $this->telegram_chat_id)->first();

        if ($chat == null) {
            $chat = $bot->chats()->create([
                'chat_id' => $this->telegram_chat_id,
                'name' => $this->telegram_name,
            ]);
        }

        $chat->html("TEST:<strong>Hello!</strong>\n\nI'm here!")->send();
    }
}
