<?php
declare(strict_types=1);

namespace App\Application\Action\Interest;

use App\Application\Actions\AbstractRestAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Request;
use Symfony\Component\Serializer\SerializerInterface;

final class CreateInterestAction extends AbstractRestAction
{
    public function __construct(
        StreamFactoryInterface $streamFactory,
        SerializerInterface $serializer
    ) {
        parent::__construct($streamFactory, $serializer);
    }

    protected function doAction(Request $request, Response $response)
    {

    }
}
