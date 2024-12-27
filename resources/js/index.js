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
            const container = this.$el;

            // Function to calculate optimal scale
            const calculateOptimalScale = (page, containerWidth, containerHeight) => {
                const viewport = page.getViewport({ scale: 1.0 });
                const containerAspectRatio = containerWidth / containerHeight;
                const pageAspectRatio = viewport.width / viewport.height;

                let scale;
                if (containerAspectRatio > pageAspectRatio) {
                    // Container is wider than page
                    scale = (containerHeight * 0.95) / viewport.height;
                } else {
                    // Container is taller than page
                    scale = (containerWidth * 0.95) / viewport.width;
                }

                return scale;
            };

            // Create a wrapper div for proper scrolling
            const wrapper = document.createElement('div');
            wrapper.style.cssText = 'width: 100%; height: 100%; overflow: auto; position: relative;';
            container.appendChild(wrapper);

            try {
                const loadingTask = pdfjsLib.getDocument(content);
                const pdf = await loadingTask.promise;
                console.log('PDF loaded');

                // Get container dimensions
                const containerWidth = wrapper.clientWidth;
                const containerHeight = wrapper.clientHeight;

                // Render all pages
                for (let i = 1; i <= pdf.numPages; i++) {
                    const page = await pdf.getPage(i);
                    const scale = calculateOptimalScale(page, containerWidth, containerHeight);
                    const viewport = page.getViewport({ scale });

                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');

                    canvas.width = viewport.width;
                    canvas.height = viewport.height;

                    // Center the canvas
                    canvas.style.cssText = 'display: block; margin: 10px auto;';
                    wrapper.appendChild(canvas);

                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport,
                    };

                    await page.render(renderContext).promise;
                }
            } catch (error) {
                console.error('Error loading PDF:', error);
                container.innerHTML = '<p class="text-red-500 p-4">Error loading PDF</p>';
            }
        },
    };
}

export { codeEditor, pdfViewer }
