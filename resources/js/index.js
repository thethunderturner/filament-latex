import { basicSetup, EditorView } from 'codemirror'
import { EditorState } from '@codemirror/state'
import { defaultKeymap } from '@codemirror/commands'
import { keymap } from '@codemirror/view'
import 'pdfjs-dist/build/pdf.worker.mjs'
import * as pdfjsLib from 'pdfjs-dist'

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
        baseUrl: content,
        pageNumber: 1,

        async init() {
            await this.render()

            // Listen for livewire event to refresh the PDF
            Livewire.on('document-compiled', async () => {
                this.$el.innerHTML = ''

                // Add timestamp to force refresh
                const refreshedUrl = this.baseUrl + '?t=' + new Date().getTime()
                await this.render(refreshedUrl)
            })
        },

        // Function to calculate optimal scale
        calculateOptimalScale(
            page,
            containerWidth,
            containerHeight,
        ) {
            const viewport = page.getViewport({ scale: 1.0 })
            const containerAspectRatio = containerWidth / containerHeight
            const pageAspectRatio = viewport.width / viewport.height

            let scale
            if (containerAspectRatio > pageAspectRatio) {
                scale = (containerHeight * 0.95) / viewport.height
            } else {
                scale = (containerWidth * 0.95) / viewport.width
            }

            return scale
        },

        // Asynchronous download of PDF
        async render() {
            const container = this.$el
            container.style.cssText = 'width: 100%; overflow: auto; position: relative;';

            const loadingTask = pdfjsLib.getDocument(this.baseUrl)
            loadingTask.promise.then(async (pdf) => {
                const containerWidth = container.clientWidth
                const containerHeight = container.clientHeight

                // Render all pages
                for (this.pageNumber; this.pageNumber <= pdf.numPages; this.pageNumber++) {
                    // Render the page as an image
                    const page = await pdf.getPage(this.pageNumber)
                    const scale = this.calculateOptimalScale(
                        page,
                        containerWidth,
                        containerHeight,
                    )
                    const viewport = page.getViewport({ scale })

                    // Prepare canvas using PDF page dimensions
                    const canvas = document.createElement('canvas')
                    const context = canvas.getContext('2d')

                    canvas.width = viewport.width
                    canvas.height = viewport.height

                    // Canvas styling (adding 15px offset because for some reason the text is too to the left)
                    canvas.style.cssText = 'display: block; margin: 10px auto; margin-left: 15px;'

                    // Render PDF page into canvas context
                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport,
                    }
                    await page.render(renderContext).promise

                    // Render text layer
                    const textContent = await page.getTextContent()
                    const textLayerDiv = document.createElement('div')
                    textLayerDiv.className = 'textLayer'
                    const textLayer = new pdfjsLib.TextLayer({
                        textContentSource: textContent,
                        container: textLayerDiv,
                        viewport: viewport,
                    })
                    await textLayer.render()

                    const pageDiv = document.createElement('div')
                    pageDiv.className = 'page'
                    pageDiv.style.cssText = 'position: relative;'
                    pageDiv.appendChild(canvas)
                    pageDiv.appendChild(textLayerDiv)
                    container.appendChild(pageDiv)
                }
            }).catch(function(error) {
                console.error('Error loading PDF:', error)
                container.innerHTML = `
                    <div class="p-4">
                        <p class="text-red-500">Error loading PDF:</p>
                        <p class="text-sm mt-2">${error.message}</p>
                    </div>
                `
            })
        },
    }
}

export { codeEditor, pdfViewer }
