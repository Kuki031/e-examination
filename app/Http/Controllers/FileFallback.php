<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileFallback extends Controller
{
    public function serveFiles(string $path)
    {

        $disk = Storage::disk('public');
        if (! $disk->exists($path)) {
            abort(404);
        }

        $absolutePath = $disk->path($path);

        $root = realpath(storage_path('app/public'));
        $real = realpath($absolutePath);
        if ($real === false || strpos($real, $root) !== 0) {
            abort(404);
        }

        $mime = File::mimeType($absolutePath) ?? 'application/octet-stream';
        return response()->file($absolutePath, [
            'Content-Type'  => $mime,
            'Cache-Control' => 'public, max-age=31536000, immutable',
            'Last-Modified' => gmdate('D, d M Y H:i:s', filemtime($absolutePath)).' GMT',
        ]);
    }
}
