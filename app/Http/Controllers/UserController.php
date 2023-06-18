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
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;


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

    public function store(UserRequest $request): RedirectResponse
    {
        $formData = $request->validated();
        $user = DB::transaction(function () use ($formData, $request){
            $newUser = new User();
            $newUser->name = $formData['name'];
            $newUser->email = $formData['email'];
            $newUser->blocked = $formData['blocked'];
            $newUser->user_type = $formData['user_type'];
            $newUser->password = Hash::make($formData['password_inicial']);
            $newUser->save();
            if ($request->hasFile('file_foto')) {
                $path = $request->file_foto->store('public/photos');
                $newUser->photo_url = basename($path);
                $newUser->save();
            }
            return $newUser;
        });
        $url = route('users.show', ['user' => $user]);
        $htmlMessage = "User <a href='$url'>#{$user->id}</a>
                        <strong>\"{$user->name}\"</strong> was created with success!";
        return redirect()->route('users.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');


    }

    public function show(User $user): View
    {
        return view('users.show')->withUser($user);
    }

    public function edit(User $user): View
    {

        return view('users.edit')->withUser($user);
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $formData = $request->validated();
        $user = DB::transaction(function () use ($formData, $user, $request){
            $user->name = $formData['name'];
            $user->email = $formData['email'];
            $user->blocked = $formData['blocked'];
            $user->user_type = $formData['user_type'];
            $user->save();
            if ($request->hasFile('file_foto')) {
                if ($user->photo_url){
                    Storage::delete('public/photos/' . $user->photo_url);
                }
                $path = $request->file_foto->store('public/photos');
                $user->photo_url = basename($path);
                $user->save();
            }
            return $user;
        });
        $url = route('users.show', ['user' => $user]);
        $htmlMessage = "user <a href='$url'>#{$user->id}</a>
                        <strong>\"{$user->name}\"</strong> foi alterado com sucesso!";
        return redirect()->route('users.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function destroy(User $user): RedirectResponse
    {
        try {
                if ($user->photo_url) {
                    Storage::delete('public/fotos/' . $user->photo_url);
                }
                $user->delete();
                $htmlMessage = "User #{$user->id}
                        <strong>\"{$user->name}\"</strong> foi apagado com sucesso!";
                return redirect()->route('users.index')
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', 'success');
        } catch (\Exception $error) {
            $url = route('users.show', ['user' => $user]);
            $htmlMessage = "Não foi possível apagar o user <a href='$url'>#{$user->id}</a>
                        <strong>\"{$user->name}\"</strong> porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
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
