<?php

use TheThunderTurner\FilamentLatex\Resources\FilamentLatex\FilamentLatexResource;

return [
    'navigation-icon' => null,

    /**
     * Parser Settings
     *
     * The parser to use. Options: pdflatex, xelatex, lualatex (pdflatex is the default). The parser must be installed on the server.
     */
    'user-model' => 'App\Models\User',
    'resource' => FilamentLatexResource::class,
    'storage' => 'private',  // If you want to change the storage, you have to create a filesystem disk in config/filesystems.php
    'storage-url' => '/private_storage', // The URL to the storage disk. This is used to generate the download link.
    // The tex parser to use. Options: pdflatex, xelatex, lualatex (pdflatex is the default).
    'parsers' => [
        '/usr/bin/pdflatex' => 'pdflatex',
        '/usr/bin/xelatex' => 'xelatex',
        '/usr/bin/lualatex' => 'lualatex',
    ],
    'compilation-timeout' => 60, // The maximum time in seconds to wait for the compilation to finish.
    'auto-recompilation-delay' => 500, // The time to wait (in ms) before the document is automatically compiled
    'avatar-columns' => false, // If true, the avatar columns will be shown instead of the names of the author and collaborators.
];
