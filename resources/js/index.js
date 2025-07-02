import { basicSetup, EditorView } from 'codemirror'
import { EditorState } from '@codemirror/state'
import { defaultKeymap } from '@codemirror/commands'
import { keymap } from '@codemirror/view'
import 'pdfjs-dist/build/pdf.worker.mjs'
import * as pdfjsLib from 'pdfjs-dist'

function codeEditor({ content, autocompileDelay, autocompile }) {
    return {
        timer: null,

        init() {
            const editor = new EditorView({
                state: EditorState.create({
                    doc: content,
                    extensions: [
                        basicSetup,
                        keymap.of(defaultKeymap),
                        EditorView.lineWrapping,
                        EditorView.updateListener.of((update) => {
                            if (update.docChanged) {
                                const newContent = update.state.doc.toString()
                                this.$dispatch('input', newContent)

                                // Handle autorecompilation
                                if (autocompile) {
                                    // Clear previous timer if it exists
                                    if (this.timer) {
                                        clearTimeout(this.timer)
                                    }

                                    // Set a new timer
                                    this.timer = setTimeout(() => {
                                        // Call Livewire method to compile the document
                                        Livewire.find(this.$wire.id).call('compileDocument')
                                    }, autocompileDelay)
                                }
                            }
                        }),
                    ],
                }),
                parent: this.$el,
            })
        },
    }
}

function pdfViewer({ content, pagination }) {
    return {
        baseUrl: content,
        pageNumber: 1,
        totalPages: 0,
        pageRendering: false,
        parent: this.$el,

        async init() {
            if (pagination) {
                // Create zoom controls
                const controls = document.createElement('div')
                controls.className =
                    'flex gap-2 p-2 justify-start sticky top-0 bg-white dark:bg-gray-800 z-10 border-b dark:border-gray-700 border-gray-200'
                controls.innerHTML = `
                    <button class="px-3 py-1 rounded bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600" @click="onPrevPage()">Previous</button>
                    <button class="px-3 py-1 rounded bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600" @click="onNextPage()">Next</button>
                    <span class="px-3 py-1">Page: <span id="page_num"></span> / <span id="page_count"></span></span>
                `
                this.parent.appendChild(controls)

                // Create a container for the PDF content
                const pageContainer = document.createElement('div')
                pageContainer.id = 'pdf-content'
                this.parent.appendChild(pageContainer)

                await this.renderPage()
            } else {
                await this.render()
                // Listen for livewire event to refresh the PDF
                Livewire.on('document-compiled', async () => {
                    this.parent.innerHTML = ''
                    const refreshedUrl = this.baseUrl + '?t=' + new Date().getTime()
                    await this.render(refreshedUrl)
                })
            }
        },

        calculateOptimalScale(page, containerWidth, containerHeight) {
            const viewport = page.getViewport({ scale: 1.0 })
            const containerAspectRatio = containerWidth / containerHeight
            const pageAspectRatio = viewport.width / viewport.height

            let scale
            if (containerAspectRatio > pageAspectRatio) {
                scale = (containerHeight * 0.98) / viewport.height
            } else {
                scale = (containerWidth * 0.98) / viewport.width
            }

            return scale
        },

        setupContainer(container) {
            container.style.cssText = 'width: 100%; overflow: auto; position: relative;'
        },

        async renderPageContent(page, container) {
            const containerWidth = container.clientWidth
            const containerHeight = container.clientHeight
            const scale = this.calculateOptimalScale(page, containerWidth, containerHeight)
            const viewport = page.getViewport({ scale })

            // Prepare canvas using PDF page dimensions
            const canvas = document.createElement('canvas')
            const context = canvas.getContext('2d')
            canvas.width = viewport.width
            canvas.height = viewport.height
            canvas.style.cssText = 'display: block; margin: 10px auto;'

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

            return pageDiv
        },

        async renderPage() {
            const pageContainer = this.parent.querySelector('#pdf-content')
            pageContainer.innerHTML = ''

            this.setupContainer(this.parent)
            this.pageRendering = true

            const loadingTask = pdfjsLib.getDocument(this.baseUrl)
            loadingTask.promise
                .then(async (pdf) => {
                    this.totalPages = pdf.numPages
                    document.getElementById('page_count').textContent = this.totalPages
                    document.getElementById('page_num').textContent = this.pageNumber

                    // Render page
                    pdf.getPage(this.pageNumber).then(async (page) => {
                        const pageDiv = await this.renderPageContent(page, this.parent)
                        pageContainer.appendChild(pageDiv)
                        this.pageRendering = false
                    })
                })
                .catch(function (error) {
                    console.error('Error loading PDF:', error)
                    pageContainer.innerHTML = `
                    <div class="p-4">
                        <p class="text-red-500">Error loading PDF:</p>
                        <p class="text-sm mt-2">${error.message}</p>
                    </div>
                `
                })
        },

        async render() {
            this.setupContainer(this.parent)
            const loadingTask = pdfjsLib.getDocument(this.baseUrl)
            loadingTask.promise
                .then(async (pdf) => {
                    // Render all pages
                    for (this.pageNumber = 1; this.pageNumber <= pdf.numPages; this.pageNumber++) {
                        const page = await pdf.getPage(this.pageNumber)
                        const pageDiv = await this.renderPageContent(page, this.parent)
                        this.parent.appendChild(pageDiv)
                    }
                })
                .catch((error) => {
                    console.error('Error loading PDF:', error)
                    this.parent.innerHTML = `
                    <div class="p-4">
                        <p class="text-red-500">Error loading PDF:</p>
                        <p class="text-sm mt-2">${error.message}</p>
                    </div>
                `
                })
        },

        onPrevPage() {
            if (this.pageNumber <= 1) {
                return
            }
            this.pageNumber--
            this.renderPage()
        },

        onNextPage() {
            if (this.pageNumber >= this.totalPages) {
                return
            }
            this.pageNumber++
            this.renderPage()
        },
    }
}

export { codeEditor, pdfViewer }
