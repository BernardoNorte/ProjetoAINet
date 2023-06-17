<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\userPost;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use PDF;
use Mail;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\userRequest;



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
        $userQuery->whereIn('user_type', ['A','E']);
        $users = $userQuery->paginate(5);
        return view('users.index', compact('users', 'filterByNome'));
    }

    public function create(): View
    {
        $newUser = new User();
        return view('users.create')->withUser($newUser);
    }

    public function show(User $user): View
    {
        return view('users.show')->withUser($user);
    }

    public function edit(User $user): View
    {

        return view('users.edit')->withuser($user);
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $formData = $request->validated();
        $user = DB::transaction(function () use ($formData, $user){
            $user->name = $formData['name'];
            $user->email = $formData['email'];
            $user->blocked = $formData['blocked'];
            $user->save();
            if ($request->hasFile('file_foto')) {
                if ($user->user->photo_url){
                    Storage::delete('public/photos/' . $user->user->photo_url);
                }
                $path = $request->photo_url->store('public/photos');
                $user->user->photo_url = basename($path);
                $user->save();
            }
            return $user;
        });
        $url = route('users.index', ['user' => $user]);
        $htmlMessage = "user <a href='$url'>#{$user->id}</a>
                        <strong>\"{$user->user->name}\"</strong> foi alterado com sucesso!";
        return redirect()->route('users.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function store(Request $request): RedirectResponse
    {
        User::create($request->all());
        return redirect()->route('users.index');
    }

    public function destroy_foto(User $user): RedirectResponse
    {
        if ($user->photo_url){
            Storage::delete('public/photos/' . $user->photo_url);
            $user->photo_url = null;
            $user->save();
        }

        return redirect()->route('users.edit', ['user' => $user])
            ->with('alert-msg', 'user Photo "' . $user->name . '"was removed!')
            ->with('alert-type', ' Success');
    }
}
