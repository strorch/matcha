<?php


namespace App\Domain\Repository\Interfaces;


use App\Domain\Entity\User;
use App\Domain\ValueObject\UserProfileData;

interface UserProfileDataRepositoryInterface
{
    public function set(UserProfileData $profileData): void;

    public function search(User $user): UserProfileData;
}
