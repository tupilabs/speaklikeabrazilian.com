<?php

namespace SLBR\Repositories;

use \Log;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use SLBR\Repositories\MediaRepository;
use SLBR\Models\Media;

/**
 * Class MediaRepositoryEloquent
 * @package namespace SLBR\Repositories;
 */
class MediaRepositoryEloquent extends BaseRepository implements MediaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Media::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function addVideo(array $input, array $language, $ip)
    {
        $url = $input['video-url-input'];
        $definitionId = $input['definition_id'];
        
        Log::info(sprintf('User %s wants to share a new video %s for definition %d', $ip, $url, $definitionId));
        
        $media = Media::create(
            array(
                'definition_id' => $definitionId,
                'url' => $url,
                'reason' => $input['video-reason-input'],
                'email' => $input['video-email-input'],
                'status' => 1, 
                'contributor' => $input['video-pseudonym-input'],
                'content_type' => 'video/youtube',
                'user_ip' => $ip
            )
        );
        return $media;
    }

    public function addPicture(array $input, array $language, $ip)
    {
        $url = $input['picture-url-input'];
        $definitionId = $input['definition_id'];
        
        Log::info(sprintf('User %s wants to share a new picture %s for definition %d', $ip, $url, $definitionId));
        // FIXME: image/unknown? Get the mime type with some library found in composer maybe?
        $media = Media::create(
            array(
                'definition_id' => $definitionId,
                'url' => $url,
                'reason' => $input['picture-reason-input'],
                'email' => $input['picture-email-input'],
                'status' => 1, 
                'contributor' => $input['picture-pseudonym-input'],
                'content_type' => 'image/unknown',
                'user_ip' => $ip
            )
        );
        return $media;
    }

    public function countPendingVideos()
    {
        $count = Media::where('status', '=', 1)
            ->where('content_type', '=', 'video/youtube')
            ->count();
        return $count;
    }

    public function countPendingPictures()
    {
        $count = Media::where('status', '=', 1)
            ->where('content_type', '<>', 'video/youtube')
            ->count();
        return $count;
    }
}
