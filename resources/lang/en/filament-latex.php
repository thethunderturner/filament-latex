<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    'field' => [
        'name' => 'Document Title',
        'deadline' => 'Deadline',
        'author_id' => 'Author',
        'collaborators_id' => 'Collaborators',
    ],

    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */
    'columns' => [
        'id' => 'ID',
        'name' => 'Document1 Title',
        'deadline' => 'Deadline',
        'created_at' => 'Created At',
        'author_avatar' => 'Author',
        'collaborators_avatars' => 'Collaborators',
        'author.name' => 'Author',
        'collaborators' => 'Collaborators',
        'updated_at' => 'Last Updated',
    ],

    /*
    |--------------------------------------------------------------------------
    | LaTeX Page Labels
    |--------------------------------------------------------------------------
    */
    'page' => [
        'download.tooltip' => 'Download PDF',
        'compile.action' => 'Compile LaTeX',
        'create-button-label' => 'Create Document',
        'list-page-title' => 'LaTeX Documents',
        'view-page-title' => 'View Document',
        'edit-page-title' => 'Edit Document',
        'create-page-title' => 'Create Document',
        'create-page-notification-title' => 'Document created successfully!',
    ],
];
