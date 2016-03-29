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
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Illuminate\Http\Request;

class ModeratorController extends Controller {

    /**
     * SLBR\Repositories\DefinitionRepository
     */
    private $definitionRepository;

    /**
     * SLBR\Repositories\MediaRepository
     */
    private $mediaRepository;

    public function __construct(DefinitionRepository $definitionRepository, MediaRepository $mediaRepository)
    {
        $this->middleware('auth', ['except' => ['getLogin', 'postLogin']]);
        $this->definitionRepository = $definitionRepository;
        $this->mediaRepository = $mediaRepository;
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
            'count_pending_pictures' => $countPendingPictures
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
        return redirect('/moderators/');
    }

}
