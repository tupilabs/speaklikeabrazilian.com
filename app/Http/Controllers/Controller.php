<?php

namespace SLBR\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getLanguage($slug, $languages)
    {
        $languageFound = null;
        foreach ($languages as $language)
        {
            if (strcmp($language['slug'], $slug) == 0)
            {
                $languageFound = $language;
                break;
            }
        }
        return $languageFound;
    }
}
