<?php

namespace App\Http\Controllers\Api;

use App\Const\ContractConst;
use App\Const\ProjectConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectContractFeedbackRequest;
use App\Http\Resources\ContractResource;
use App\Models\ProjectContract;
use App\Models\ProjectContractFeedback;
use Illuminate\Http\Request;

class ApiContractController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $userId = $request->user()->id;
        $query = ProjectContract::query()->with(['feedback', 'project', 'owner', 'student']);
        $query = $user->isPoster() ? $query->where('owner_id', $userId) : $query->where('student_id', $userId);

        return ContractResource::collection($query->orderBy('id', 'desc')->get());
    }

    public function show($id)
    {
        $contract = ProjectContract::query()
            ->with(['feedback', 'project', 'project.documents', 'owner', 'student'])
            ->where('id', $id)
            ->firstOrFail();
        return new ContractResource($contract);
    }

    public function feedback(ProjectContractFeedbackRequest $request, int $contractId)
    {
        $project = ProjectContract::find($contractId);
        if ($project->status != ContractConst::STATUS['completed']['value']) {
            return response()->json([
                'success' => false,
                'message' => 'Unfinished project',
            ], 500);
        }

        $message = ProjectContractFeedback::updateOrCreate([
            'contract_id' => $contractId
        ], [
            'user_id' => $request->user()->id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        if (!empty($message->id)) {
            return response()->json([
                'success' => true,
                'message' => 'Send feedback successfully',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unable to send feedback',
            ], 400);
        }
    }
}
