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

    public function getTop(array $language);

    public function getRandom(array $language);

    public function getDefinition($text, array $language);
}
