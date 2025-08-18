<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\InvitationAcceptRequest;
use App\Models\Security\Invitation;
use App\Models\Security\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class InvitationController extends Controller
{
    public function show(Request $request, Invitation $invitation)
    {
        if (! $request->hasValidSignature()) {
            $request->session()->flash('error', "Lien d'invitation invalide.");
            return Inertia::render('auth/login');
        }

        if (Auth::check() && $request->user()->licence === $invitation->licence) {
            $invitation->delete();
            return redirect()->route('dashboard');
        }

        if ($invitation->isExpired()) {
            $invitation->delete();
            $request->session()->flash('error', "Lien d'invitation expiré.");

            return Inertia::render('auth/login');
        }

        return Inertia::render('public/invite', [
            'invitation' => $invitation,
        ]);
    }

    public function accept(InvitationAcceptRequest $request, Invitation $invitation)
    {
        if (Auth::check() && $request->user()->licence === $invitation->licence) {
            $invitation->delete();
            return redirect()->route('dashboard');
        }

        if ($invitation->isExpired()) {
            $invitation->delete();
            $request->session()->flash('error', "Lien d'invitation expiré.");

            return Inertia::render('auth/login');
        }

        $payload = $request->safe()->all();
        $passwordHash = Hash::make($payload['password']);

        $user = User::create([
            'username' => $payload['username'],
            'password' => $passwordHash,
            'licence' => $invitation->licence,
            'firstname' => $invitation->firstname,
            'lastname' => $invitation->lastname,
            'role' => $invitation->role,
        ]);

        Auth::login($user);

        $invitation->delete();
        $request->session()->flash('success', 'Invitation acceptée avec succès. Bienvenue !');

        return redirect()->route('dashboard');
    }
}
