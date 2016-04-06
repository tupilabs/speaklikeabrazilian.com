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

use SLBR\Repositories\DefinitionRepository;
use SLBR\Repositories\MediaRepository;
use SLBR\Repositories\LanguageRepository;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Hashing\NativeHasher;

class ModeratorController extends Controller {

    /**
     * SLBR\Repositories\DefinitionRepository
     */
    private $definitionRepository;

    /**
     * SLBR\Repositories\MediaRepository
     */
    private $mediaRepository;

    /**
     * SLBR\Repositories\LanguageRepository
     */
    private $languageRepository;

    public function __construct(DefinitionRepository $definitionRepository, MediaRepository $mediaRepository, LanguageRepository $languageRepository)
    {
        $this->middleware('auth', ['except' => ['getLogin', 'postLogin']]);
        $this->definitionRepository = $definitionRepository;
        $this->mediaRepository = $mediaRepository;
        $this->languageRepository = $languageRepository;
    }

    public function getIndex()
    {
        $user = Sentinel::getUser();
        $countPendingExpressions = $this->definitionRepository->countPendingDefinitions();
        $countPendingVideos = $this->mediaRepository->countPendingVideos();
        $countPendingPictures = $this->mediaRepository->countPendingPictures();
        $data = array(
            'user' => $user,
            'count_pending_expressions' => $countPendingExpressions,
            'count_pending_videos' => $countPendingVideos,
            'count_pending_pictures' => $countPendingPictures,
            'title' => 'Moderators Area'
        );
        return view('moderators.home', $data);
    }

    public function getLogin()
    {
        return view('moderators.login');
    }

    public function getLogout()
    {
        Sentinel::logout(null, /* everywhere */ TRUE);
        return redirect('/moderators/login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, array(
            'moderator-email-input'             => 'required|email|min:5|max:255',
            'moderator-password-input'          => 'required|min:1|max:100',
            'username'                          => 'honeypot'
        ));

        $email      = $request->get('moderator-email-input');
        $password   = $request->get('moderator-password-input');

        $credentials = [
            'email'    => $email,
            'password' => $password,
        ];

        $response = Sentinel::authenticate($credentials);
        if (!$response)
            return redirect()->back()->withInput()->withErrors(['Invalid credentials!']);
        if (!Sentinel::inRole('mods'))
            return redirect()->back()->withInput()->withErrors(['Invalid credentials!']);
        return redirect('/moderators/');
    }

    public function getExpressions()
    {
        $user = Sentinel::getUser();
        $countPendingExpressions = $this->definitionRepository->countPendingDefinitions();
        $countPendingVideos = $this->mediaRepository->countPendingVideos();
        $countPendingPictures = $this->mediaRepository->countPendingPictures();
        $randomPendingExpression = $this->definitionRepository->getRandomPendingDefinition();
        $selectedLanguage = NULL;
        if ($randomPendingExpression)
        {
            $languageId = $randomPendingExpression['language_id'];
            $selectedLanguage = $this->languageRepository->find($languageId)->toArray();
        }
        $data = array(
            'user' => $user,
            'count_pending_expressions' => $countPendingExpressions,
            'count_pending_videos' => $countPendingVideos,
            'count_pending_pictures' => $countPendingPictures,
            'title' => 'Pending Expressions',
            'definition' => $randomPendingExpression,
            'selected_language' => $selectedLanguage
        );
        return view('moderators.expression', $data);
    }

    public function approveExpression(Request $request, $definition_id)
    {
        $user = Sentinel::getUser();
        $definition = $this->definitionRepository->approve($definition_id, $user, $request->getClientIp());
        return redirect('/moderators/expressions')->withInput()->with('success', sprintf('Expression %s approved!', $definition->expression()->first()->text));
    }

    public function rejectExpression(Request $request, $definition_id)
    {
        $user = Sentinel::getUser();
        $definition = $this->definitionRepository->reject($definition_id, $user, $request->getClientIp());
        return redirect('/moderators/expressions')->withInput()->with('success', sprintf('Expression %s approved!', $definition->expression()->first()->text));
    }

    public function getPictures()
    {
        $user = Sentinel::getUser();
        $countPendingExpressions = $this->definitionRepository->countPendingDefinitions();
        $countPendingVideos = $this->mediaRepository->countPendingVideos();
        $countPendingPictures = $this->mediaRepository->countPendingPictures();
        $randomPendingPicture = $this->mediaRepository->getRandomPendingPicture();
        $selectedLanguage = NULL;
        $definition = NULL;
        if ($randomPendingPicture)
        {
            $definition = $this->definitionRepository->getOne($randomPendingPicture['definition']['id'])->toArray();
            $languageId = $definition['language_id'];
            $selectedLanguage = $this->languageRepository->find($languageId)->toArray();
        }
        $data = array(
            'user' => $user,
            'count_pending_expressions' => $countPendingExpressions,
            'count_pending_videos' => $countPendingVideos,
            'count_pending_pictures' => $countPendingPictures,
            'title' => 'Pending Pictures',
            'picture' => $randomPendingPicture,
            'definition' => $definition,
            'selected_language' => $selectedLanguage
        );
        return view('moderators.picture', $data);
    }

    public function approvePicture(Request $request, $pictureId)
    {
        $user = Sentinel::getUser();
        $definition = $this->mediaRepository->approvePicture($pictureId, $user, $request->getClientIp());
        return redirect('/moderators/pictures')->withInput()->with('success', 'Picture %s approved!');
    }

    public function rejectPicture(Request $request, $pictureId)
    {
        $user = Sentinel::getUser();
        $definition = $this->mediaRepository->rejectPicture($pictureId, $user, $request->getClientIp());
        return redirect('/moderators/pictures')->withInput()->with('success', 'Picture %s approved!');
    }

    public function getVideos()
    {
        $user = Sentinel::getUser();
        $countPendingExpressions = $this->definitionRepository->countPendingDefinitions();
        $countPendingVideos = $this->mediaRepository->countPendingVideos();
        $countPendingPictures = $this->mediaRepository->countPendingPictures();
        $randomPendingVideo = $this->mediaRepository->getRandomPendingVideo();
        $selectedLanguage = NULL;
        $definition = NULL;
        if ($randomPendingVideo)
        {
            $definition = $this->definitionRepository->getOne($randomPendingVideo['definition']['id'])->toArray();
            $languageId = $definition['language_id'];
            $selectedLanguage = $this->languageRepository->find($languageId)->toArray();
        }
        $data = array(
            'user' => $user,
            'count_pending_expressions' => $countPendingExpressions,
            'count_pending_videos' => $countPendingVideos,
            'count_pending_pictures' => $countPendingPictures,
            'title' => 'Pending Videos',
            'video' => $randomPendingVideo,
            'definition' => $definition,
            'selected_language' => $selectedLanguage
        );
        return view('moderators.video', $data);
    }

    public function approveVideo(Request $request, $videoId)
    {
        $user = Sentinel::getUser();
        $definition = $this->mediaRepository->approveVideo($videoId, $user, $request->getClientIp());
        return redirect('/moderators/videos')->withInput()->with('success', 'Video %s approved!');
    }

    public function rejectVideo(Request $request, $videoId)
    {
        $user = Sentinel::getUser();
        $definition = $this->mediaRepository->rejectPicture($videoId, $user, $request->getClientIp());
        return redirect('/moderators/videos')->withInput()->with('success', 'Video %s approved!');
    }

    public function getEdit(Request $request)
    {
        $user = Sentinel::getUser();
        $countPendingExpressions = $this->definitionRepository->countPendingDefinitions();
        $countPendingVideos = $this->mediaRepository->countPendingVideos();
        $countPendingPictures = $this->mediaRepository->countPendingPictures();
        
        $definitionId = $request->get('definition_id', 0);
        $definition = NULL;
        $selectedLanguage = NULL;
        if ($definitionId)
        {
            $definition = $this->definitionRepository->getOne($definitionId);
            $languages = $request->get('languages');
            $selectedLanguage = $this->getLanguageByID($languages, $definition->language_id);
        }
        $data = array(
            'user' => $user,
            'count_pending_expressions' => $countPendingExpressions,
            'count_pending_videos' => $countPendingVideos,
            'count_pending_pictures' => $countPendingPictures,
            'title' => 'Edit Expression',
            'definition_id' => $definitionId,
            'definition' => $definition,
            'selected_language' => $selectedLanguage
        );
        return view('moderators.edit', $data);
    }

    public function postEdit(Request $request)
    {
        $user = Sentinel::getUser();
        $this->validate($request, array(
            'definition_id'                     => 'required|integer|min:1',
            'expression-description-input'      => 'required|min:1|max:1000',
            'expression-example-input'          => 'required|min:1|max:1000',
            'expression-tags-input'             => 'required|min:1|max:100'
        ));
        $definition = $this->definitionRepository->edit($request->all(), $user, $request->getClientIp());
        return redirect('/moderators/edit?definition_id=' . $definition['id']);
    }

    public function getPassword(Request $request)
    {
        $user = Sentinel::getUser();
        $countPendingExpressions = $this->definitionRepository->countPendingDefinitions();
        $countPendingVideos = $this->mediaRepository->countPendingVideos();
        $countPendingPictures = $this->mediaRepository->countPendingPictures();
        $data = array(
            'user' => $user,
            'count_pending_expressions' => $countPendingExpressions,
            'count_pending_videos' => $countPendingVideos,
            'count_pending_pictures' => $countPendingPictures,
            'title' => 'Change Password'
        );
        return view('moderators.password', $data);
    }

    public function postPassword(Request $request)
    {
        $this->validate($request, array(
            'password-current-input'      => 'required|min:1|max:255',
            'password-repeat-input'       => 'required|min:1|max:255|same:password-current-input',
            'password-new-input'          => 'required|min:1|max:255'
        ));
        $user = Sentinel::getUser();
        $current = $request->get('password-current-input');
        $newPass = $request->get('password-new-input');

        $hasher = new NativeHasher();

        if (!$hasher->check($current, $user->password))
        {
            return redirect()->back()->withInput()->withErrors(['Your password did not match']);
        }

        $user->password = $hasher->hash($newPass);
        $user->save();

        unset($user);
        unset($current);
        unset($newPass);

        return redirect('/moderators/logout');
    }

}
