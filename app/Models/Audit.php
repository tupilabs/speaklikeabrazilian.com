<?php

namespace SLBR\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Audit extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['body', 'user_ip', 'user_id'];

}
