<?php

namespace SLBR\Repositories;

use \DB;
use \Log;
use \Config;
use \Exception;
use Mail;
use Es;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use SLBR\Repositories\DefinitionRepository;
use SLBR\Repositories\RatingRepository;
use SLBR\Repositories\AuditRepository;
use SLBR\Models\Expression;
use SLBR\Models\Definition;

/**
 * Class DefinitionRepositoryEloquent
 * @package namespace SLBR\Repositories;
 */
class DefinitionRepositoryEloquent extends BaseRepository implements DefinitionRepository
{

    /**
     * SLBR\Repositories\RatingRepository
     */
    private $ratingRepository;

    /**
     * SLBR\Repositories\AuditRepository
     */
    private $auditRepository;

    public function __construct(RatingRepository $ratingRepository, AuditRepository $auditRepository)
    {
        parent::__construct(\App::getInstance());
        $this->ratingRepository = $ratingRepository;
        $this->auditRepository = $auditRepository;
    }

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

    public function getTop(array $language)
    {
        $definitions = Definition::
            join('expressions', 'definitions.expression_id', '=', 'expressions.id')
            ->where('status', '=', 2)
            ->where('language_id', '=', $language['id'])
            ->select('definitions.id', 'definitions.description', 'definitions.example', 'definitions.tags',
                'definitions.contributor', 'definitions.created_at', 'expressions.text',
                new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
                new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
                )
            ->with('medias')
            ->orderByRaw('(COALESCE(likes, 0) - COALESCE(dislikes, 0)) DESC')
            ->paginate(8)
            ->toArray();
        return $definitions;
    }

    public function getRandom(array $language)
    {
        $definitions = Definition::
            join('expressions', 'definitions.expression_id', '=', 'expressions.id')
            ->where('status', '=', 2)
            ->where('language_id', '=', $language['id'])
            ->select('definitions.id', 'definitions.description', 'definitions.example', 'definitions.tags',
                'definitions.contributor', 'definitions.created_at', 'expressions.text',
                new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
                new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
                )
            ->with('medias')
            ->orderByRaw((strcmp(Config::get('database.default'), 'mysql') > 0 ? 'RAND()' : 'RANDOM()'))
            ->take(8)
            ->get()
            ->toArray();
        return $definitions;
    }

    public function getDefinitions($text, array $language)
    {
        $definitions = Definition::
            join('expressions', 'definitions.expression_id', '=', 'expressions.id')
            ->where('definitions.status', '=', 2)
            ->where('language_id', '=', $language['id'])
            ->where(new \Illuminate\Database\Query\Expression("lower(expressions.text)"), '=', strtolower($text))
            ->select('definitions.id', 'definitions.description', 'definitions.example', 'definitions.tags',
                'definitions.contributor', 'definitions.created_at', 'expressions.text',
                new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
                new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
                )
            ->with('medias')
            ->paginate(8);
        return $definitions;
    }

    public function getLetter($letter, array $language)
    {
        $definitions = Definition::
            join('expressions', 'definitions.expression_id', '=', 'expressions.id')
            ->where('status', '=', 2)
            ->where('language_id', '=', $language['id'])
            ->where('expressions.char', '=', $letter)
            ->orderBy('expressions.text', 'asc')
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

    public function add(array $input, array $language, $ip)
    {
        Log::debug('Starting transaction to add new expression');
        DB::beginTransaction();
        try 
        {
            $text = urlencode($input['expression-text-input']);
            // Get existing expressions
            $expression = Expression::
                where(new \Illuminate\Database\Query\Expression("lower(expressions.text)"), '=', strtolower($text))
                ->first();

            $letter = substr($text, 0, 1);
            if (is_numeric($letter))
            {
                $letter = '0';
            }
            else
            {
                $unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
                $text2 = strtr($text, $unwanted_array );
                $letter = substr($text2, 0, 1);
            }
            if (!$expression)
            {
                $expression = Expression::create(array(
                    'text' => $text,
                    'char' => strtoupper($letter),
                    'contributor' => $input['expression-pseudonym-input'],
                    'moderator_id' => NULL
                ));
            }

            $definition = Definition::create(array(
                'expression_id' => $expression->id, 
                'description' => $input['expression-description-input'],
                'example' => $input['expression-example-input'],
                'tags' => $input['expression-tags-input'],
                'status' => 1,
                'email' => $input['expression-email-input'],
                'contributor' => $input['expression-pseudonym-input'],
                'moderator_id' => NULL,
                'user_ip' => $ip,
                'language_id' => $language['id']
            ));

            Log::debug('Committing transaction');
            DB::commit();
            Log::info(sprintf('New definition for %s added!', $text));
            return $definition;
        } 
        catch (\Exception $e) 
        {
            Log::debug('Rolling back transaction: ' . $e->getMessage());
            DB::rollback();
            throw $e;
        }
    }

    public function getOne($definitionId)
    {
        $definitions = Definition::
            join('expressions', 'definitions.expression_id', '=', 'expressions.id')
            ->where('definitions.status', '=', 2)
            ->where('definitions.id', '=', $definitionId)
            ->select('definitions.id', 'definitions.description', 'definitions.example', 'definitions.tags',
                'definitions.contributor', 'definitions.language_id', 'definitions.created_at', 'expressions.text',
                new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
                new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
                )
            ->with('expression')
            ->first();
        return $definitions;
    }

    public function retrieve($ids, array $language)
    {
        $definitions = Definition::
            join('expressions', 'definitions.expression_id', '=', 'expressions.id')
            ->where('status', '=', 2)
            ->where('language_id', '=', $language['id'])
            ->whereIn('definitions.id', $ids)
            ->orderBy('expressions.text', 'asc')
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

    public function countPendingDefinitions()
    {
        $count = Definition::
            join('expressions', 'definitions.expression_id', '=', 'expressions.id')
            ->where('status', '=', 1)
            ->orderBy('expressions.text', 'asc')
            ->select('definitions.id', 'definitions.description', 'definitions.example', 'definitions.tags',
                'definitions.contributor', 'definitions.created_at', 'expressions.text',
                new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
                new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
                )
            ->count();
        return $count;
    }

    public function getRandomPendingDefinition()
    {
        $definitions = Definition::
            join('expressions', 'definitions.expression_id', '=', 'expressions.id')
            ->where('status', '=', 1)
            ->select('definitions.id', 'definitions.language_id', 'definitions.description', 'definitions.example', 'definitions.tags',
                'definitions.contributor', 'definitions.created_at', 'expressions.text',
                new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
                new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
                )
            ->with('medias')
            ->orderByRaw((Config::get('database.default') =='mysql' ? 'RAND()' : 'RANDOM()'))
            ->first();
        if ($definitions)
            $definitions = $definitions->toArray();
        return $definitions;
    }

    private function addToSearchIndex($expression, $definition)
    {
        // Index document into search server
        $params = array();
        $params['body']  = array(
            'expression' => $expression->text,
            'description' => $definition->description,
            'example' => $definition->example,
            'tags' => $definition->tags,
            'language_id' => $definition->language_id
        );
        $params['index'] = 'slbr_index';
        $params['type']  = 'definition';
        $params['id']    = $definition->id;

        // Document will be indexed to slbr_index/definition/id
        Log::debug('Indexing into search server');
        $response = Es::index($params);
        if (!$response) {
            throw new Exception("Failed to index definition");
        }
        Log::info("Expression added into search index");
        Log::info($params);
    }

    private function addAuthorVote($definition)
    {
        Log::debug('Auto voting the definition using user\'s IP address');
        if (isset($definition->user_ip) && strlen($definition->user_ip) > 0)
        {
            $votes = $this
                ->ratingRepository
                ->findWhere([
                    ['user_ip', '=', $definition->user_ip],
                    ['definition_id', '=', $definition->id]
                ]);
            if ($votes->isEmpty())
            {
                $this->ratingRepository->like($definition->user_ip, $definition->id);
                Log::info('Added +1 vote for the expression (author self-voting)');
            }
            else
            {
                Log::warning("Skipping vote. Reason: User already voted for this expression");
            }
        }
        else
        {
            Log::warning('Skipping vote. Reason: Missing user IP');
        }
    }

    private function sendApprovalEmail($definition)
    {
        try 
        {
            Log::debug(sprintf('Sending expression approval e-mail to %s', $definition->email));
            Mail::send('emails.definitionApproved', array('contributor' => $definition->contributor, 'text' => $definition->expression()->first()->text), function($email) use($definition)
            {                    
                $email->from('no-reply@speaklikeabrazilian.com', 'Speak Like A Brazilian');   
                $email->to($definition->email, $definition->contributor);
                $email->subject('Your expression was published in Speak Like A Brazilian');
            });
        }
        catch (\Exception $e)
        {
            Log::warning("Error sending approval e-mail: " . $e->getMessage());
            Log::error($e);
        }
    }

    private function updateStatus($definitionId, $user, $status, $userIp)
    {
        Log::info(sprintf('User %d (%s) approving definition %d', $user->id, $user->email, $definitionId));

        $definition = $this->find($definitionId);
        $success = FALSE;

        DB::beginTransaction();
        try 
        {
            Log::debug(sprintf("Updating definition status to %s", ($status == 2 ? 'APPROVED' : 'REJECTED')));
            $definition->status = $status;
            $definition->save();
            $expression = $definition->expression()->first();

            if ($status == 2)
            {
                $this->addToSearchIndex($expression, $definition);
                $this->addAuthorVote($definition);
                //$this->sendApprovalEmail($definition);
            }

            Log::debug('Committing transaction');
            DB::commit();
            $success = TRUE;
            return $definition;
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
                $this->auditRepository->auditDefinitionModeration($definition, $userIp, $user->id);
            }
        }
    }

    public function approve($definitionId, $user, $userIp)
    {
        return $this->updateStatus($definitionId, $user, 2, $userIp);
    }

    public function reject($definitionId, $user, $userIp)
    {
        return $this->updateStatus($definitionId, $user, 3, $userIp);
    }

    public function edit(array $input, $ip)
    {
        Log::debug('Starting transaction to update definition');
        DB::beginTransaction();
        try 
        {
            // Get existing expressions
            $definition = $this->find($input['definition_id']);

            $definition->description = $input['expression-description-input'];
            $definition->example     = $input['expression-example-input'];
            $definition->tags        = $input['expression-tags-input'];

            $definition->save();

            $expression = $definition->expression()->first();

            $this->addToSearchIndex($expression, $definition);

            Log::debug('Committing transaction');
            DB::commit();
            Log::info(sprintf('Definition %s updated!', $definition['text']));
            return $definition;
        } 
        catch (\Exception $e) 
        {
            Log::debug('Rolling back transaction: ' . $e->getMessage());
            DB::rollback();
            throw $e;
        }
    }

}
