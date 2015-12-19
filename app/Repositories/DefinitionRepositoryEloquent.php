<?php

namespace SLBR\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use SLBR\Repositories\DefinitionRepository;
use SLBR\Models\Definition;

/**
 * Class DefinitionRepositoryEloquent
 * @package namespace SLBR\Repositories;
 */
class DefinitionRepositoryEloquent extends BaseRepository implements DefinitionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Definition::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
