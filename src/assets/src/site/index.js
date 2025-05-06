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
                } catch (err) {}

                savedScrollY = window.scrollY;
                pendingHash  = linkUrl.hash || null;
                navigating   = true;

                // Lock scroll to prevent jump-to-top flicker
                document.documentElement.style.scrollBehavior = 'auto';
                window.scrollTo({ top: savedScrollY });

                Livewire.navigate(linkUrl.pathname + linkUrl.search);
            });
        });
    }

    document.addEventListener('livewire:navigated', () => {
        navigating = false;
        configureNavElements();

        setTimeout(() => {
            document.documentElement.style.scrollBehavior = ''; // Reset scroll behavior

            if (pendingHash) {
                const el = document.querySelector(pendingHash);
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth' });
                }
                pendingHash = null;
            } else {
                const scrollY = history.state?.scrollY ?? savedScrollY ?? 0;
                window.scrollTo({ top: scrollY, behavior: 'auto' });
            }
        }, 50);
    });

    // Restore scroll on browser back/forward
    window.addEventListener('popstate', () => {
        setTimeout(() => {
            const scrollY = history.state?.scrollY ?? 0;
            window.scrollTo({ top: scrollY, behavior: 'auto' });
        }, 50);
    });

    document.addEventListener('DOMContentLoaded', () => {
        configureNavElements();

        // Store initial scroll position
        try {
            history.replaceState(
                Object.assign({}, history.state, { scrollY: window.scrollY }),
                ''
            );
        } catch (err) {}
    });
})();
