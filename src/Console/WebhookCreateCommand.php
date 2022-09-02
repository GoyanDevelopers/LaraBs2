<?php

namespace Goyan\Bs2\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class WebhookCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bs2:webhook-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um webhook para o BS2';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->alert('Banco BS2 for Laravel - Powered by Goyan Developers');

        $this->question('Para criar ou atualizar um webhook, preencha corretamente os campos abaixo.');

        $connect = Http::pix(fn ($error) => exit($this->error($error)));

        $evento = $this->choice(
            'Qual o tipo do webhook?',
            [
                'ReivindicacaoDoador' => 'Obsoleto, não usar.',
                'ReivindicacaoReivindicador' => 'Obsoleto, não usar.',
                'Pagamento' => 'Ocorre toda vez que um pagamento é realizado com sucesso.',
                'Recebimento' => 'Ocorre toda vez que um recebimento é realizado com sucesso.',
                'DevolucaoEfetuada' => 'Em desenvolvimento, não usar.',
                'ValidacaoChaves' => 'Em desenvolvimento, não usar.',
            ],
            null,
            null,
            true
        );

        $url = $this->ask('Digite a url de notificação do webhook');

        $this->table(['Url de notificação', 'Evento'], [
            [
                $url,
                implode(', ', $evento)
            ]
        ]);

        if ($this->confirm('Tem certeza que deseja criar/atualizar o webhook com os dados acima?')) {

            $response = $connect->put('webhook/bs2', [
                [
                    'url' => $url,
                    'eventos' => $evento
                ]
            ]);

            $response->onError(fn ($response) => exit($this->error($response->json('0.descricao', 'Erro desconhecido'))));

            if ($response->successful()) {
                $this->info('Webhook criado com sucesso!');
            }
        }
    }
}
