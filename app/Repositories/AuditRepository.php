<?php

namespace SLBR\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AuditRepository
 * @package namespace SLBR\Repositories;
 */
interface AuditRepository extends RepositoryInterface
{
    public function auditDefinitionModeration($entity, $userIp, $userId);

    public function auditPictureModeration($entity, $userIp, $userId);

    public function auditVideoModeration($entity, $userIp, $userId);
}
