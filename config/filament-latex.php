<?php

return [
    'navigation-label' => 'Filament Latex',
    'navigation-icon' => null, // Override the navigation icon with a heroicon
    'navigation-group' => null,
    'list-page-title' => 'Latex Documents',
    'create-button-label' => 'Create Document',
    'create-page-title' => 'Create Latex Document',
    'user-model' => 'App\Models\User',
    'storage' => 'private',  // If you want to change the storage, you have to create a filesystem disk in config/filesystems.php
    'parser' => 'pdflatex', // The latex parser to use. Options: pdflatex, xelatex, lualatex (pdflatex is the default) Also, maybe add the path for the binary?. To be decided.
    'compilation-timeout' => 60, // The maximum time in seconds to wait for the compilation to finish.
];
