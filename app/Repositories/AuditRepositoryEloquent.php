<?php

namespace SLBR\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use SLBR\Repositories\AuditRepository;
use SLBR\Models\Audit;
use SLBR\Validators\AuditValidator;;

/**
 * Class AuditRepositoryEloquent
 * @package namespace SLBR\Repositories;
 */
class AuditRepositoryEloquent extends BaseRepository implements AuditRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Audit::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
