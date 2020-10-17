<?php


namespace App\Application\Actions;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Request;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractRestAction
{
    private StreamFactoryInterface $streamFactory;
    private SerializerInterface $serializer;

    public function __construct(
        StreamFactoryInterface $streamFactory,
        SerializerInterface $serializer
    ) {
        $this->streamFactory = $streamFactory;
        $this->serializer = $serializer;
    }

    abstract protected function doAction(Request $request, Response $response, array $args);

    final public function __invoke(Request $request, Response $response, array $args): Response
    {
        $responseData['data'] = $this->doAction($request, $response, $args);
        $serializedData = $this->serializer->serialize($responseData, 'json');
        $dataStream = $this->streamFactory->createStream($serializedData);

        return $response
            ->withBody($dataStream)
            ->withHeader('Content-Type', 'application/json')
        ;
    }

    public function getStreamFactory(): StreamFactoryInterface
    {
        return $this->streamFactory;
    }

    public function getSerializer(): SerializerInterface
    {
        return $this->serializer;
    }
}
