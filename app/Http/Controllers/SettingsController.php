<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;

class SettingsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = Settings::all();
        
        // dd($delivery_notifications);
        
        return view('settings/index', compact('data'));
    }

    public function edit($id)
    {
        //
        $data = Settings::findOrFail($id);
        
        // dd($delivery_notifications);
        
        return view('settings/update', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        //
        $data = Settings::findOrFail($id);
        $data->update([
            "id" => $id,
            "description" => $req->description,
            "value" => $req->value
        ]);

        return redirect()->route('settings.index')
                        ->with('success','Settings updated successfully');
    }
}