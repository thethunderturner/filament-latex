<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    'field' => [
        'name' => 'Documenttitel',
        'deadline' => 'Deadline',
        'author_id' => 'Auteur',
        'collaborators_id' => 'Deelnemers',
    ],

    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */
    'column' => [
        'id' => 'ID',
        'name' => 'Documenttitel',
        'deadline' => 'Deadline',
        'created_at' => 'Aangemaakt op',
        'author_avatar' => 'Auteur',
        'collaborators_avatars' => 'Deelnemers',
        'author' => [
            'name' => 'Auteur',
        ],
        'collaborators' => 'Medewerkers',
        'updated_at' => 'Laatst bijgewerkt',
    ],

    /*
    |--------------------------------------------------------------------------
    | LaTeX Page Labels
    |--------------------------------------------------------------------------
    */
    'page' => [
        'download.tooltip' => 'PDF Downloaden',
        'compile' => [
            'action' => 'Compile LaTeX',
            'success-title' => 'Document succesvol gecompileerd!',
            'success-body' => 'Het document is succesvol gecompileerd.',
            'error-title' => 'Compilatiefout.',
            'error-body' => 'Er is een fout opgetreden bij het compileren van het document.',
        ],
        'create' => [
            'title' => 'Document aanmaken',
            'notification' => 'Document succesvol aangemaakt!',
            'button' => 'Document aanmaken',
        ],

        // Refers to the file upload action
        'file-upload' => [
            'title' => 'Bestanden uploaden',
            'icon' => 'heroicon-o-document-arrow-up',
            'heading' => 'Bestanden uploaden',
            'description' => 'Upload bestanden om aan het document toe te voegen.',
            'submit' => 'Bestand(en) uploaden',
        ],
        'list-page-title' => 'LaTeX-documenten',
        'view-page-title' => 'Document bekijken',
        'edit-page-title' => 'Document bewerken',
    ],
];
