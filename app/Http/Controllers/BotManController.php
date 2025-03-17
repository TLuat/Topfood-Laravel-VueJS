<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;

class BotManController extends Controller
{
    public function handle(Request $request)
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        $config = config('botman.telegram');

        $botman = BotManFactory::create($config);

        $botman->hears('hello', function (BotMan $bot) {
            $bot->reply('Hi there!');
        });

        $botman->listen();
    }
}

