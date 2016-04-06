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

use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Illuminate\Http\Request;

class AdministratorController extends Controller
{

    public function getLogin()
    {
        return view('administrators.login');
    }

    public function getLogout()
    {
        Sentinel::logout(null, /* everywhere */ true);
        return redirect('/admin/login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, array(
            'administrator-email-input'             => 'required|email|min:5|max:255',
            'administrator-password-input'          => 'required|min:1|max:100',
            'username'                              => 'honeypot'
        ));

        $email      = $request->get('administrator-email-input');
        $password   = $request->get('administrator-password-input');

        $credentials = [
            'email'    => $email,
            'password' => $password,
        ];

        $response = Sentinel::authenticate($credentials);
        if (!$response) {
            return redirect()->back()->withInput()->withErrors(['Invalid credentials!']);
        }
        if (!Sentinel::inRole('admins')) {
            return redirect()->back()->withInput()->withErrors(['Invalid credentials!']);
        }
        return redirect('/admin/');
    }
}
