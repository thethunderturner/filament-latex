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

        // Asynchronous download of PDF
        async render(pdfUrl = null) {
            const container = this.$el

            // Function to calculate optimal scale
            const calculateOptimalScale = (
                page,
                containerWidth,
                containerHeight,
            ) => {
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
            }

            // Create a wrapper div for proper scrolling
            const wrapper = document.createElement('div')
            wrapper.style.cssText =
                'width: 100%; height: 100%; overflow: auto; position: relative;'
            container.appendChild(wrapper)

            try {
                const urlToLoad = pdfUrl || this.baseUrl
                const loadingTask = pdfjsLib.getDocument(urlToLoad)
                const pdf = await loadingTask.promise
                console.log('PDF loaded:', urlToLoad)

                const containerWidth = wrapper.clientWidth
                const containerHeight = wrapper.clientHeight

                // Render all pages
                for (let i = 1; i <= pdf.numPages; i++) {
                    const page = await pdf.getPage(i)
                    const scale = calculateOptimalScale(
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

                    // Canvas styling
                    canvas.style.cssText = 'display: block; margin: 10px auto;'

                    // Render PDF page into canvas context
                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport,
                    }

                    await page.render(renderContext).promise

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
                    wrapper.appendChild(pageDiv)
                }
            } catch (error) {
                console.error('Error loading PDF:', error)
                wrapper.innerHTML = `
                    <div class="p-4">
                        <p class="text-red-500">Error loading PDF:</p>
                        <p class="text-sm mt-2">${error.message}</p>
                    </div>
                `
            }
        },
    }
}

export { codeEditor, pdfViewer }
