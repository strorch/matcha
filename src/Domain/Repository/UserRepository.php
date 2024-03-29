<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\Repository\Interfaces\UserProfileDataRepositoryInterface;
use App\Domain\Repository\Interfaces\UserRepositoryInterface;
use App\Domain\DTO\UserSearch;
use App\Infrastructure\DB\Lib\DB;
use App\Infrastructure\Provider\UserProviderInterface;

final class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    private UserProfileDataRepositoryInterface $profileDataRepository;
    private UserProviderInterface $userProvider;

    public function __construct(
        DB $db,
        UserProfileDataRepositoryInterface $profileDataRepository,
        UserProviderInterface $userProvider
    ) {
        parent::__construct($db);

        $this->profileDataRepository = $profileDataRepository;
        $this->userProvider = $userProvider;
    }

    /**
     * @inheritDoc
     */
    public function create(User $user): void
    {
        $this->getDb()->query(<<<SQL
            INSERT INTO users (id, email, username, last_name, first_name, password)
            VALUES (:id, :email, :username, :last_name, :first_name, :password)
            RETURNING id
        SQL, [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'last_name' => $user->getLastName(),
            'first_name' => $user->getFirstName(),
            'password' => $user->getPasswordHash(),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function update(User $user): void
    {
        $this->getDb()->query(<<<SQL
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
            'password' => $user->getPasswordHash(),
            'is_confirmed' => $user->getIsConfirmed(),
        ]);

        if (!empty($user->getProfileData())) {
            $this->profileDataRepository->set($user->getProfileData());
        }
    }

    /**
     * @inheritDoc
     */
    public function search(UserSearch $search): array
    {
        $users = $this->userProvider->search($search);

        foreach ($users as $user) {
            $profileData = $this->profileDataRepository->search($user);

            $user->setProfileData($profileData);
        }

        return $users;
    }
}
