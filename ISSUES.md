# Issues and Features Log

All issues and features to be added in `filament-latex` will be documented in this file.

- Typing `ctrl + f` on codemirror, sends the state of the word you are searching, and thus latex parses it.
- Make the plugin a resource with a schema
- Add border around the editor and preview
- Switch from latexjs to textlive compiler
- Investigate: Can we use https://github.com/barryvdh/laravel-dompdf instead of latex-js for live preview?
- Make download pdf button
- Disable live preview and add a compile button
- Add edit history
- Can we add more latex packages (on top of the default ones)? -> fixed with textlive compiler
- When typing a latex command (ex `$...$`) the preview is disabled until the command is syntactically correct
- Add an error icon that shows the error message when hovering over it
- Make a codemirror language mode for latex [here](https://codemirror.net/examples/lang-package/)
- Allow resource to be publishable
