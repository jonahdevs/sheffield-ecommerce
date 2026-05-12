import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Placeholder from '@tiptap/extension-placeholder'
import TextAlign from '@tiptap/extension-text-align'
import Underline from '@tiptap/extension-underline'

export default (wireProperty, placeholder = 'Start writing...', initialContent = '') => ({
    editor: null,

    init() {
        this.editor = new Editor({
            element: this.$refs.editor,
            extensions: [
                StarterKit,
                Placeholder.configure({ placeholder }),
                TextAlign.configure({ types: ['heading', 'paragraph'] }),
                Underline,
            ],
            content: initialContent || '',
            editorProps: {
                attributes: {
                    // Remove prose class to inherit body font styles
                    // Use minimal styling that doesn't override font-family
                    class: 'min-h-48 p-4 focus:outline-none [&_h1]:text-2xl [&_h1]:font-bold [&_h1]:mb-4 [&_h2]:text-xl [&_h2]:font-bold [&_h2]:mb-3 [&_h3]:text-lg [&_h3]:font-semibold [&_h3]:mb-2 [&_p]:mb-2 [&_ul]:list-disc [&_ul]:ml-6 [&_ul]:mb-2 [&_ol]:list-decimal [&_ol]:ml-6 [&_ol]:mb-2 [&_li]:mb-1 [&_blockquote]:border-l-4 [&_blockquote]:border-zinc-300 [&_blockquote]:pl-4 [&_blockquote]:italic [&_blockquote]:text-zinc-600 dark:[&_blockquote]:border-zinc-600 dark:[&_blockquote]:text-zinc-400',
                },
            },
            onUpdate: ({ editor }) => {
                this.$wire.set(wireProperty, editor.getHTML())
            },
        })

        // Keep the editor in sync if the Livewire property changes from outside
        this.$wire.$watch(wireProperty, (value) => {
            if (value !== this.editor.getHTML()) {
                this.editor.commands.setContent(value || '', false)
            }
        })
    },

    destroy() {
        this.editor?.destroy()
    },

    // Toolbar actions - use mousedown to prevent focus loss
    toggleBold() { this.editor.chain().focus().toggleBold().run() },
    toggleItalic() { this.editor.chain().focus().toggleItalic().run() },
    toggleUnderline() { this.editor.chain().focus().toggleUnderline().run() },
    toggleHeading(level) { this.editor.chain().focus().toggleHeading({ level }).run() },
    toggleBulletList() { this.editor.chain().focus().toggleBulletList().run() },
    toggleOrderedList() { this.editor.chain().focus().toggleOrderedList().run() },
    toggleBlockquote() { this.editor.chain().focus().toggleBlockquote().run() },
    alignLeft() { this.editor.chain().focus().setTextAlign('left').run() },
    alignCenter() { this.editor.chain().focus().setTextAlign('center').run() },
    alignRight() { this.editor.chain().focus().setTextAlign('right').run() },
    undo() { this.editor.chain().focus().undo().run() },
    redo() { this.editor.chain().focus().redo().run() },

    isActive(type, opts = {}) {
        return this.editor?.isActive(type, opts) ?? false
    },
})
