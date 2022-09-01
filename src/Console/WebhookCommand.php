<?php

namespace Goyan\Bs2\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class WebhookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bs2:webhooks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lista webhooks cadastrados no BS2';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->alert('Banco BS2 for Laravel - Powered by Goyan Developers');

        $connect = Http::pix(fn ($error) => exit($this->error($error)));

        $this->line('Listando webhooks cadastrados, aguarde...');

        $response = $connect->get('webhook/bs2');

        $response->onError(fn ($response) => exit($this->error($response->json('descricao', 'Erro desconhecido'))));

        if ($response->successful()) {
            $this->table(
                [
                    'id',
                    'evento',
                    'somenteComTxId',
                    'contaNumero',
                    'url',
                ],
                $response->collect()->map(function ($webhook) {
                    unset($webhook['autorizacao']); // remove campo autorizacao
                    return $webhook;
                })
            );
        }
    }
}
