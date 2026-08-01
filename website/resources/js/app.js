import hljs from 'highlight.js/lib/core';
import xml from 'highlight.js/lib/languages/xml';
import php from 'highlight.js/lib/languages/php';
import css from 'highlight.js/lib/languages/css';
import bash from 'highlight.js/lib/languages/bash';
import 'highlight.js/styles/github-dark.css';

hljs.registerLanguage('xml', xml);
hljs.registerLanguage('php', php);
hljs.registerLanguage('css', css);
hljs.registerLanguage('bash', bash);

const highlightAll = () => {
    document.querySelectorAll('pre code:not([data-highlighted])').forEach((el) => {
        hljs.highlightElement(el);
    });
};

document.addEventListener('DOMContentLoaded', highlightAll);

// Everything below is the docs site's own chrome. The registry components carry
// their own inline scripts, so none of this is needed for them to work.

// Copy buttons: [data-copy] holds the text; the label swaps via data-copied.
document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-copy]');
    if (!button) return;

    navigator.clipboard.writeText(button.dataset.copy);
    button.dataset.copied = 'true';
    setTimeout(() => delete button.dataset.copied, 1500);
});

// Tab strips: [data-tabs] wraps [data-tab="key"] buttons and [data-panel="key"].
document.addEventListener('click', (event) => {
    const tab = event.target.closest('[data-tab]');
    if (!tab) return;

    const root = tab.closest('[data-tabs]');
    root.querySelectorAll('[data-tab]').forEach((el) => {
        el.setAttribute('aria-selected', String(el === tab));
    });
    root.querySelectorAll('[data-panel]').forEach((panel) => {
        panel.classList.toggle('hidden', panel.dataset.panel !== tab.dataset.tab);
    });
});

// Dark-mode switch in the header.
document.addEventListener('click', (event) => {
    if (!event.target.closest('[data-theme-toggle]')) return;
    document.documentElement.classList.toggle('dark');
});

// Block previews render an iframe at a desktop viewport, then scale it down so
// the block's desktop layout still fits the narrower content column.
const fitPreviews = () => {
    document.querySelectorAll('[data-preview]').forEach((box) => {
        const width = Number(box.dataset.previewWidth || 1280);
        const height = Number(box.dataset.previewHeight || 720);
        const scale = box.clientWidth ? Math.min(1, box.clientWidth / width) : 1;
        const frame = box.querySelector('iframe');

        box.style.height = `${height * scale}px`;
        frame.style.width = `${width}px`;
        frame.style.height = `${height}px`;
        frame.style.transform = `scale(${scale})`;
        frame.style.transformOrigin = 'top left';
    });
};

document.addEventListener('DOMContentLoaded', fitPreviews);
window.addEventListener('resize', fitPreviews);
