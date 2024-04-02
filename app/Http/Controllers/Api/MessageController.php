<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store()
    {
        return response()->json([
            'success'=>true,
            'result'=>'Messaggio ricevuto correttamente.'
        ]);
    }
}
