<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MemeController extends Controller
{
    public function index()
    {
        return view('meme');
    }
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('public/uploads');
        $url = Storage::url($path);

        return response()->json(['url' => $url]);
    }
    public function download($filename)
{
    $path = storage_path('app/public/memes/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->download($path);
}
}
