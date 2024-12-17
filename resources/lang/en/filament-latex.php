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
    'column' => [
        'id' => 'ID',
        'name' => 'Document Title',
        'deadline' => 'Deadline',
        'created_at' => 'Created At',
        'author_avatar' => 'Author',
        'collaborators_avatars' => 'Collaborators',
        'author' => [
            'name' => 'Author',
        ],
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
        'compile' => [
            'action' => 'Compile LaTeX',
            'success-title' => 'Document compiled successfully!',
            'success-body' => 'The document was compiled successfully.',
            'error-title' => 'Compilation Error.',
            'error-body' => 'There was an error compiling the document.',
        ],
        'create' => [
            'title' => 'Create Document',
            'notification' => 'Document created successfully!',
            'button' => 'Create Document',
        ],

        // Refers to the file upload action
        'file-upload' => [
            'title' => 'Upload Files',
            'icon' => 'heroicon-o-document-arrow-up',
            'heading' => 'Upload Files',
            'description' => 'Upload files to attach to the document.',
            'submit' => 'Upload File(s)',
        ],
        'list-page-title' => 'LaTeX Documents',
        'view-page-title' => 'View Document',
        'edit-page-title' => 'Edit Document',
    ],
];
