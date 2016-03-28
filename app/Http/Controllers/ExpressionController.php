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
use \Validator;
use Exception;
use SLBR\Models\Definition;
use SLBR\Repositories\DefinitionRepository;
use SLBR\Repositories\RatingRepository;
use SLBR\Repositories\MediaRepository;
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

    /**
     * SLBR\Repositories\MediaRepository
     */
    private $mediaRepository;

    public function __construct(DefinitionRepository $definitionRepository, RatingRepository $ratingRepository, MediaRepository $mediaRepository)
    {
        $this->definitionRepository = $definitionRepository;
        $this->ratingRepository = $ratingRepository;
        $this->mediaRepository = $mediaRepository;
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
        return view('add_expression', $data);
    }

    /**
     * Handle form submission to add expression.
     *
     * @param Illuminate\Http\Request $request
     */
    public function postAdd(Request $request)
    {
        $this->validate($request, array(
            'expression-text-input'             => 'required|min:1|max:255',
            'expression-description-input'      => 'required|min:1|max:1000',
            'expression-example-input'          => 'required|min:1|max:1000',
            'expression-tags-input'             => 'required|min:1|max:100',
            'expression-pseudonym-input'        => 'required|min:1|max:50',
            'expression-email-input'            => 'required|email|min:5|max:255',
            'username'                          => 'honeypot',
            'my_time'                           => 'required|honeytime:5'
        ));
        $languages = $request->get('languages');
        $language = $this->getLanguage($languages, $request);
        $definitions = $this->definitionRepository->add(Input::all(), $language, $request->getClientIp());
        return Redirect::to('/thankyou');
    }

    /**
     * Show thank you screen.
     *
     * @param Illuminate\Http\Request $request
     */
    public function getThankYou(Request $request)
    {
        $languages = $request->get('languages');
        $language = $this->getLanguage($languages, $request);
        $data = array(
            'languages' => $languages,
            'lang' => $language['id'],
            'selected_language' => $language['description']
        );
        return view('thankyou', $data);
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

    /**
     * Display form to add an image.
     *
     * @param Illuminate\Http\Request $request
     */
    public function getAddimage(Request $request)
    {
        // FIXME: validate definition ID
        $definitionId = $request->get('definition_id');
        $languages = $request->get('languages');
        $language = $this->getLanguage($languages, $request);
        $definition = $this->definitionRepository->getOne($definitionId)->toArray();
        $data = array(
            'languages' => $languages,
            'lang' => $language['id'],
            'selected_language' => $language['description'],
            'definition_id' => $definitionId,
            'definition' => $definition
        );
        return view('add_picture', $data);
    }

    /**
     * Handle form submission to add a picture to an expression.
     *
     * @param Illuminate\Http\Request $request
     */
    public function postPicture(Request $request)
    {
        $languages = $request->get('languages');
        $language = $this->getLanguage($languages, $request);

        $url = $request->get('picture-url-input');
        if (!preg_match('%(?:imgur\.com/)([^"&?/ ]{11})%i', $url, $match))
        {
            return redirect()->back()->withInput()->withErrors(['The picture URL is not valid. Only imgur pictures are allowed at the moment.']);
        }

        $media = $this->mediaRepository->addPicture(Input::all(), $language, $request->getClientIp());
        return Redirect::to('/thankyou');
    }

    /**
     * Display form to add a video.
     *
     * @param Illuminate\Http\Request $request
     */
    public function getAddvideo(Request $request)
    {
        // FIXME: validate definition ID
        $definitionId = $request->get('definition_id');
        $languages = $request->get('languages');
        $language = $this->getLanguage($languages, $request);
        $definition = $this->definitionRepository->getOne($definitionId)->toArray();
        $data = array(
            'languages' => $languages,
            'lang' => $language['id'],
            'selected_language' => $language['description'],
            'definition_id' => $definitionId,
            'definition' => $definition
        );
        return view('add_video', $data);
    }

    /**
     * Handle form submission to add a video to an expression.
     *
     * @param Illuminate\Http\Request $request
     */
    public function postVideo(Request $request)
    {
        $languages = $request->get('languages');
        $language = $this->getLanguage($languages, $request);

        $url = $request->get('video-url-input');
        if (!preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match))
        {
            return redirect()->back()->withInput()->withErrors(['The video URL is not valid. Only YouTube videos are allowed at the moment.']);
        }

        $media = $this->mediaRepository->addVideo(Input::all(), $language, $request->getClientIp());
        return Redirect::to('/thankyou');
    }

}