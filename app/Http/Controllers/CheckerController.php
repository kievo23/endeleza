<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Checker;

class CheckerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $checkers = Checker::orderBy('created_at','desc')->get();
        return view('checkers/index', compact('checkers'));
    }

    public function approve($checkerId){
        $approval = Checker::findOrFail($checkerId);
        $approval->is_approved = "Approved";
        $approval->approved_by = auth()->user()->id;
        $approval->save();
        $model = unserialize($approval->values);
        if($approval->operation == 'DELETE'){
            $model->delete();
        }else{
            $model->save();
        }
        return redirect()->route('checker.index')
                        ->with('success','You have successfully implemented the new changes');
    }

    public function drop($checkerId){
        $approval = Checker::findOrFail($checkerId);
        $approval->is_approved = "Denied";
        $approval->approved_by = auth()->user()->id;
        $approval->save();
        return redirect()->route('checker.index')
                        ->with('success','You have successfully refused the change');
    }
}
