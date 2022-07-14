<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    const PATH_UPLOAD = 'public/uploads';

    public function index(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->extension();
        $imageName = str_replace(' ', '_', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $extension);
        $path = $file->storeAs(self::PATH_UPLOAD, $imageName);

        return response()->json([
            'success' => 'You have successfully upload file.',
            'path' => $path,
            'fileName' => $imageName,
            'extension' => $extension
        ]);
    }

    public function remove(Request $request)
    {
        $fileName = $request->fileName;
        Storage::delete(self::PATH_UPLOAD . '/' . $fileName);

        return response()->json([
            'success' => 'true',
            'message' => "$fileName was removed successfully."
        ]);
    }
}
