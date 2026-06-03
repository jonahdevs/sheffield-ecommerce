import Quill from 'quill'
import 'quill/dist/quill.snow.css'

const style = document.createElement('style')
style.textContent = `
    /* ── Toolbar shell ── */
    .ql-toolbar.ql-snow {
        border: none;
        border-bottom: 1px solid #d4d4d8;
        background: #fafafa;
        padding: 6px 10px;
        font-family: inherit;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 2px;
        line-height: 1;
    }
    .ql-snow.ql-toolbar .ql-formats {
        display: inline-flex;
        align-items: center;
        gap: 1px;
        margin-right: 0;
    }
    .ql-snow.ql-toolbar .ql-formats + .ql-formats {
        margin-left: 4px;
        padding-left: 6px;
        border-left: 1px solid #d4d4d8;
    }

    /* ── Buttons ── */
    .ql-snow.ql-toolbar button {
        width: 30px; height: 30px; padding: 5px;
        border-radius: 5px;
        display: inline-flex; align-items: center; justify-content: center;
        transition: background 0.1s;
    }
    .ql-snow .ql-stroke { stroke: #71717a; stroke-width: 1.5; }
    .ql-snow .ql-fill   { fill: #71717a; }
    .ql-snow .ql-thin   { stroke-width: 1; }
    .ql-snow.ql-toolbar button:hover                  { background: #f4f4f5; }
    .ql-snow.ql-toolbar button:hover .ql-stroke       { stroke: #18181b; }
    .ql-snow.ql-toolbar button:hover .ql-fill         { fill: #18181b; }
    .ql-snow.ql-toolbar button.ql-active              { background: #e4e4e7; }
    .ql-snow.ql-toolbar button.ql-active .ql-stroke   { stroke: #18181b; }
    .ql-snow.ql-toolbar button.ql-active .ql-fill     { fill: #18181b; }

    /* ── Pickers (align, size, etc.) ── */
    .ql-snow .ql-picker       { color: #71717a; font-size: 0.75rem; font-family: inherit; height: 30px; }
    .ql-snow .ql-picker-label { padding: 4px 6px; border-radius: 5px; border: none; display: flex; align-items: center; }
    .ql-snow .ql-picker-label .ql-stroke { stroke: #71717a; }
    .ql-snow .ql-picker-label:hover    { background: #f4f4f5; color: #18181b; }
    .ql-snow .ql-picker-label.ql-active { background: #e4e4e7; color: #18181b; }
    .ql-snow .ql-picker-options { border: 1px solid #e4e4e7; border-radius: 6px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); padding: 4px; background: #fff; z-index: 50; }
    .ql-snow .ql-picker-item:hover    { background: #f4f4f5; border-radius: 4px; }
    .ql-snow .ql-picker-item.ql-selected { color: #18181b; background: #e4e4e7; border-radius: 4px; }

    /* Size picker width */
    .ql-snow .ql-size { width: 80px; }
    .ql-snow .ql-size .ql-picker-label::before { content: attr(data-value); }
    .ql-snow .ql-size .ql-picker-label[data-value=""]::before,
    .ql-snow .ql-size .ql-picker-label:not([data-value])::before { content: 'Normal'; }

    /* H2 / H3 text buttons */
    .ql-snow.ql-toolbar .ql-header-2,
    .ql-snow.ql-toolbar .ql-header-3 { width: auto; padding: 5px 7px; font-size: 0.7rem; font-weight: 700; color: #71717a; letter-spacing: 0.01em; }
    .ql-snow.ql-toolbar .ql-header-2:hover, .ql-snow.ql-toolbar .ql-header-3:hover  { background: #f4f4f5; color: #18181b; }
    .ql-snow.ql-toolbar .ql-header-2.ql-active, .ql-snow.ql-toolbar .ql-header-3.ql-active { background: #e4e4e7; color: #18181b; }

    /* Color pickers */
    .ql-snow .ql-color-picker .ql-picker-label { padding: 5px; }
    .ql-snow .ql-color-picker .ql-picker-label svg { width: 18px; height: 18px; }
    .ql-snow .ql-color-picker .ql-picker-options { width: 192px; padding: 6px; }
    .ql-snow .ql-color-picker .ql-picker-item { width: 20px; height: 20px; border-radius: 3px; margin: 1px; border: 1px solid transparent; }
    .ql-snow .ql-color-picker .ql-picker-item:hover { border-color: #71717a; }
    .ql-snow .ql-color-picker .ql-picker-item.ql-selected { border-color: #18181b; }

    /* Custom table button */
    .ql-table-insert::after { content: '⊞'; font-size: 1rem; line-height: 1; color: #71717a; }
    .ql-table-insert:hover::after { color: #18181b; }

    /* ── Editor area ── */
    .ql-container.ql-snow { border: none; font-family: inherit; font-size: 0.875rem; }
    .ql-editor { padding: 0.875rem 1rem; min-height: inherit; line-height: 1.6; }
    .ql-editor.ql-blank::before { color: #a1a1aa; font-style: normal; left: 1rem; }
    .ql-editor h2 { font-size: 1.125rem; font-weight: 600; margin: 0.75rem 0 0.25rem; }
    .ql-editor h3 { font-size: 1rem;    font-weight: 600; margin: 0.5rem 0 0.25rem; }
    .ql-editor ul, .ql-editor ol { padding-left: 1.5rem; }
    .ql-editor blockquote { border-left: 3px solid #d4d4d8; padding-left: 0.75rem; color: #71717a; margin: 0.5rem 0; }
    .ql-editor pre { background: #f4f4f5; border-radius: 6px; padding: 0.75rem 1rem; font-size: 0.8rem; }
    .ql-editor table { width: 100%; border-collapse: collapse; margin: 0.75rem 0; font-size: 0.875rem; }
    .ql-editor table td { border: 1px solid #d4d4d8; padding: 0.4rem 0.65rem; vertical-align: top; }
    .ql-editor img { max-width: 100%; height: auto; border-radius: 4px; }

    /* ── Dark mode ── */
    .dark .ql-toolbar.ql-snow { border-bottom-color: #3f3f46; background: #27272a; }
    .dark .ql-snow.ql-toolbar .ql-formats + .ql-formats { border-left-color: #3f3f46; }
    .dark .ql-snow .ql-stroke { stroke: #a1a1aa; }
    .dark .ql-snow .ql-fill   { fill: #a1a1aa; }
    .dark .ql-snow .ql-picker { color: #a1a1aa; }
    .dark .ql-snow .ql-picker-label:hover,
    .dark .ql-snow.ql-toolbar button:hover  { background: #3f3f46; }
    .dark .ql-snow.ql-toolbar button:hover .ql-stroke,
    .dark .ql-snow.ql-toolbar button.ql-active .ql-stroke { stroke: #fff; }
    .dark .ql-snow.ql-toolbar button:hover .ql-fill,
    .dark .ql-snow.ql-toolbar button.ql-active .ql-fill   { fill: #fff; }
    .dark .ql-snow.ql-toolbar button.ql-active,
    .dark .ql-snow .ql-picker-label.ql-active { background: #3f3f46; }
    .dark .ql-snow .ql-picker-options { background: #27272a; border-color: #3f3f46; }
    .dark .ql-snow .ql-picker-item:hover    { background: #3f3f46; }
    .dark .ql-snow .ql-picker-item.ql-selected { background: #52525b; color: #fff; }
    .dark .ql-snow.ql-toolbar .ql-header-2, .dark .ql-snow.ql-toolbar .ql-header-3 { color: #a1a1aa; }
    .dark .ql-snow.ql-toolbar .ql-header-2:hover, .dark .ql-snow.ql-toolbar .ql-header-3:hover,
    .dark .ql-snow.ql-toolbar .ql-header-2.ql-active, .dark .ql-snow.ql-toolbar .ql-header-3.ql-active { background: #3f3f46; color: #fff; }
    .dark .ql-editor { color: #fff; }
    .dark .ql-editor.ql-blank::before { color: #52525b; }
    .dark .ql-editor blockquote { border-left-color: #52525b; color: #a1a1aa; }
    .dark .ql-editor pre { background: #18181b; }
    .dark .ql-editor table td { border-color: #3f3f46; }
    .dark .ql-table-insert::after { color: #a1a1aa; }
    .dark .ql-table-insert:hover::after { color: #fff; }
`
document.head.appendChild(style)

window.richTextEditor = function (wireModel, placeholder = '', withTable = false) {
    let quill = null

    return {
        content: '',

        setup(editorEl) {
            this.content = this.$wire.get(wireModel) || ''

            // Register custom table-insert handler
            const tableGroup = withTable ? [['table-insert']] : []

            quill = new Quill(editorEl, {
                theme: 'snow',
                placeholder,
                modules: {
                    toolbar: {
                        container: [
                            // Text style
                            ['bold', 'italic', 'underline', 'strike'],
                            // Headings
                            [{ header: 2 }, { header: 3 }],
                            // Font size
                            [{ size: ['small', false, 'large', 'huge'] }],
                            // Lists & indent
                            [{ list: 'bullet' }, { list: 'ordered' }, { list: 'check' }],
                            [{ indent: '-1' }, { indent: '+1' }],
                            // Alignment
                            [{ align: [] }],
                            // Sub / super
                            [{ script: 'sub' }, { script: 'super' }],
                            // Block elements
                            ['blockquote', 'code-block'],
                            // Colour
                            [{ color: [] }, { background: [] }],
                            // Media
                            ['link', 'image', 'video'],
                            // Table (description + spec editors)
                            ...tableGroup,
                            // Clean
                            ['clean'],
                        ],
                        handlers: {
                            'table-insert': function () {
                                const rows = parseInt(window.prompt('Rows:', '3'), 10) || 3
                                const cols = parseInt(window.prompt('Columns:', '2'), 10) || 2
                                const q = this.quill
                                const range = q.getSelection(true)
                                let html = '<table>'
                                for (let r = 0; r < rows; r++) {
                                    html += '<tr>'
                                    for (let c = 0; c < cols; c++) {
                                        html += r === 0
                                            ? `<td><strong>Header ${c + 1}</strong></td>`
                                            : '<td>&nbsp;</td>'
                                    }
                                    html += '</tr>'
                                }
                                html += '</table><p></p>'
                                q.clipboard.dangerouslyPasteHTML(range.index, html)
                            },
                        },
                    },
                },
            })

            // Label H2 / H3 with plain text instead of Quill's SVG
            const toolbar = quill.getModule('toolbar')
            const h2Btn = toolbar.container.querySelector('.ql-header[value="2"]')
            const h3Btn = toolbar.container.querySelector('.ql-header[value="3"]')
            if (h2Btn) { h2Btn.innerHTML = 'H2'; h2Btn.classList.add('ql-header-2') }
            if (h3Btn) { h3Btn.innerHTML = 'H3'; h3Btn.classList.add('ql-header-3') }

            if (this.content) {
                quill.clipboard.dangerouslyPasteHTML(this.content)
            }

            const getHTML = () => quill.getSemanticHTML()

            quill.on('text-change', () => {
                this.content = getHTML()
            })

            quill.on('selection-change', (range) => {
                if (range === null) {
                    this.$wire.set(wireModel, getHTML(), false)
                }
            })

            const form = editorEl.closest('form')
            if (form) {
                form.addEventListener('submit', () => {
                    this.$wire.set(wireModel, getHTML(), false)
                }, { capture: true })
            }

            this.$wire.on(`${wireModel}Updated`, (value) => {
                if (value !== getHTML()) {
                    quill.clipboard.dangerouslyPasteHTML(value || '')
                }
            })
        },
    }
}
