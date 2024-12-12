<?php

namespace TheThunderTurner\FilamentLatex\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller
{
    public function getPrivateFile(Request $request, $recordID): BinaryFileResponse
    {
        $storage = Storage::disk(config('filament-latex.storage'));
        $pdfPath = $recordID . '/compiled/main.pdf';

        if (! $storage->exists($pdfPath)) {
            abort(404, 'File not found');
        }

        $pathToFile = $storage->path($pdfPath);

        return new BinaryFileResponse($pathToFile, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="main.pdf"',
        ]);
    }
}
