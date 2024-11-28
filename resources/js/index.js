import { EditorView, basicSetup } from 'codemirror'
import { javascript } from '@codemirror/lang-javascript'
import { EditorState } from '@codemirror/state'

export default function codeEditor() {
    return {
        init() {
            new EditorView({
                state: EditorState.create({
                    doc: 'Hello World',
                    extensions: [basicSetup, javascript()]
                }),
                parent: this.$el
            })
        }
    }
}
