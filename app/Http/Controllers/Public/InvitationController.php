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
            return redirect()->route('login');
        }

        if (Auth::check() && $request->user()->person_id === $invitation->person_id) {
            $invitation->delete();
            return redirect()->route('dashboard');
        }

        if ($invitation->isExpired()) {
            $invitation->delete();
            $request->session()->flash('error', "Lien d'invitation expiré.");

            return Inertia::render('auth/login');
        }

        return Inertia::render('security/accept_invitation', [
            'invitation' => $invitation->only(['id']),
        ]);
    }

    public function accept(InvitationAcceptRequest $request, Invitation $invitation)
    {
        if (Auth::check() && $request->user()->person_id === $invitation->person_id) {
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
            'person_id' => $invitation->person_id,
            'roles' => $invitation->roles,
        ]);

        Auth::login($user);

        $invitation->delete();
        $request->session()->flash('success', 'Invitation acceptée avec succès. Bienvenue !');

        return redirect()->route('dashboard');
    }
}
