
function configureNavElements() {
    const hyperlinks = Array.from(document.querySelectorAll('a[href]'));

    hyperlinks.forEach((link) => {
        const href = link.getAttribute('href');
        if (
            link.target === '_blank' ||
            href.startsWith('#') ||
            href.startsWith('mailto:')
        ) return;

        try {
            const linkUrl = new URL(href, window.location.origin);
            if (linkUrl.origin !== window.location.origin) return;
        } catch (e) {
            return;
        }

        // Add navigation handler
        link.addEventListener('click', (e) => {
            e.preventDefault();
            Livewire.navigate(href);
        });
    });
};

document.addEventListener('livewire:navigated', configureNavElements);
document.addEventListener('DOMContentLoaded', configureNavElements);