import { EditorView, basicSetup } from 'codemirror';
import { javascript } from '@codemirror/lang-javascript';
import { EditorState } from '@codemirror/state';
import { defaultKeymap } from "@codemirror/commands";
import { keymap } from '@codemirror/view';
import { HtmlGenerator } from 'latex.js';

export default function codeEditor() {
    return {
        content: '\\documentclass{article}\n\\begin{document}\n\n\n\\end{document}',
        init() {
            const editor = new EditorView({
                state: EditorState.create({
                    doc: this.content,
                    extensions: [
                        basicSetup,
                        keymap.of(defaultKeymap),
                        javascript(),
                        EditorView.lineWrapping,
                        EditorView.updateListener.of((update) => {
                            if (update.docChanged) {
                                // Update the Alpine.js property 'message'
                                this.$dispatch('input', update.state.doc.toString());
                            }
                        }),
                    ]
                }),
                parent: this.$el
            });
        }
    };
}
