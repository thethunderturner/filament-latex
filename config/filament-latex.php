<?php

return [
    /**
     * UI customizations
     */
    'navigation-label' => 'Filament Latex',
    'navigation-icon' => null, // Override the navigation icon with a heroicon
    'navigation-group' => null,
    'list-page-title' => 'Latex Documents',
    'create-button-label' => 'Create Document',
    'create-page-title' => 'Create Latex Document',

    /**
     * Parser Settings
     *
     * The parser to use. Options: pdflatex, xelatex, lualatex (pdflatex is the default). The parser must be installed on the server.
     */
    'user-model' => 'App\Models\User',
    'storage' => 'private',  // If you want to change the storage, you have to create a filesystem disk in config/filesystems.php
    'storage-url' => '/private_storage', // The URL to the storage disk. This is used to generate the download link.
    'parser' => '/usr/bin/pdflatex', // The latex parser to use. Options: pdflatex, xelatex, lualatex (pdflatex is the default).
    'compilation-timeout' => 60, // The maximum time in seconds to wait for the compilation to finish.
    'strict-compilation' => false, // Options: strict, non-strict. Strict mode will throw exceptions on compilation errors, otherwise it will not.
    'avatar-columns' => false, // If true, the avatar columns will be shown instead of the names of the author and collaborators.
];
