/**
 * Identifies internal links and preps them for wire:navigate.
 */
(() => {
    let navigating = false;

    function configureNavElements() {
        const hyperlinks = Array.from(document.querySelectorAll('a[href]'));

        hyperlinks.forEach((link) => {
            if (link.dataset.livewireNavBound === 'true') return;

            const href = link.getAttribute('href');
            if (
                link.target === '_blank' ||
                href.startsWith('#') ||
                href.startsWith('mailto:')
            ) return;

            let linkUrl;
            try {
                linkUrl = new URL(href, window.location.origin);
                if (linkUrl.origin !== window.location.origin) return;
                if (linkUrl.pathname.startsWith('/wp-admin')) return;
            } catch (e) {
                return;
            }

            link.dataset.livewireNavBound = 'true';

            link.addEventListener('click', (e) => {
                e.preventDefault();
                if (navigating) return;

                navigating = true;

                Livewire.navigate(linkUrl.pathname + linkUrl.search + linkUrl.hash);
            });
        });
    }

    document.addEventListener('livewire:navigated', () => {
        navigating = false;
        configureNavElements();
    });

    document.addEventListener('DOMContentLoaded', () => {
        configureNavElements();
    });
})();
