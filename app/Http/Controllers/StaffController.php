<?php

namespace App\Http\Controllers;

class StaffController extends Controller
{
    public function dashboard()
    {
        return view('front-end.staff.dashboard');
    }

    public function contactInfo()
    {
        return view('front-end.staff.setting');
    }

    public function myProfile()
    {
        return view('front-end.staff.dashboard.my-profile');
    }
}
