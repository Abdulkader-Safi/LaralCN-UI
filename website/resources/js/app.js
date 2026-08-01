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
// the block's desktop layout still fits the narrower content column. Blocks
// vary wildly in height (a navbar is 64px, an app shell is a full screen), so
// the frame is measured from its own content rather than given a fixed height.
const fitPreview = (box) => {
    const width = Number(box.dataset.previewWidth || 1280);
    const min = Number(box.dataset.previewMinHeight || 200);
    const max = Number(box.dataset.previewMaxHeight || 800);
    const frame = box.querySelector('iframe');
    const scale = box.clientWidth ? Math.min(1, box.clientWidth / width) : 1;

    let height = max;
    try {
        const body = frame.contentDocument && frame.contentDocument.body;
        // A sticky navbar leaves an empty body scrollHeight, so take the
        // furthest bottom edge of the block's own top-level children.
        if (body) {
            const content = [...body.children].reduce(
                (bottom, el) => Math.max(bottom, el.getBoundingClientRect().bottom),
                0,
            );
            if (content) height = Math.min(max, Math.max(min, Math.ceil(content) + 48));
        }
    } catch {
        // Cross-origin frame: fall back to the max height.
    }

    frame.style.width = `${width}px`;
    frame.style.height = `${height}px`;
    frame.style.transform = `scale(${scale})`;
    frame.style.transformOrigin = 'top left';
    box.style.height = `${height * scale}px`;
};

const fitPreviews = () => document.querySelectorAll('[data-preview]').forEach(fitPreview);

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-preview] iframe').forEach((frame) => {
        frame.addEventListener('load', () => fitPreview(frame.closest('[data-preview]')));
    });
    fitPreviews();
});
window.addEventListener('resize', fitPreviews);
