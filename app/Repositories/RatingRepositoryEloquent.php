<?php

namespace SLBR\Repositories;

use \Log;
use Exception;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use SLBR\Repositories\RatingRepository;
use SLBR\Models\Rating;

/**
 * Class RatingRepositoryEloquent
 * @package namespace SLBR\Repositories;
 */
class RatingRepositoryEloquent extends BaseRepository implements RatingRepository
{

    const LIKE = 1;
    const DISLIKE = -1;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Rating::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Like a definition.
     */
    public function like($ip, $definitionId)
    {
        $balance = $this->rate($ip, $definitionId, self::LIKE);
        return $balance;
    }

    /**
     * Like a definition.
     */
    public function dislike($ip, $definitionId)
    {
        $balance = $this->rate($ip, $definitionId, self::DISLIKE);
        return $balance;
    }

    private function rate($ip, $definitionId, $rate)
    {
        $balance = FALSE;
        Log::debug(sprintf('User %s liking definition %d', $ip, $definitionId));
        $inverse = NULL;
        if ($rate === self::LIKE)
            $inverse = self::DISLIKE;
        else
            $inverse = self::LIKE;

        // Check if user already voted up this expression
        $count = Rating::where('definition_id', '=', $definitionId)
            ->where('user_ip', $ip)
            ->where('rating', $rate)
            ->count();
        if ($count > 0)
        {
            Log::info(sprintf('User %s tried to like definition %d twice!', $ip, $definitionId));
            throw new Exception("Sorry, you already liked this expression.");
        }

        // Retrieve any existing vote first
        $rating = Rating::where('definition_id', '=', $definitionId)
            ->where('user_ip', '=', $ip)
            ->where('rating', '=', $inverse)
            ->first();

        if ($rating) 
        {
            // then if the user disliked but changed his mind, we update his vote
            Log::info(sprintf('User %s changed his mind, now likes definition %d', $ip, $definitionId));
            $rating->rating = $rate;
            $rating->save();
            $balance = TRUE;
        } 
        else 
        {
            // otherwise we just save the new vote
            Log::info(sprintf('User %s liked definition %d', $ip, $definitionId));
            Rating::create(array(
                'definition_id' => $definitionId,
                'rating' => $rate,
                'user_ip' => $ip
            ));
        }

        return $balance;
    }

}
