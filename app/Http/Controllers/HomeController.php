<?php
namespace SLBR\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {

    }

    public function getHome(Request $request)
    {
        $languages = $request->get('languages');
        return view('home', array('languages' => $languages));
    }
}
