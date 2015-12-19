<?php

namespace SLBR\Http\Controllers;

class HomeController extends Controller
{

    public function __construct()
    {

    }

    public function getHome()
    {
        return view('home');
    }
}
