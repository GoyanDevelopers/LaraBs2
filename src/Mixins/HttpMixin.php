<?php

namespace Goyan\Bs2\Mixins;

use Illuminate\Support\Facades\Http;
use Goyan\Bs2\Models\Token;

class HttpMixin
{
    public function pix(): callable
    {
        return function (
            callable|null $callback = null,
        ): \Illuminate\Http\Client\PendingRequest {

            $basic = Http::withBasicAuth(config('bs2.key'), config('bs2.secret'))
                ->asForm()
                ->post(config('bs2.endpoint') . '/auth/oauth/v2/token', [
                    'grant_type' => 'client_credentials',
                    'scope' => 'cob.write cob.read dict.write dict.read webhook.read webhook.write pix.read pix.write'
                ])
                ->throw(function ($response, $e) use ($callback): callable {

                    if ($callback && is_callable($callback)) {
                        return $callback($response->json('error_description'));
                    }

                    throw new \Exception(
                        $response->json('error_description', $e->getMessage())
                    );
                });

            return Http::baseUrl(config('bs2.endpoint') . '/pix/direto/forintegration/v1/')
                ->withToken($basic->json('access_token'));
        };
    }

    public function banking(): callable
    {
        return function (
            callable|null $callback = null,
        ): \Illuminate\Http\Client\PendingRequest {

            $token = Token::firstOrfail();

            if (now()->isAfter($token->expires_in)) {

                $basic = Http::withBasicAuth(config('bs2.key'), config('bs2.secret'))
                    ->asForm()
                    ->post(config('bs2.endpoint') . '/auth/oauth/v2/token', [
                        'grant_type' => 'refresh_token',
                        'scope' => 'pagamento boleto',
                        'refresh_token' => $token->refresh_token
                    ])
                    ->throw(function ($response, $e) use ($callback): callable {

                        if ($callback && is_callable($callback)) {
                            return $callback($response->json('error_description'));
                        }

                        throw new \Exception(
                            $response->json('error_description', $e->getMessage())
                        );
                    })
                    ->collect();

                $token->update(
                    $basic->merge(['expires_in' => now()->addSeconds($basic->get('expires_in'))->subSeconds(10)])->all()
                );
            }

            return Http::baseUrl(config('bs2.endpoint') . '/pj/apibanking/forintegration/v1/')
                ->withToken($token->access_token);
        };
    }
}
