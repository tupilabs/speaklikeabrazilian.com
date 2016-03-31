<?php

namespace SLBR\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Audit extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'audit';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    protected $guarded = [];

    protected $fillable = ['body', 'user_ip', 'user_id'];

    public static function getModerationBody($jsonEntity, $userIp, $userId, $datetime)
    {
        return json_encode(
            array(
                'type' => 1,
                'user_id' => $userId,
                'user_ip' => $userIp,
                'entity' => $jsonEntity,
                'datetime' => $datetime
            )
        );
    }

}
