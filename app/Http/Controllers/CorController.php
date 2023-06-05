<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Cor;

class CorController extends Controller
{
    public function index()
    {
         $cores = Cor::paginate(10);
        return view('cores.index')->with('cores',$cores);
    }

    public function edit(Cor $cor)
    {
        return view('cores.edit')->with('cor',$cor);
    }

}
