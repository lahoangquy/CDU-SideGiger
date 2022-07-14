<?php

namespace App\Http\Controllers\Api;

use App\Events\NewMessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\ProjectMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ApiMessageController extends Controller
{
    public function store(Request $request)
    {
        $message = ProjectMessage::create([
            'user_id' => $request->user()->id,
            'project_id' => $request->project_id,
            'comment' => $request->comment
        ]);

        $receiver = User::find($request->receiver_id);
        event(new NewMessageEvent($message, $receiver));

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function byProject($projectId)
    {
        $messages = ProjectMessage::query()
            ->with('user')
            ->where('project_id', $projectId)
            ->get();

        return MessageResource::collection($messages);
    }
}
