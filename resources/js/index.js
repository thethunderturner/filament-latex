import { EditorView, basicSetup } from 'codemirror';
import { markdown } from '@codemirror/lang-markdown';
import { EditorState } from '@codemirror/state';
import { defaultKeymap } from "@codemirror/commands";
import { keymap } from '@codemirror/view'

export default function codeEditor({content}) {
    return {
        init() {
            const editor = new EditorView({
                state: EditorState.create({
                    doc: content,
                    extensions: [
                        basicSetup,
                        keymap.of(defaultKeymap),
                        markdown(),
                        EditorView.lineWrapping,
                        // Add an update listener to track changes
                        EditorView.updateListener.of((update) => {
                            if (update.docChanged) {
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
