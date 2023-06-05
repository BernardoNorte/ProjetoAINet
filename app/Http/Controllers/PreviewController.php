<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreviewController extends Controller
{
    public function index(Request $request)
    {
        return view('preview.index')->with('tshirt',$request->tshirt)->with('estampa',$request->estampa);
    }
}
