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

    private static function getModerationBody($type, $jsonEntity, $userIp, $userId, $datetime)
    {
        return json_encode(
            array(
                'type' => $type,
                'user_id' => $userId,
                'user_ip' => $userIp,
                'entity' => $jsonEntity,
                'datetime' => $datetime
            )
        );
    }

    public static function getDefinitionModerationBody($jsonEntity, $userIp, $userId, $datetime)
    {
        return self::getModerationBody('audit.definition.moderation', $jsonEntity, $userIp, $userId, $datetime);
    }

    public static function getPictureModerationBody($jsonEntity, $userIp, $userId, $datetime)
    {
        return self::getModerationBody('audit.picture.moderation', $jsonEntity, $userIp, $userId, $datetime);
    }

    public static function getVideoModerationBody($jsonEntity, $userIp, $userId, $datetime)
    {
        return self::getModerationBody('audit.video.moderation', $jsonEntity, $userIp, $userId, $datetime);
    }

}
