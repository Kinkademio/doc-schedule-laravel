<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
      if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

      $request->validate([
        'current_password' => ['required', Password::defaults()],
        'new_password' => ['required','confirmed', Password::defaults()],
      ],
        [
          'current_password.required' => 'Поле "Текущий пароль" обязательное',
          'new_password.required' => 'Поле "Новый пароль" обязательное',
          'new_password.confirmed' => 'Новый пароль не совпадает с подтвержденным',
          'current_password.min' => 'В поле "Текущий пароль" должно быть не менее :min символов',
          'new_password.min' => 'В поле "Новый пароль" должно быть не менее :min символов',
        ]);

      $currentPasswordStatus = Hash::check($request->current_password, auth()->user()->password);

      if (!$currentPasswordStatus){
        return redirect()->back()->withErrors(['current_password' => 'Текущий пароль не совпадает со старым паролем']);
      }

      auth()->user()->forceFill([
        'password' => Hash::make($request->new_password),
      ])->save();

      return redirect()->back()->with('message', 'Пароль успешно изменен');
    }
}
