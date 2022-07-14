<?php

namespace App\Http\Controllers\Api;

use App\Const\ProjectConst;
use App\Events\ProposalProcessed;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\ProjectDocument;
use App\Models\ProjectOffer;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiProjectController extends Controller
{
    public function lists(Request $request)
    {
        $projects = Project::query()
            //->where('status', 1)
            ->with(['poster', 'feedback', 'documents', 'offers.user'])
            ->orderBy('created_at', 'desc')->get();
        return ProjectResource::collection($projects);
    }

    public function byOwner(Request $request)
    {
        $userId = $request->user()->id;

        $projects = Project::query()
            ->with(['poster', 'documents', 'offers.user'])
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')->get();

        return ProjectResource::collection($projects);
    }

    public function show($id)
    {
        try {
            $project = Project::query()
                ->with(['poster', 'offers.user', 'documents', 'requestCompleted'])
                ->where('id', $id)->first();

            return new ProjectResource($project);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function store(CreateProjectRequest $request)
    {
        try {
            $project = Project::create($request->validated());

            if (!empty($request['files'])) {
                foreach ($request['files'] as $file) {
                    ProjectDocument::create([
                        'project_id' => $project->id,
                        'file_name' => $file['file'],
                        'file_extension' => $file['extension'],
                        'moment' => 1,
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'project' => $project,
                'message' => 'The project was added successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot create project. Please try again'
            ]);
        }
    }

    /**
     * @param  \App\Http\Requests\UpdateProjectRequest $request
     * @param  integer                                 $id
     *
     * @return void
     */
    public function update(UpdateProjectRequest $request, int $id)
    {
        try {
            $project = Project::find($id);

            if (intval($project->status) >= ProjectConst::STATUS['in-progress']['value']) {
                throw new \Throwable();
            }

            $project->update($request->only(['title', 'category_id', 'due_date', 'description']));

            if (!empty($request['files'])) {
                ProjectDocument::where('project_id', $project->id)->delete();
                foreach ($request['files'] as $file) {
                    ProjectDocument::create([
                        'project_id' => $project->id,
                        'file_name' => $file['file'],
                        'file_extension' => $file['extension'],
                        'moment' => 1,
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'project' => $project,
                'message' => 'The project was added successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot update project. Please try again'
            ]);
        }
    }

    public function storeOffer(Request $request): JsonResponse
    {
        try {
            $project = Project::find($request->project_id);
            $now = Carbon::now();
            if ($now->diffInSeconds($project->due_date, false) < 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proposal has expired.',
                ], 400);
            }

            // Check if offer is existing for this student
            $isExisiting = $project->offers()
                ->where('user_id', $request->user_id)
                ->where('project_id', $request->project_id)
                ->where('status', '!=', 2)
                ->first();

            if ($isExisiting) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have submitted a proposal for this project.',
                ], 400);
            }

            $offer = ProjectOffer::create([
                'user_id' => $request->user_id,
                'project_id' => $request->project_id,
                'comment' => nl2br($request->comment),
                'status' => 1
            ]);

            // Send a notify to task's owner
            event(new ProposalProcessed($offer));

            return response()->json([
                'success' => true,
                'message' => 'Your offer was submitted',
                'offer' => $offer
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again',
            ], 500);
        }
    }

    public function destroy($projectId)
    {
        $project = Project::findOrFail($projectId);
        try {
            if (intval($project->status) >= ProjectConst::STATUS['in-progress']['value']) {
                throw new \Throwable();
            }

            if ($project->documents) {
                foreach ($project->documents as $file) {
                    Storage::delete('public/uploads/' . $file->file_name);
                }
            }

            $project->delete();
            return response()->json([
                'success' => true,
                'message' => 'The project was deleted successfully.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete project'
            ]);
        }
    }
}
