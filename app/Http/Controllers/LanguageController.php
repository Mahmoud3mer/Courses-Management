<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLocale(Request $request)
    {
        $language = $request->get('language');
        App::setLocale($language);

        Session::put('locale', $language);
        return redirect()->back();
    }
}
