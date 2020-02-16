<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class SongsController extends Controller
{
    //
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create('App\Forms\SongForm', [
            'method' => 'POST',
            'url' => route('transactions.store')
        ]);

        return view('transactions.create', compact('form'));
    }
}
