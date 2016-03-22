<?php

namespace SLBR\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use SLBR\Repositories\DefinitionRepository;
use SLBR\Models\Definition;

/**
 * Class DefinitionRepositoryEloquent
 * @package namespace SLBR\Repositories;
 */
class DefinitionRepositoryEloquent extends BaseRepository implements DefinitionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Definition::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getNew(array $language)
    {
        $definitions = Definition::
            join('expressions', 'definitions.expression_id', '=', 'expressions.id')
            ->where('status', '=', 2)
            ->where('language_id', '=', $language['id'])
            ->orderBy('definitions.created_at', 'desc')
            ->select('definitions.id', 'definitions.description', 'definitions.example', 'definitions.tags',
                'definitions.contributor', 'definitions.created_at', 'expressions.text',
                new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
                new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
                )
            ->with('medias')
            ->paginate(8)
            ->toArray();
        return $definitions;
    }
}
