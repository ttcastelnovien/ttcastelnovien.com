<?php

declare(strict_types=1);

namespace App\Http\Controllers\WebHooks;

use App\Enums\MailStatus;
use App\Http\Controllers\Controller;
use App\Models\Meta\TrackedMail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Symfony\Component\HttpFoundation\IpUtils;

class BrevoWebHookController extends Controller implements HasMiddleware
{
    /** @var list<string> */
    private const array IP_RANGES = ['1.179.112.0/20', '172.246.240.0/20'];

    public static function middleware(): array
    {
        return [
            function (Request $request, \Closure $next) {
                if (array_any($request->ips(), fn ($ip) => ! IpUtils::checkIp($ip, self::IP_RANGES))) {
                    return response()->forbidden();
                }

                if ($request->get('token') !== config('mail.brevo_webhook_token')) {
                    return response()->forbidden();
                }

                return $next($request);
            },
        ];
    }

    public function __invoke(Request $request)
    {
        /** @var array{event: string, message-id: string} $data */
        $data = $request->all();

        $event = $data['event'];
        $newStatus = MailStatus::tryFrom($event);

        if ($newStatus === null) {
            return response()->badRequest();
        }

        $messageId = $data['message-id'];
        $mail = TrackedMail::whereMessageId($messageId)->first();

        if ($mail === null) {
            return response()->notFound();
        }

        $mail->update(['status' => $newStatus]);

        return response()->noContent();
    }
}
