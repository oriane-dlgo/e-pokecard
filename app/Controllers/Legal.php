<?php

namespace App\Controllers;

class Legal extends BaseController
{
    public function mentions()
    {
        return view('legal/mentions');
    }

    public function cgv()
    {
        return view('legal/conditions');
    }

    public function privacy()
    {
        return view('legal/privacy');
    }
}