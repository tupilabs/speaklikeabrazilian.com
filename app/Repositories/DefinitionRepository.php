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

    public function getDefinitions($text, array $language);

    public function getLetter($letter, array $language);

    public function add(array $input, array $language, $ip);

    public function getOne($definitionId, $status);

    public function retrieve($ids, array $language);

    public function countPendingDefinitions();

    public function getRandomPendingDefinition();

    public function approve($definitionId, $user, $userIp);

    public function reject($definitionId, $user, $userIp);
}
