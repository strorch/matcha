<?php


namespace App\Application\Action\User;


use App\Application\Actions\AbstractRestAction;
use App\Infrastructure\Helper\RuntimeHelper;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Request;
use Symfony\Component\Serializer\SerializerInterface;

class UploadImageAction extends AbstractRestAction
{
    public function __construct(
        StreamFactoryInterface $streamFactory,
        SerializerInterface $serializer
    ) {
        parent::__construct($streamFactory, $serializer);
    }

    protected function doAction(Request $request, Response $response)
    {
        $uploadedFiles = $request->getUploadedFiles();

        // handle multiple inputs with the same key
        foreach ($uploadedFiles['example2'] as $uploadedFile) {
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $filename = RuntimeHelper::moveUploadedFile($directory, $uploadedFile);
                $response->getBody()->write('Uploaded: ' . $filename . '<br/>');
            }
        }

        // handle single input with multiple file uploads
        foreach ($uploadedFiles['example3'] as $uploadedFile) {
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $filename = RuntimeHelper::moveUploadedFile($directory, $uploadedFile);
                $response->getBody()->write('Uploaded: ' . $filename . '<br/>');
            }
        }

        return $response;
    }
}
