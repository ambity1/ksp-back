<?php

namespace App\Http\Controllers;

use App\Services\ExchangeService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ExchangeController extends BaseController
{

    private ExchangeService $exchangeService;

    public function __construct(ExchangeService $exchangeService)
    {
        $this->exchangeService=$exchangeService;
    }

    public function exchange(Request $request){
        $mode = $request->get('mode');
        Log::info('mode: ' .$mode);
        ini_set('memory_limit', '256M');

        switch ($mode){
            case 'checkauth':
                $authHeader = explode(' ', $request->header('authorization'));
                $tokenWithoutBase64 = base64_decode($authHeader[1]);
                $data = explode(':', $tokenWithoutBase64);
                if ($data[0] == 'admin' && $data[1] == 'admin'){
                    return response('success');
                }
                break;
            case 'init':
                return response("zip=no\nfile_limit=104857600");
            case 'file':
                $this->exchangeService->parseFile($request->getContent(), $request->get('filename'));
                return response('success');
        }
        return null;
    }

}
