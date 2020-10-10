<?php


namespace App\Domain\Repository;


use App\Domain\Entity\User;
use App\Domain\Repository\Interfaces\ContactRepositoryInterface;
use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use App\Infrastructure\DB\Lib\DB;

final class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    private ContactRepositoryInterface $contactRepository;

    public function __construct(DB $db, ContactRepositoryInterface $contactRepository)
    {
        parent::__construct($db);

        $this->contactRepository = $contactRepository;
    }

    /**
     * @inheritDoc
     */
    public function create(User $user): void
    {
        $id = $this->db->query(<<<SQL
            INSERT INTO users (email, username, last_name, first_name, password)
            VALUES (:email, :username, :last_name, :first_name, crypt_password(:password))
            RETURNING id
        SQL, [
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'last_name' => $user->getLastName(),
            'first_name' => $user->getFirstName(),
            'password' => $user->getPassword(),
        ]);

        $user->setId(reset($id)['id']);
    }

    /**
     * @inheritDoc
     */
    public function update(User $user): void
    {
        $this->db->query(<<<SQL
            UPDATE users
            SET
                email = :email,
                username = :username,
                last_name = :last_name,
                first_name = :first_name,
                password = crypt_password(:password),
                is_confirmed = :is_confirmed
            WHERE id = :id
        SQL, [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'last_name' => $user->getLastName(),
            'first_name' => $user->getFirstName(),
            'password' => $user->getPassword(),
            'is_confirmed' => $user->getIsConfirmed(),
        ]);

        if (!empty($user->getContact())) {
            $this->contactRepository->setContact($user->getId(), $user->getContact());
        }
    }

    /**
     * @inheritDoc
     */
    public function search(User $user): void
    {
    }

    /**
     * @inheritDoc
     */
    public function delete(User $user): void
    {
    }
}
