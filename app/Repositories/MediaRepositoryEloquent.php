<?php

namespace SLBR\Repositories;

use \DB;
use \Log;
use \Config;
use Event;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use SLBR\Repositories\MediaRepository;
use SLBR\Repositories\AuditRepository;
use SLBR\Models\Media;
use SLBR\Events\MediaApprovedEvent;

/**
 * Class MediaRepositoryEloquent
 * @package namespace SLBR\Repositories;
 */
class MediaRepositoryEloquent extends BaseRepository implements MediaRepository
{

    /**
     * SLBR\Repositories\AuditRepository
     */
    private $auditRepository;

    /**
     * SLBR\Repositories\DefinitionRepository
     */
    private $definitionRepository;

    public function __construct(AuditRepository $auditRepository, DefinitionRepository $definitionRepository)
    {
        parent::__construct(\App::getInstance());
        $this->auditRepository = $auditRepository;
        $this->definitionRepository = $definitionRepository;
    }

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

    public function getRandomPendingPicture()
    {
        $picture = Media::
            where('status', '=', 1)
            ->where('content_type', '<>', 'video/youtube')
            ->with('definition')
            ->orderByRaw((strcmp(Config::get('database.default'), 'mysql') > 0 ? 'RAND()' : 'RANDOM()'))
            ->first();
        if ($picture)
            $picture = $picture->toArray();
        return $picture;
    }

    public function getRandomPendingVideo()
    {
        $video = Media::
            where('status', '=', 1)
            ->where('content_type', '=', 'video/youtube')
            ->with('definition')
            ->orderByRaw((strcmp(Config::get('database.default'), 'mysql') > 0 ? 'RAND()' : 'RANDOM()'))
            ->first();
        if ($video)
            $video = $video->toArray();
        return $video;
    }

    private function updateStatus($mediaId, $user, $status, $userIp)
    {
        Log::info(sprintf('User %d (%s) updating media %d with status %d', $user->id, $user->email, $mediaId, $status));

        $media = $this->find($mediaId);
        $success = FALSE;

        DB::beginTransaction();
        try 
        {
            Log::debug(sprintf("Updating media status to %s", ($status == 2 ? 'APPROVED' : 'REJECTED')));
            $media->status = $status;
            $media->save();

            $definitionId = $media->definition_id;
            $definition = $this->definitionRepository->find($definitionId);

            if ($status == 2)
            {
                Event::fire(new MediaApprovedEvent($media->email, $definition->expression()->first()->text, $media->contributor));
            }

            Log::debug('Committing transaction');
            DB::commit();
            $success = TRUE;
            return $media;
        } 
        catch (Exception $e) 
        {
            Log::debug('Rolling back transaction: ' . $e->getMessage());
            DB::rollback();
            throw $e;
        }
        finally
        {
            if ($success)
            {
                $this->auditRepository->auditMediaModeration($media, $userIp, $user->id);
            }
        }
    }

    public function approvePicture($mediaId, $user, $userIp)
    {
        return $this->updateStatus($mediaId, $user, 2, $userIp, 'picture');
    }

    public function rejectPicture($mediaId, $user, $userIp)
    {
        return $this->updateStatus($mediaId, $user, 3, $userIp, 'picture');
    }

    public function approveVideo($mediaId, $user, $userIp)
    {
        return $this->updateStatus($mediaId, $user, 2, $userIp, 'video');
    }

    public function rejectVideo($mediaId, $user, $userIp)
    {
        return $this->updateStatus($mediaId, $user, 3, $userIp, 'video');
    }
}
