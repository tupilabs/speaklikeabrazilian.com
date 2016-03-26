<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2013-2016 TupiLabs
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
namespace SLBR\Http\Controllers;

use \Input;
use \Redirect;
use \Log;
use Exception;
use SLBR\Models\Definition;
use SLBR\Repositories\DefinitionRepository;
use SLBR\Repositories\RatingRepository;
use Illuminate\Http\Request;

class ExpressionController extends Controller {

    /**
     * SLBR\Repositories\DefinitionRepository
     */
    private $definitionRepository;

    /**
     * SLBR\Repositories\RatingRepository
     */
    private $ratingRepository;

    public function __construct(DefinitionRepository $definitionRepository, RatingRepository $ratingRepository)
    {
        $this->definitionRepository = $definitionRepository;
        $this->ratingRepository = $ratingRepository;
    }

    /**
     * Get new expressions. Also used as landing page.
     *
     * @param Illuminate\Http\Request $request
     */
    public function getNew(Request $request)
    {
        $languages = $request->get('languages');
        $language = $this->getLanguage($languages, $request);
        $definitions = $this->definitionRepository->getNew($language);
        $data = array(
            'active' => 'new',
            'languages' => $languages,
            'definitions' => $definitions['data'],
            'pagination' => $definitions
        );
        return view('home', $data);
    }

    /**
     * Get top expressions. The ranking is created summing all the likes, minus the dislikes.
     *
     * @param Illuminate\Http\Request $request
     */
    public function getTop(Request $request)
    {
        $languages = $request->get('languages');
        $language = $this->getLanguage($languages, $request);
        $definitions = $this->definitionRepository->getTop($language);
        $data = array(
            'active' => 'top',
            'languages' => $languages,
            'definitions' => $definitions['data'],
            'pagination' => $definitions
        );
        return view('home', $data);
    }

    /**
     * Get random expressions. Relies on RAND() when using MySQL and RANDOM() otherwise (sqlite, for example).
     *
     * @param Illuminate\Http\Request $request
     */
    public function getRandom(Request $request)
    {
        $languages = $request->get('languages');
        $language = $this->getLanguage($languages, $request);
        $definitions = $this->definitionRepository->getRandom($language);
        $data = array(
            'active' => 'random',
            'languages' => $languages,
            'definitions' => $definitions
        );
        return view('home', $data);
    }

    /**
     * Get the list of definitions for a given expression.
     *
     * @param Illuminate\Http\Request $request
     */
    public function getDefine(Request $request)
    {
        $languages = $request->get('languages');
        $language = $this->getLanguage($languages, $request);
        $text = Input::get('e');
        $definitions = $this->definitionRepository->getDefinitions($text, $language);
        $definitions->appends(Input::except('page'));
        $definitions = $definitions->toArray();
        $data = array(
            'active' => 'random',
            'languages' => $languages,
            'definitions' => $definitions['data'],
            'pagination' => $definitions,
            'query_parameters' => sprintf("&e=%s", urlencode($text))
        );
        return view('home', $data);
    }

    /**
     * Get a list of definitions for a given letter.
     *
     * @param Illuminate\Http\Request $request
     */
    public function getLetter(Request $request, $letter)
    {
        $languages = $request->get('languages');
        $language = $this->getLanguage($languages, $request);
        $queryLetter = $letter === '0-9' ? '0' : strtoupper($letter);
        $definitions = $this->definitionRepository->getLetter($queryLetter, $language);
        $data = array(
            'active' => $letter,
            'languages' => $languages,
            'definitions' => $definitions['data'],
            'pagination' => $definitions
        );
        return view('home', $data);
    }

    /**
     * Display form to add expression.
     *
     * @param Illuminate\Http\Request $request
     */
    public function getAdd(Request $request)
    {
        $languages = $request->get('languages');
        $language = $this->getLanguage($languages, $request);
        $expression = Input::get('e');
        $data = array(
            'languages' => $languages,
            'lang' => $language['id'],
            'selected_language' => $language['description'],
            'expression' => $expression
        );
        return view('add', $data);
    }

    /**
     * Handle form submission to add expression.
     *
     * @param Illuminate\Http\Request $request
     */
    public function postAdd(Request $request)
    {
        $languages = $request->get('languages');
        $language = $this->getLanguage($languages, $request);
        $definitions = $this->definitionRepository->add(Input::all(), $language, $request->getClientIp());
        return Redirect::to('/new');        
    }

    /**
     * Handle form submission to like expression.
     *
     * @param Illuminate\Http\Request $request
     */
    public function postLike(Request $request)
    {
        $definitionId = $request->get('definition_id');
        $ip = $request->getClientIp();
        $json = NULL;
        try
        {
            $balance = $this->ratingRepository->like($ip, $definitionId);
            $json = response()->json(['message' => 'OK', 'balance' => $balance]);
        } 
        catch (Exception $e)
        {
            Log::error($e);
            $json = response()->json(['message' => $e->getMessage()]);
        }
        return $json;
    }

    /**
     * Handle form submission to dislike expression.
     *
     * @param Illuminate\Http\Request $request
     */
    public function postDislike(Request $request)
    {
        $definitionId = $request->get('definition_id');
        $ip = $request->getClientIp();
        $json = NULL;
        try
        {
            $balance = $this->ratingRepository->dislike($ip, $definitionId);
            $json = response()->json(['message' => 'OK', 'balance' => $balance]);
        } 
        catch (Exception $e)
        {
            $json = response()->json(['message' => $e->getMessage()]);
        }
        return $json;
    }

    public function postVideos()
    {
        Log::info(sprintf('User %s wants to share a new video %s for definition ID %d', 
            Request::getClientIp(), Input::get('youtube_url'), Input::get('definitionId')));
        $url = Input::get('youtube_url');
        if (!preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match))
        {
            $args = array();
            $args['message'] = 'Sorry, only YouTube videos are allowed at the moment.';
            Log::error(sprintf('Error uploading video %s to definition %d', $url, Input::get('definitionId')));
            $this->theme->layout('message');
            return $this->theme->scope('message', $args)->render();
        }
        $media = Media::create(
            array(
                'definition_id' => Input::get('definitionId'),
                'url' => $url,
                'reason' => Input::get('reason'),
                'email' => Input::get('email'),
                'status' => 1, 
                'contributor' => Input::get('contributor'),
                'content_type' => 'video/youtube'
            )
        );
        if($media->isValid() && $media->isSaved())
        {
            $args = array();
            $args['message'] = Lang::get('messages.video_added');
            $this->theme->layout('message');
            return $this->theme->scope('message', $args)->render();
        } 
        else
        {
            $args = array();
            $args['message'] = Lang::get('messages.video_not_added');
            Log::error(sprintf('Error uploading video %s to definition %d', $url, Input::get('definitionId')));
            $this->theme->layout('message');
            return $this->theme->scope('message', $args)->render();
        }
    }

    public function postPictures()
    {
        Log::info(sprintf('User %s wants to share a new picture %s for definition ID %d', 
            Request::getClientIp(), Input::get('url'), Input::get('definitionId')));
        $url = Input::get('url');
        if (!preg_match('%(?:imgur\.com/)([^"&?/ ]{11})%i', $url, $match))
        {
            $args = array();
            $args['message'] = 'Sorry, only imgur links are allowed at the moment.';
            Log::error(sprintf('Error uploading picture %s to definition %d', $url, Input::get('definitionId')));
            $this->theme->layout('message');
            return $this->theme->scope('message', $args)->render();
        }
        $media = Media::create(
            array(
                'definition_id' => Input::get('definitionId'),
                'url' => Input::get('url'),
                'reason' => Input::get('reason'),
                'email' => Input::get('email'),
                'status' => 1, 
                'contributor' => Input::get('contributor'),
                'content_type' => 'image/unknown'
            )
        );
        if($media->isValid() && $media->isSaved())
        {
            $args = array();
            $args['message'] = Lang::get('messages.picture_added');
            $this->theme->layout('message');
            return $this->theme->scope('message', $args)->render();
        } 
        else
        {
            return Redirect::to(sprintf('expression/%d/pictures?expressionId=%d', Input::get('definitionid'), Input::get('expressionId')))
                ->withErrors($media->errors)
                ->withInput();
        }
    }

}