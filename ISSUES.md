# Issues and Features Log

All issues to be fixed and features to be added in `filament-latex` will be documented in this file.

-[x] Make the plugin a resource with a schema
-[x] Fix navigation icon that is crashing the github actions
-[ ] Allow resource to be publishable
-[x] Add border around the editor and preview
-[x] Typing `ctrl + f` on codemirror, sends the state of the word you are searching, and thus latex parses it.
-[x] Switch from latexjs to textlive compiler
-[x] Investigate: Can we use https://github.com/barryvdh/laravel-dompdf instead of latex-js for live preview?
-[x] Make download pdf button
-[x] Disable live preview and add a compile button
-[ ] Add livewire component on the left where you can upload images which can be rendered on the latex document
-[ ] Dont allow to upload multiple files with the same name.
-[ ] Add edit history (maybe through slide-over?)
-[x] Can we add more latex packages (on top of the default ones)? -> fixed with textlive compiler
-[x] When typing a latex command (ex `$...$`) the preview is disabled until the command is syntactically correct
-[ ] Add an error icon that shows the error message when hovering over it
-[ ] Make a codemirror language mode for latex [here](https://codemirror.net/examples/lang-package/)
-[ ] Add translations
-[ ] Add Prettier for js, blade, tailwindcss
-[x] Connect the 2 header actions similar to the inline grouped toggle buttons. You have the pdf icon on the left and on the right the compile button.
-[x] FIx the author component in the form
-[ ] Add option to display either avatar or names in the author and collaborator columns
-[ ] Collaborative editing for codemirror [here](https://codemirror.net/examples/collab/)
-[x] Fix disappearing editor after livewire update
-[ ] Add hasinstallcommand in the service provider [see here](https://github.com/awcodes/filament-curator/blob/3.x/src/CuratorServiceProvider.php)
-[ ] Dont use `Hidden` form component as that is a security risk. Just use `Select` instead.
-[ ] The file controller should be authenticated with ->middleware('auth'). For some reason it doesnt work. Needs investigation.
-[ ] Change how the pdf gets the name. Instead of default "main" it gets the slug of the record name.
-[x] Error when compiling. But it actually compiles fine.
-[ ] Change how includegraphiocs works. Instead of using the directory from home, use the name of the file. We still havent implemented folders, so just the file name is enough.
-[ ] Add ability to have multiple .tex files. This could be tricky. Leave for last!
