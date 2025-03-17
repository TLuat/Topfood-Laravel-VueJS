<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{

    public function sendMessage(Request $request)
    {
        // $apiKey = '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'; // Thay thế bằng API key của bạn
        // $url = 'https://api.openai.com/v1/chat/completions';

        // $client = new Client();

        // $response = $client->post($url, [
        //     'headers' => [
        //         'Authorization' => 'Bearer ' . $apiKey,
        //         'Content-Type' => 'application/json',
        //     ],
        //     'json' => [
        //         'messages' => [['role' => 'system', 'content' => 'You are a helpful assistant.']],
        //         'user' => ['id' => '1', 'name' => 'user'],
        //     ],
        // ]);

        // $data = json_decode($response->getBody()->getContents(), true);

        // return response()->json(['reply' => $data['choices'][0]['message']['content']]);
        dd($request->message);
    }
}
