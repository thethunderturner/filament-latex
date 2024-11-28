import { EditorView, basicSetup } from 'codemirror'
import { javascript } from '@codemirror/lang-javascript'
import { EditorState } from '@codemirror/state'
import {defaultKeymap} from "@codemirror/commands"
import { keymap } from '@codemirror/view'

export default function codeEditor() {
    return {
        init() {
            new EditorView({
                state: EditorState.create({
                    doc: '\\documentclass{article}\n\\begin{document}\nHello LaTeX\n\\end{document}',
                    extensions: [basicSetup, keymap.of(defaultKeymap), javascript()]
                }),
                parent: this.$el
            })
        }
    }
}
