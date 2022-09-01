<?php

namespace Goyan\Bs2\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class WebhookDeleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bs2:webhook-delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deleta webhooks cadastrados no BS2';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->alert('Banco BS2 for Laravel - Powered by Goyan Developers');
        
        $this->question('Para excluir uma webhook, preencha corretamente o campo abaixo.');

        $connect = Http::pix(fn ($error) => exit($this->error($error)));

        $idWebhook = $this->ask('ID do webhook a ser excluído');

        if ($this->confirm('Tem certeza que deseja excluir o webhook: ' . $idWebhook . '?')) {

            $response = $connect->delete('webhook/bs2/' . $idWebhook);

            $response->onError(fn ($response) => exit($this->error($response->json('0.descricao', 'Erro desconhecido'))));

            if ($response->successful()) {
                $this->warn('Webhook Excluindo com sucesso!');
            }
        }
    }
}
