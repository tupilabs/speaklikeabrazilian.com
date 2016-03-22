<?php

namespace SLBR\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface DefinitionRepository
 * @package namespace SLBR\Repositories;
 */
interface DefinitionRepository extends RepositoryInterface
{
    public function getNew(array $language);
}
