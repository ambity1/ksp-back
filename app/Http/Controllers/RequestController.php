<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;
use Log;

class RequestController extends Controller
{
    public function requestTG(Request $request){
        $number = $request['phone'];

        $uriTG = 'https://api.telegram.org/bot';
        $token = '6420278819:AAGc1QWOW0jSI8Ca50JhHnRbxZiWhm6Z1Fc';
        $action = '/sendMessage?';
        $chatID = '-4280557492';

        $formAnswer = 'Заявка с сайта. Номер телефона: ' . $number;

        $requestEncode = htmlspecialchars(urlencode($formAnswer));

        $responseTelegram = Http::get($uriTG . $token . $action . 'chat_id=' . $chatID . '&text=' . $requestEncode);
        if (!$responseTelegram->ok()){
            Log::info("request to telegram bot is not ok");
            return response()->json(['status' => 'not ok']);
        }
        return response()->json(['status' => 'ok']);
    }
}
