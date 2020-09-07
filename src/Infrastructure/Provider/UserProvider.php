<?php


namespace App\Infrastructure\Provider;


use App\Domain\Repository\AbstractRepository;
use App\Domain\ValueObject\UserSearch;
use App\Infrastructure\DB\Lib\DB;
use App\Infrastructure\DB\UserSearchQuery;

class UserProvider extends AbstractRepository implements UserProviderInterface
{
    /**
     * @var UserSearchQuery
     */
    private UserSearchQuery $queryBuilder;

    public function __construct(DB $db, UserSearchQuery $queryBuilder)
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

        return $this->db->query($query);
    }
}
