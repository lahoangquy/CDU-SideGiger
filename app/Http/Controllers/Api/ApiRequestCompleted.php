<?php

namespace App\Http\Controllers\Api;

use App\Events\RequestCompleteEvent;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\RequestCompleted;
use Illuminate\Http\Request;

class ApiRequestCompleted extends Controller
{
    public function store(Request $request)
    {
        $project = Project::find($request->project_id);

        if ($project->requestCompleted) {
            return response()->json([
                'success' => false,
                'message' => 'A request was existing for this project'
            ], 400);
        }

        RequestCompleted::create([
            'student_id' => $request->user()->id,
            'project_id' => $request->project_id
        ]);

        $sender = $request->user();
        $owner = $project->poster;

       // event(new RequestCompleteEvent($project, $sender, $owner));

        return response()->json([
            'success' => true,
            'message' => 'Your request was sent'
        ]);
    }
}
