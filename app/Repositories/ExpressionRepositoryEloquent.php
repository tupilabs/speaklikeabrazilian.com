<?php

namespace SLBR\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use SLBR\Repositories\ExpressionRepository;
use SLBR\Models\Expression;

/**
 * Class ExpressionRepositoryEloquent
 * @package namespace SLBR\Repositories;
 */
class ExpressionRepositoryEloquent extends BaseRepository implements ExpressionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Expression::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
