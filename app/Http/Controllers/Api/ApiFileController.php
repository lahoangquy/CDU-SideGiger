<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentResource;
use App\Models\ProjectDocument;
use Illuminate\Http\Request;

class ApiFileController extends Controller
{
    public function byProject($projectId)
    {
        $attachments = ProjectDocument::where('project_id', $projectId)->get();

        return DocumentResource::collection($attachments);
    }
}
