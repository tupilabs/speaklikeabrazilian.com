<?php

namespace SLBR\Http\Controllers;

use \App;
use \Lang;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getLanguage($languages, $request)
    {
        $slug = App::getLocale();
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

    protected function getLanguageBySlug($languages, $slug)
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

    protected function getLanguageByID($languages, $languageId)
    {
        $languageFound = null;
        foreach ($languages as $language)
        {
            if ($language['id'] == $languageId)
            {
                $languageFound = $language;
                break;
            }
        }
        return $languageFound;
    }
}
