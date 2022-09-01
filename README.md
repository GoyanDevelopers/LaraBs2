
<p align="center">
<a href="https://goyan.com.br" target="_blank"><img src="https://goyan.com.br/images/logo.svg" width="200">	</a>
</p>


[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]


## Sobre o pacote

**LaraBs2** é um projeto criado para facilitar o consumo das API's do Banco BS2 no ecossistema Laravel em formato de SDK.

## Instalação

Você pode instalar o **LaraBs2** através do gerenciador de pacotes do Composer:

``` bash
$ composer require goyan/bs2-laravel
```

Em seguida, você deve publicar os arquivos de configuração e migração do pacote usando o comando artisan: `vendor:publish`. O `bs2.php` (arquivo de configuração) será colocado no diretório `config` do seu aplicativo:

``` bash
$ php artisan  vendor:publish  --provider="Goyan\Bs2\Bs2ServiceProvider"
```

Finalmente, você deve executar suas migrações de banco de dados. O comando abaixo criará uma tabela de banco de dados para armazenar o token da API:

``` bash
$ php artisan  migrate
```

Em seguida, configure o provedor de serviços em seu arquivo `config/app.php`:

``` php
'providers' => [
    Goyan\Bs2\Bs2ServiceProvider::class
]
```

## Comandos Artisan

#### Listar webhook's

Você pode listar todos os webooks cadastrados em seu aplicativo com o comando:

``` bash
$ php artisan bs2:webhooks
```

#### Cadastrar novo webhook

Para cadastrar um novo webhook, você pode executar o comando abaixo e informar corretamente os dados: `Tipo do Número da conta`, `Tipo do webhook` e `Evento`

``` bash
$ php artisan bs2:webhook-create
```

#### Excluir webhook

Excluir um webhook também é bem simples, será necessário apenas da ID informada na  `Lista de webhook`

``` bash
$ php artisan bs2:webhook-delete
```

## Segurança

Se você descobrir algum problema relacionado à segurança, envie um e-mail para contato@goyan.com.br

## Créditos

- [Goyan Developers][link-author]
- [Todos os Contribuintes][link-contributors]

## Licença

LaraBs2 está disponível na licença do MIT. Por favor, leia  [License File](https://github.com/GoyanDevelopers/LaraBs2/blob/main/LICENSE)  para mais informações.

[ico-version]: https://img.shields.io/packagist/v/goyan/larabs2.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/goyan/larabs2.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/goyan/larabs2

[link-downloads]: https://packagist.org/packages/goyan/larabs2

[link-author]: https://github.com/GoyanDevelopers
[link-contributors]: ../../contributors