<?php

namespace App\Http\Controllers\Auth;

use App\Enums\MailObject;
use App\Http\Controllers\Controller;
use App\Models\HumanResource\Person;
use App\Models\Security\User;
use App\Services\Mailer\Recipient;
use App\Services\Mailer\TransactionalMailer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    public function create(Request $request): Response
    {
        return Inertia::render('auth/forgot-password', [
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'username' => 'required',
        ]);

        $user = User::whereUsername($payload['username'])->first();

        if ($user === null) {
            return back()->withErrors([
                'username' => 'Aucun compte trouvé avec ce nom d\'utilisateur.',
            ]);
        }

        /** @var list<Person> $recipients */
        $recipients = [];

        if ($user->person->is_minor && $user->person->parents->isNotEmpty()) {
            $recipients = [$recipients, ...$user->person->parents->all()];
        }

        if ($user->person->email !== null) {
            $recipients[] = $user->person;
        }

        if (count($recipients) === 0) {
            return back()->withErrors([
                'username' => 'Aucune adresse e-mail rattachée à ce compte.',
            ]);
        }

        $passwordResetToken = $user->createResetPasswordToken();

        foreach ($recipients as $recipient) {
            TransactionalMailer::send(
                object: MailObject::FORGOT_PASSWORD,
                recipients: [new Recipient($recipient->email, $recipient->firstname_lastname)],
                data: [
                    'firstname' => $user->person->firstname,
                    'email' => $recipient->email,
                    'confirm_url' => URL::signedRoute(
                        name: 'password.reset',
                        parameters: ['token' => $passwordResetToken],
                        expiration: now()->addDays(7),
                    ),
                ],
            );
        }

        return back()->with('status', 'Un lien de réinitialisation sera envoyé à l\'adresse e-mail associée à ton compte.');
    }
}
