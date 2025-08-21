<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Security\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class NewPasswordController extends Controller
{
    public function create(Request $request)
    {
        if (! $request->hasValidSignature()) {
            $request->session()->flash('error', 'Lien de réinitialisation invalide.');

            return redirect()->route('password.request');
        }

        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        $user = User::whereResetPasswordToken($request->route('token'))->first();

        if ($user === null) {
            session()->flash('error', 'Aucun utilisateur trouvé avec ce lien de réinitialisation.');
            return redirect()->route('password.request');
        }

        return Inertia::render('auth/reset-password', [
            'username' => $user->username,
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'token' => 'required',
            'username' => 'required',
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::whereUsername($payload['username'])->first();

        if ($user === null) {
            session()->flash('error', 'Aucun utilisateur trouvé avec ce nom d\'utilisateur.');
            return redirect()->route('password.request');
        }

        if ($user->reset_password_token !== $payload['token']) {
            session()->flash('error', 'Le lien de réinitialisation du mot de passe est invalide ou a expiré.');
            return redirect()->route('password.request');
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
            'reset_password_token' => null,
        ])->save();

        event(new PasswordReset($user));

        return to_route('login')->with('status', 'Ton mot de passe a bien été réinitialisé');
    }
}
