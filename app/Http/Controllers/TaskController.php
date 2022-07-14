<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        return view('front-end.task.index');
    }

    public function proprosal(int $projectId): View
    {
        return view('front-end.task.proposal', ['projectId' => $projectId]);
    }
}
