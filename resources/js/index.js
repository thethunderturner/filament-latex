import { basicSetup, EditorView } from 'codemirror'
import { EditorState } from '@codemirror/state'
import { defaultKeymap } from '@codemirror/commands'
import { keymap } from '@codemirror/view'
import * as pdfjsLib from 'pdfjs-dist'
import pdfWorkerSource from 'pdfjs-dist/build/pdf.worker.mjs?raw'

function codeEditor({ content }) {
    return {
        init() {
            const editor = new EditorView({
                state: EditorState.create({
                    doc: content,
                    extensions: [
                        basicSetup,
                        keymap.of(defaultKeymap),
                        EditorView.lineWrapping,
                        // Add an update listener to track changes
                        EditorView.updateListener.of((update) => {
                            if (update.docChanged) {
                                this.$dispatch(
                                    'input',
                                    update.state.doc.toString(),
                                )
                            }
                        }),
                    ],
                }),
                parent: this.$el,
            })
        },
    }
}

/**
 * PDF Viewer Component
 * @param {Object} params
 * @param {string} params.content - URL of the PDF to load
 * @returns {Object} Alpine.js component
 */
function pdfViewer({ content }) {
    return {
        async init() {
            pdfjsLib.GlobalWorkerOptions.workerSrc = '/dist/pdf.worker.js';

            const container = this.$el; // The container for rendering PDF pages

            const loadingTask = pdfjsLib.getDocument(content);
            loadingTask.promise.then((pdf) => {
                console.log('PDF loaded');
                // Render all pages
                for (let i = 1; i <= pdf.numPages; i++) {
                    pdf.getPage(i).then((page) => {
                        const viewport = page.getViewport({ scale: 1.5 });
                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d');

                        canvas.width = viewport.width;
                        canvas.height = viewport.height;

                        container.appendChild(canvas);

                        const renderContext = {
                            canvasContext: context,
                            viewport: viewport,
                        };
                        page.render(renderContext);
                    });
                }
            }).catch((error) => {
                console.error('Error loading PDF:', error);
            });
        },
    };
}

export { codeEditor, pdfViewer }
