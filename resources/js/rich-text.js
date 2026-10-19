import Quill from 'quill';
import 'quill/dist/quill.snow.css';

const presets = {
    full: {
        toolbar: [[{ header: [2, 3, false] }], ['bold', 'italic', 'underline'], ['link', 'blockquote'], [{ list: 'ordered' }, { list: 'bullet' }], ['clean']],
        formats: ['header', 'bold', 'italic', 'underline', 'link', 'blockquote', 'list'],
    },
    basic: {
        toolbar: [['bold', 'italic', 'underline'], ['link'], ['clean']],
        formats: ['bold', 'italic', 'underline', 'link'],
    },
    minimal: {
        toolbar: [['bold', 'italic', 'underline'], ['clean']],
        formats: ['bold', 'italic', 'underline'],
    },
    none: {
        toolbar: false,
        formats: [],
    },
};

/**
 * Swap a textarea for a Quill editor, keeping the textarea's value in sync so the form submits HTML.
 */
export default function mountRichTextEditor(textarea) {
    const preset = presets[textarea.dataset.richText] ?? presets.basic;
    const wrapper = document.createElement('div');
    const editor = document.createElement('div');

    wrapper.className = 'rich-text-editor';
    wrapper.classList.toggle('is-invalid', textarea.getAttribute('aria-invalid') === 'true');
    editor.style.minHeight = `${Number(textarea.rows || 4) * 1.75}rem`;
    wrapper.append(editor);
    textarea.after(wrapper);
    textarea.hidden = true;
    textarea.required = false;

    const quill = new Quill(editor, {
        theme: 'snow',
        modules: { toolbar: preset.toolbar },
        formats: preset.formats,
    });

    quill.setContents(quill.clipboard.convert({ html: textarea.value }), 'silent');

    quill.root.setAttribute('role', 'textbox');
    quill.root.setAttribute('aria-multiline', 'true');
    quill.root.setAttribute('aria-labelledby', `${textarea.id}-label`);

    document.querySelector(`label[for="${textarea.id}"]`)?.addEventListener('click', () => quill.focus());

    quill.on('text-change', () => {
        textarea.value = quill.getText().trim() === ''
            ? ''
            : quill.getSemanticHTML().replaceAll('&nbsp;', ' ');
    });
}
