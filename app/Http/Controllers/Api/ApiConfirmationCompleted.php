<?php

namespace App\Http\Controllers\Api;

use App\Const\ContractConst;
use App\Const\ProjectConst;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectContract;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiConfirmationCompleted extends Controller
{
    public function store(Request $request)
    {
        $project = Project::find($request->project_id);

        if (!$project->requestCompleted) {
            return response()->json([
                'success' => false,
                'message' => 'There are no requests for this project yet'
            ], 400);
        }

        $project->completed_date = Carbon::now();
        $project->status = ProjectConst::STATUS['completed']['value'];
        $project->save();

        ProjectContract::where('project_id', $request->project_id)->update([
            'status' => ContractConst::STATUS['completed']['value'],
            'completed_at' => Carbon::now()
        ]);

        /* event(new RequestCompleteEvent($project, $sender, $owner)); */

        return response()->json([
            'success' => true,
            'message' => 'Successful confirmation'
        ]);
    }
}
