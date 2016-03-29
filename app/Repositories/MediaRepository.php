<?php

namespace SLBR\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface MediaRepository
 * @package namespace SLBR\Repositories;
 */
interface MediaRepository extends RepositoryInterface
{
    public function addVideo(array $input, array $language, $ip);

    public function addPicture(array $input, array $language, $ip);

    public function countPendingVideos();

    public function countPendingPictures();

}
