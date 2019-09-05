<?php
/** @noinspection UnusedFunctionResultInspection */
declare(strict_types=1);

use App\Application\Actions\Console\PackDomainsInfoAction;
use App\Application\Actions\Domain\GetDomainInfoAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/domain', function (Group $group) use ($container) {
        $group->get('/{domainName}', GetDomainInfoAction::class);
    });

    $app->get('/collect-files', PackDomainsInfoAction::class);
};
