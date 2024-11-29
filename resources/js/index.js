import { EditorView, basicSetup } from 'codemirror';
import { javascript } from '@codemirror/lang-javascript';
import { EditorState } from '@codemirror/state';
import { defaultKeymap } from "@codemirror/commands";
import { keymap } from '@codemirror/view';
import { HtmlGenerator } from 'latex.js';

export default function codeEditor() {
    return {
        content: '\\documentclass{article}\n\\begin{document}\nHello LaTeX\n\\end{document}',
        init() {
            new EditorView({
                state: EditorState.create({
                    doc: this.content,
                    extensions: [
                        basicSetup,
                        keymap.of(defaultKeymap),
                        javascript(),
                        EditorView.lineWrapping,
                        EditorView.updateListener.of((update) => {
                            if (update.docChanged) {
                                this.content = update.state.doc.toString();
                                this.renderLatex();
                            }
                        }),
                    ]
                }),
                parent: this.$el
            });
        },
        renderLatex() {
            const previewContainer = document.getElementById('latex-preview');
            previewContainer.innerHTML = this.content;
        }
    };
}
