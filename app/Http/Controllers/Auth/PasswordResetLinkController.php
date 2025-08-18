<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Security\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * Show the password reset link request page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/forgot-password', [
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'username' => 'required',
        ]);

        $user = User::where('username', $payload['username'])->first();
        dd($user);

        Password::sendResetLink(['email' => $user->person->email]);

        return back()->with('status', 'Un lien de réinitialisation sera envoyé à l\'adresse e-mail associée à ton compte.');
    }
}
