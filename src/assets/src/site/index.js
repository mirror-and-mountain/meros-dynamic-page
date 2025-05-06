(() => {
    let navigating   = false;
    let pendingHash  = null;
    let savedScrollY = 0;

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

                // Save current scroll to history state
                try {
                    history.replaceState(
                        Object.assign({}, history.state, { scrollY: window.scrollY }),
                        ''
                    );
                } catch (err) {
                    // Some browsers restrict this in sandboxed environments
                }

                // Save hash for post-navigation scroll
                pendingHash = linkUrl.hash || null;
                navigating = true;

                Livewire.navigate(linkUrl.pathname + linkUrl.search);
            });
        });
    }

    document.addEventListener('livewire:navigated', () => {
        navigating = false;
        configureNavElements();

        setTimeout(() => {
            if (pendingHash) {
                const el = document.querySelector(pendingHash);
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth' });
                }
                pendingHash = null;
            } else {
                const scrollY = history.state?.scrollY ?? 0;
                window.scrollTo({ top: scrollY, behavior: 'auto' });
            }
        }, 50);
    });

    // Restore scroll position when using browser back/forward buttons
    window.addEventListener('popstate', () => {
        setTimeout(() => {
            const scrollY = history.state?.scrollY ?? 0;
            window.scrollTo({ top: scrollY, behavior: 'auto' });
        }, 50);
    });

    document.addEventListener('DOMContentLoaded', () => {
        configureNavElements();

        // Store initial scroll position in history state
        try {
            history.replaceState(
                Object.assign({}, history.state, { scrollY: window.scrollY }),
                ''
            );
        } catch (err) {}
    });
})();
