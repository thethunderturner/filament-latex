# Issues and Features Log

All issues to be fixed and features to be added in `filament-latex` will be documented in this file.

-[x] Make the plugin a resource with a schema
-[x] Fix navigation icon that is crashing the github actions
-[ ] Allow resource to be publishable
-[x] Add border around the editor and preview
-[ ] Typing `ctrl + f` on codemirror, sends the state of the word you are searching, and thus latex parses it.
-[ ] Switch from latexjs to textlive compiler
-[ ] Investigate: Can we use https://github.com/barryvdh/laravel-dompdf instead of latex-js for live preview?
-[ ] Make download pdf button
-[ ] Disable live preview and add a compile button
-[ ] Add livewire component on the left where you can upload images which can be rendered on the latex document
-[ ] Add edit history (maybe through slide-over?)
-[ ] Can we add more latex packages (on top of the default ones)? -> fixed with textlive compiler
-[ ] When typing a latex command (ex `$...$`) the preview is disabled until the command is syntactically correct
-[ ] Add an error icon that shows the error message when hovering over it
-[ ] Make a codemirror language mode for latex [here](https://codemirror.net/examples/lang-package/)
-[ ] Add translations
-[ ] Add Prettier for js, blade, tailwindcss
-[ ] Connect the 2 header actions similar to the inline grouped toggle buttons. You have the pdf icon on the left and on the right the compile button.
-[x] FIx the author component in the form
-[ ] Add option to display either avatar or names in the author and collaborator columns
-[ ] Collaborative editing for codemirror [here](https://codemirror.net/examples/collab/)
-[x] Fix disappearing editor after livewire update
