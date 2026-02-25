<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function admin()
    {
        return view('dashboard/admin');
    }
}
