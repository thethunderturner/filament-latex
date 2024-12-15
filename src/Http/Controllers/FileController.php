<?php

namespace TheThunderTurner\FilamentLatex\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    public function getPrivateFile(Request $request, $recordID): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        if (! Auth::check()) {
            abort(403, 'Unauthorized');
        }
        $storage = Storage::disk(config('filament-latex.storage'));
        $pdfPath = $recordID . '/compiled/main.pdf';

        if (! $storage->exists($pdfPath)) {
            abort(404, 'File not found');
        }

        $pathToFile = $storage->path($pdfPath);

        return response()->file($pathToFile);
    }
}
