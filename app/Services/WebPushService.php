<?php

namespace App\Services;

use App\Models\PushSubscription;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class WebPushService
{
    public static function sendToUser(int $userId, string $title, string $body, array $data = []): void
    {
        $publicKey = env('VAPID_PUBLIC_KEY');
        $privateKey = env('VAPID_PRIVATE_KEY');
        $subject = env('VAPID_SUBJECT', 'mailto:admin@kopingaji.test');

        if (!$publicKey || !$privateKey) {
            return;
        }

        $auth = [
            'VAPID' => [
                'subject' => $subject,
                'publicKey' => $publicKey,
                'privateKey' => $privateKey,
            ],
        ];

        $webPush = new WebPush($auth);
        $subscriptions = PushSubscription::where('user_id', $userId)->get();

        $payload = json_encode([
            'title' => $title,
            'body' => $body,
            'icon' => asset('favicon.ico'),
            'data' => $data,
        ]);

        foreach ($subscriptions as $sub) {
            $subscription = Subscription::create([
                'endpoint' => $sub->endpoint,
                'publicKey' => $sub->public_key,
                'authToken' => $sub->auth_token,
                'contentEncoding' => $sub->content_encoding,
            ]);

            $webPush->queueNotification($subscription, $payload);
        }

        foreach ($webPush->flush() as $report) {
            $endpoint = $report->getRequest()->getUri()->__toString();
            if ($report->isSuccess()) {
                continue;
            }
            if ($report->isSubscriptionExpired()) {
                PushSubscription::where('endpoint', $endpoint)->delete();
            }
        }
    }
}
