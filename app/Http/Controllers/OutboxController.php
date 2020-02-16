<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Outbox;

class OutboxController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
}
