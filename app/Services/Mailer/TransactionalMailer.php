<?php

declare(strict_types=1);

namespace App\Services\Mailer;

use App\Enums\MailObject;
use App\Enums\MailStatus;
use App\Models\Meta\TrackedMail;
use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\ApiException;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;

final class TransactionalMailer
{
    private static string $senderEmail;

    private static string $senderName;

    private static string $replyToEmail;

    private static string $replyToName;

    private static TransactionalEmailsApi $api;

    private static bool $initialised = false;

    /**
     * @param  list<Recipient>  $recipients
     * @param  array<string, mixed>  $data
     * @param  array<array-key, array{name: string, contents: string}>  $attachments
     */
    public static function send(
        MailObject $object,
        array $recipients,
        array $data,
        array $attachments = [],
    ): void {
        self::prepare();

        $transactionalEmailOptions = [
            'sender' => ['name' => self::$senderName, 'email' => self::$senderEmail],
            'to' => array_map(fn (Recipient $recipient) => $recipient->toArray(), $recipients),
            'attachment' => array_map(
                /** @param array{name: string, contents: string} $attachment */
                fn (array $attachment) => [
                    'name' => $attachment['name'],
                    'content' => base64_encode($attachment['contents']),
                ],
                $attachments,
            ),
            'replyTo' => ['name' => self::$replyToName, 'email' => self::$replyToEmail],
            'templateId' => $object->getTemplateId(),
            'params' => $data,
        ];

        $transactionalEmail = new SendSmtpEmail($transactionalEmailOptions);

        try {
            $sentEmail = self::$api->sendTransacEmail($transactionalEmail);
            $messageId = $sentEmail->getMessageId();
            $status = MailStatus::Pending;
        } catch (ApiException $e) {
            $status = MailStatus::Failed;
            throw new \RuntimeException('Email not sent to brevo', previous: $e);
        } finally {
            foreach ($recipients as $recipient) {
                TrackedMail::create([
                    'message_id' => $messageId ?? 'unknown',
                    'object' => $object->value,
                    'recipient' => $recipient->email,
                    'status' => $status->value,
                ]);
            }
        }
    }

    private static function prepare(): void
    {
        if (self::$initialised) {
            return;
        }

        self::$senderEmail = config('mail.from.address');
        self::$senderName = config('mail.from.name');
        self::$replyToEmail = config('mail.reply_to.address');
        self::$replyToName = config('mail.reply_to.name');

        $configuration = Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', config('mail.brevo_key'));

        self::$api = new TransactionalEmailsApi(config: $configuration);
    }
}
