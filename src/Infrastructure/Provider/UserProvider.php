<?php


namespace App\Infrastructure\Provider;


use App\Domain\Repository\AbstractRepository;
use App\Domain\ValueObject\UserSearch;
use App\Infrastructure\DB\Lib\DB;
use App\Infrastructure\DB\UserSearchQueryBuilder;

class UserProvider extends AbstractRepository implements UserProviderInterface
{
    private UserSearchQueryBuilder $queryBuilder;

    public function __construct(DB $db, UserSearchQueryBuilder $queryBuilder)
    {
        parent::__construct($db);

        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @inheritDoc
     */
    public function search(UserSearch $search): array
    {
        $query = $this->queryBuilder->build($search);

        return $this->getDb()->query($query);
    }
}
