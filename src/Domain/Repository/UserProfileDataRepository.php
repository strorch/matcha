<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\Repository\Interfaces\InterestRepositoryInterface;
use App\Domain\Repository\Interfaces\UserProfileDataRepositoryInterface;
use App\Domain\ValueObject\InterestsSearch;
use App\Domain\ValueObject\UserProfileData;
use App\Infrastructure\DB\Lib\DB;

class UserProfileDataRepository extends AbstractRepository implements UserProfileDataRepositoryInterface
{
//    private InterestRepositoryInterface $interestRepository;

    public function __construct(
        DB $db
//        ,InterestRepositoryInterface $interestRepository
    ) {
        parent::__construct($db);
//        $this->interestRepository = $interestRepository;
    }

    public function set(UserProfileData $profileData): void
    {
    }

    public function search(User $user): UserProfileData
    {
        /**
         * TODO exec db , hydrator->hydrate
         */
//        $profileData = $this->profileDataRepository->;

        $interestsSearch = new InterestsSearch();
        $interestsSearch->clientId = $user->getId();
//        $profileData->interests = $this->interestRepository->search($interestsSearch);
    }
}
