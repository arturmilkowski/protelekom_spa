<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'

const props = defineProps({
  id: { type: String },
  placeholder: { type: String },
  modelValue: { type: String }
})
const emit = defineEmits(['update:modelValue'])

const editor = useEditor({
  editorProps: {
    attributes: {
      class:
        'prose prose-sm sm:prose lg:prose-lg xl:prose-2xl mx-auto focus:outline-none border-[1px] border-gray-400 p-1 outline-none'
    } // min-h-6 max-h-6 overflow-y-auto
  },
  content: props.modelValue,
  onUpdate: ({ editor }) => {
    // console.log(editor.getHTML())
    emit('update:modelValue', editor.getHTML())
  },
  extensions: [StarterKit]
})
</script>

<template>
  <div>
    <section
      v-if="editor"
      class="buttons flex items-center flex-wrap gap-x-4 border border-gray-400 p-1 text-sm"
    >
      <button
        type="button"
        @click="editor.chain().focus().toggleBold().run()"
        :disabled="!editor.can().chain().focus().toggleBold().run()"
        :class="{ 'bg-gray-200': editor.isActive('bold') }"
        class="p-1 rounded"
      >
        bold
      </button>
      <button
        type="button"
        @click="editor.chain().focus().toggleItalic().run()"
        :disabled="!editor.can().chain().focus().toggleItalic().run()"
        :class="{ 'bg-gray-200': editor.isActive('italic') }"
        class="p-1 rounded"
      >
        italic
      </button>

      <button
        type="button"
        @click="editor.chain().focus().setParagraph().run()"
        :class="{ 'bg-gray-200': editor.isActive('paragraph') }"
        class="p-1 rounded"
      >
        paragraph
      </button>
      <button
        type="button"
        @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
        :class="{ 'bg-gray-200': editor.isActive('heading', { level: 1 }) }"
        class="p-1 rounded"
      >
        h1
      </button>
    </section>
    <EditorContent :editor="editor" />
  </div>
</template>
