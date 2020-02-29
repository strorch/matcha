<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Domain\DTO\UserSearch;
use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use App\Domain\Repository\User;
use App\Domain\ValueObject\Contact;
use App\Infrastructure\Mail\CustomMessageFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Request;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SignUpAction
{
    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var CustomMessageFactory
     */
    private $messageFactory;

    /**
     * GetDomainInfoAction constructor.
     * @param StreamFactoryInterface $streamFactory
     * @param SessionInterface $session
     * @param UserRepositoryInterface $userRepository
     * @param Swift_Mailer $mailer
     * @param CustomMessageFactory $messageFactory
     */
    public function __construct(
        StreamFactoryInterface $streamFactory,
        SessionInterface $session,
        UserRepositoryInterface $userRepository,
        Swift_Mailer $mailer,
        CustomMessageFactory $messageFactory
    ) {
        $this->streamFactory = $streamFactory;
        $this->userRepository = $userRepository;
        $this->session = $session;
        $this->mailer = $mailer;
        $this->messageFactory = $messageFactory;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $search = (new UserSearch())
            ->setLogin($args['login']);

        $res = $this->userRepository->search($search);
        if (!empty($res)) {
            return $response
                ->withBody($this->streamFactory->createStream('error'));
        }

        $contact = (new Contact())
            ->setEmail($args['email'])
            ->setGender($args['gender'])
            ->setLastName($args['lastName'])
            ->setName($args['name']);

        $user = (new User())
            ->setLogin($args['login'])
            ->setPassword($args['password'])
            ->setContact($contact);

        if (!$this->userRepository->create($user)) {
            return $response
                ->withBody($this->streamFactory->createStream('error'));
        }
        $this->session->set('user', $user);

        $message = $this->messageFactory
            ->create('Wonderful Subject')
            ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
            ->setBody('Here is the message itself');
        $this->mailer->send($message);

        return $response
            ->withBody($this->streamFactory->createStream('success'));
    }
}
