<?php

namespace SLBR\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface RatingRepository
 * @package namespace SLBR\Repositories;
 */
interface RatingRepository extends RepositoryInterface
{

    public function like($ip, $definitionId);

    public function dislike($ip, $definitionId);
}
