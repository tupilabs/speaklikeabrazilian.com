<?php

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

    // --- utility methods

    /**
     * Parse the description of a definition, looking for references to other expressions enclosed by ["expression"],
     * replacing these occurrences by links to be displayed in the UI.
     * @return string formatted description
     */
    public function getFormattedDescription()
	{
        return $this->parseAndFormat($this->description);
	}

	public function getFormattedExample()
	{
        return $this->parseAndFormat($this->example);
	}

    /**
     * Parse the value, looking for references to other expressions enclosed by ["expression"],
     * replacing these occurrences by links to be displayed in the UI.
     * @return string parse and formatted value
     */
    private function parseAndFormat($value)
    {
        $url = \URL::to("/");
        $text = nl2br(urldecode($value));
        $pattern = "/\[([^]]*)\]/i";
        $replace = "<a href=\"{$url}/expression/define?e=$1\">$1</a>";
        $text = preg_replace($pattern, $replace, $text);
        return $text;
    }

    // --- relationships

	public function expression()
	{
		return $this->belongsTo('SLBR\Models\Expression');
	}

    public function language()
    {
        return $this->belongsTo('SLBR\Models\Language');
    }

}
