<?php

namespace App\Http\Controllers;

use App\Models\Buy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function adminUsers() {
        return view('users.adminUsuarios', [
            'usuarios' => User::all()
        ]);
    }

    public function compras(int $id) {
        return view('users.compras', [
            'usuario' => User::with('buys.products')->findOrFail($id)
        ]);
    }

    public function edit(int $id) {
        return view('users.edit', [
            'usuario' => User::findOrFail($id),
        ]);
    }

    public function update(Request $request, int $id) {
        $request->validate([
        'name' => 'required|min:5|max:255',
        'email' => 'required|min:5|max:255|email',
      ],
      [
        'name.required' => 'El nombre es obligatorio',
        'name.min' => 'El nombre debe tener más de 5 caracteres',
        'name.max' => 'El nombre no debe tener más de 255 caracteres', 
        'email.required' => 'El email es obligatorio',
        'email.min' => 'El email debe tener más de 5 caracteres',
        'email.max' => 'El email no debe tener más de 255 caracteres',
        'email.email' => 'El email debe contener @'
      ]);

      $data = $request->only(['name', 'email']);

      
      $user = User::findOrFail($id);
      $user->update($data);

      return to_route('users.adminUsuarios')
        ->with('feedback.message', 'El usuario <b>' . e($data['name']) . '</b> se editó con éxito.');
    }

    public function perfil() {
        $userId = Auth::id();
        return view('users.perfil', [
            'user' => User::with(['buys.products'], ['profile'])->findOrFail($userId),
        ]);
    }

    public function editName() {
        $userId = Auth::id();
        return view('users.editName', [
            'user' => User::findOrFail($userId),
        ]);
    }

    public function updateName(Request $request) {
        $request->validate([
            'name' => 'required|min:3|max:255'
        ], 
        [
            'name.required' => 'El nombre es obligatorio',
            'name.min' => 'El nombre debe tener más de 5 caracteres',
            'name.max' => 'El nombre no debe tener más de 255 caracteres', 
        ]);

        $data = $request->only(['name']);

        $user = User::findOrFail(Auth::id());
        $user->update($data);

        return to_route('users.perfil')
        ->with('feedback.message', 'Nombre editado con éxito.');
    }

    public function editAvatar() {
        $userId = Auth::id();
        return view('users.editAvatar', [
            'user' => User::with('profile')->findOrFail($userId),
        ]);
    }

    public function updateAvatar(Request $request) {
        $request->validate([
            'avatar' => 'required'
        ], 
        [
            'avatar.required' => 'El avatar es obligatorio',
        ]);


        $user = User::with('profile')->findOrFail(Auth::id());
        
        
        $avatar = $request->file('avatar')->store('avatars', 'public');
        $user->profile()->update([
            'avatar' => $avatar
        ]);


        return to_route('users.perfil')
        ->with('feedback.message', 'Avatar editado con éxito.');
    }

    public function editInformacion() {
        $userId = Auth::id();
        return view('users.editInformacion', [
            'user' => User::with('profile')->findOrFail($userId),
        ]);
    }

    public function updateInformacion(Request $request) {
        $request->validate([
            'direccion' => 'required|min:5|max:255'
        ], 
        [
            'direccion.required' => 'El nombre es obligatorio',
            'direccion.min' => 'El nombre debe tener más de 5 caracteres',
            'direccion.max' => 'El nombre no debe tener más de 255 caracteres', 
        ]);

        $user = User::with('profile')->findOrFail(Auth::id());
        $user->profile->direccion = $request['direccion'];
        $user->profile->save();

        return to_route('users.perfil')
        ->with('feedback.message', 'Información editada con éxito.');
    }
}
