<?php

namespace SLBR\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AuditRepository
 * @package namespace SLBR\Repositories;
 */
interface AuditRepository extends RepositoryInterface
{
    public function auditModeration($entity, $userIp, $userId);
}
