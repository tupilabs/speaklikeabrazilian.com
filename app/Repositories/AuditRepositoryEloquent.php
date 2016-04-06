<?php

namespace SLBR\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use SLBR\Repositories\AuditRepository;
use SLBR\Models\Audit;
use SLBR\Validators\AuditValidator;

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

    public function auditDefinitionModeration($entity, $userIp, $userId)
    {
        $jsonEntity = $entity->toJson();
        $datetime = new \DateTime();
        $body = Audit::getDefinitionModerationBody($jsonEntity, $userIp, $userId, $datetime);
        return $this->create(array(
            'user_ip' => $userIp,
            'user_id' => $userId,
            'body'    => $body
        ));
    }

    public function auditMediaModeration($entity, $userIp, $userId)
    {
        $jsonEntity = $entity->toJson();
        $datetime = new \DateTime();
        $body = Audit::getMediaModerationBody($jsonEntity, $userIp, $userId, $datetime);
        return $this->create(array(
            'user_ip' => $userIp,
            'user_id' => $userId,
            'body'    => $body
        ));
    }

    public function auditDefinitionUpdated($entity, $userIp, $userId)
    {
        $jsonEntity = $entity->toJson();
        $datetime = new \DateTime();
        $body = Audit::getDefinitionEditBody($jsonEntity, $userIp, $userId, $datetime);
        return $this->create(array(
            'user_ip' => $userIp,
            'user_id' => $userId,
            'body'    => $body
        ));
    }
}
