<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2013 TupiLabs
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace SLBR\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Definition extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'definitions';

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

    protected $fillable = ['expression_id', 'description', 'example', 'tags', 'status', 'email', 'user_ip',
        'contributor', 'language_id'];

    // --- relationships

	public function expression()
	{
		return $this->belongsTo('SLBR\Models\Expression');
	}

    public function language()
    {
        return $this->belongsTo('SLBR\Models\Language');
    }

    public function medias()
    {
        return $this->hasMany('SLBR\Models\Media', 'definition_id')->where('medias.status', '=', 2);
    }

    public function ratings()
    {
        return $this->hasMany('SLBR\Models\Rating');
    }

}
