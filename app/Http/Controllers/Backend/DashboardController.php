<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $langActive = ['vi', 'en'];

    public function dashboard ()
    {
        return view('backend.index');
    }

    public function changeLanguage (Request $request, $language)
    {
        if (in_array($language, $this->langActive)) {
            $request->session()->put(['language' => $language]);
            return redirect()->back();
        }
    }
}
