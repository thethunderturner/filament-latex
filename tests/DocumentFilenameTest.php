<?php

use TheThunderTurner\FilamentLatex\Concerns\CanUseDocument;

it('generates a slugged filename with fallback', function () {
    $subject = new class {
        use CanUseDocument;

        public function filename(?string $name): string
        {
            return $this->getDocumentFilename($name);
        }
    };

    expect($subject->filename('My New Document'))->toBe('my-new-document')
        ->and($subject->filename('  Spaces  '))->toBe('spaces')
        ->and($subject->filename(null))->toBe('document')
        ->and($subject->filename('   '))->toBe('document');
});

