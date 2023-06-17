<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ClientePost;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use PDF;
use Mail;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ClienteRequest;


class UserController extends Controller
{
    public function index(Request $request): View
    {
        $filterByNome = $request->nome ?? '';
        $userQuery = User::query();
        if ($filterByNome !== ''){
            $userIds = User::where('name', 'like', "%$filterByNome%")->pluck('id');
            $userQuery->whereIntegerInRaw('id', $userIds);
        }
        $users = $userQuery->paginate(5);
        return view('users.index', compact('users', 'filterByNome'));
    }
}
