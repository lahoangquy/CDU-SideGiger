<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function listProjectInvited()
    {
        return view('dashboard.student.list-invited');
    }

    public function listProjectApplicated()
    {
        return view('dashboard.student.list-applicated');
    }
}
