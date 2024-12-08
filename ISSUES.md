# Issues and Features Log

All issues to be fixed and features to be added in `filament-latex` will be documented in this file.

-[x] Make the plugin a resource with a schema
-[x] Fix navigation icon that is crashing the github actions
-[x] Allow resource to be publishable
-[ ] Add border around the editor and preview
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
