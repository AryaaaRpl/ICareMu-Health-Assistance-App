<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StartupPitchController extends Controller
{
    /**
     * Display the investor-grade startup pitch deck landing page.
     */
    public function index()
    {
        return view('pitch');
    }
}
