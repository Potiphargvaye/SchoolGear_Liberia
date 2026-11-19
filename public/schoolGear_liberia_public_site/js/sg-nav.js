(function () {
    'use strict';

    var nav = document.querySelector('[data-sg-nav]');
    if (!nav) return;

    var body = document.body;
    var searchButtons = nav.querySelectorAll('[data-sg-search-open]');
    var searchModal = document.querySelector('[data-sg-modal]');
    var searchInput = document.querySelector('[data-sg-search-input]');
    var searchClose = document.querySelector('[data-sg-search-close]');
    var results = document.querySelector('[data-sg-results]');
    var endpoint = searchModal ? searchModal.getAttribute('data-sg-search-endpoint') : '';
    var signInWrap = nav.querySelector('[data-sg-signin-wrap]');
    var signInToggle = nav.querySelector('[data-sg-signin-toggle]');
    var signInPanel = nav.querySelector('[data-sg-signin-panel]');
    var menuToggle = nav.querySelector('[data-sg-menu-toggle]');
    var mobilePanel = nav.querySelector('[data-sg-mobile-panel]');
    var debounceTimer = null;
    var requestController = null;
    var activeResult = -1;
    var lastSearchTrigger = null;

    Array.prototype.forEach.call(searchButtons, function (button) {
        button.hidden = false;
        button.addEventListener('click', function () {
            openSearch(button);
        });
    });

    function setBodyLocked(locked) {
        body.style.overflow = locked ? 'hidden' : '';
    }

    function setSignInOpen(open) {
        if (!signInToggle || !signInPanel) return;
        signInPanel.hidden = !open;
        signInToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    if (signInToggle) {
        signInToggle.addEventListener('click', function () {
            setSignInOpen(signInPanel.hidden);
        });
    }

    document.addEventListener('click', function (event) {
        if (signInWrap && !signInWrap.contains(event.target)) {
            setSignInOpen(false);
        }
    });

    nav.addEventListener('focusout', function (event) {
        if (signInWrap && !signInWrap.contains(event.relatedTarget)) {
            setSignInOpen(false);
        }
    });

    function setMenuOpen(open) {
        if (!menuToggle || !mobilePanel) return;
        mobilePanel.hidden = !open;
        menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        menuToggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        if (open) setBodyLocked(true);
        else if (searchModal.hidden) setBodyLocked(false);
    }

    if (menuToggle) {
        menuToggle.addEventListener('click', function () {
            setMenuOpen(mobilePanel.hidden);
        });
    }

    if (mobilePanel) {
        mobilePanel.addEventListener('click', function (event) {
            if (event.target.closest('a')) setMenuOpen(false);
        });
    }

    function setSearchState(state) {
        Array.prototype.forEach.call(searchModal.querySelectorAll('[data-sg-search-state]'), function (item) {
            item.hidden = item.getAttribute('data-sg-search-state') !== state;
        });
    }

    function initials(name) {
        return name.split(/\s+/).filter(Boolean).slice(0, 2).map(function (word) {
            return word.charAt(0).toUpperCase();
        }).join('') || '?';
    }

    function clearResults() {
        while (results.firstChild) results.removeChild(results.firstChild);
        activeResult = -1;
    }

    function renderResults(items) {
        clearResults();
        items.forEach(function (school, index) {
            var link = document.createElement('a');
            link.className = 'sg-nav-result';
            link.href = school.url;
            link.setAttribute('role', 'option');
            link.setAttribute('data-result-index', String(index));

            var fallback = document.createElement('span');
            fallback.className = 'sg-nav-result-initials';
            fallback.textContent = initials(school.name || '');

            if (school.logo) {
                var image = document.createElement('img');
                image.className = 'sg-nav-result-logo';
                image.alt = '';
                image.src = school.logo;
                image.addEventListener('load', function () {
                    fallback.hidden = true;
                });
                image.addEventListener('error', function () {
                    image.remove();
                    fallback.hidden = false;
                });
                link.appendChild(image);
            }
            link.appendChild(fallback);

            var copy = document.createElement('span');
            copy.className = 'sg-nav-result-copy';
            var name = document.createElement('strong');
            name.className = 'sg-nav-result-name';
            name.textContent = school.name || '';
            copy.appendChild(name);
            if (school.location) {
                var location = document.createElement('small');
                location.className = 'sg-nav-result-location';
                location.textContent = school.location;
                copy.appendChild(location);
            }
            link.appendChild(copy);
            results.appendChild(link);
        });
        setSearchState(items.length ? 'results' : 'empty');
    }

    function searchSchools() {
        var query = searchInput.value.trim();
        if (requestController) requestController.abort();
        clearResults();
        if (query.length < 2) {
            setSearchState('idle');
            return;
        }

        setSearchState('loading');
        requestController = new AbortController();
        fetch(endpoint + '?q=' + encodeURIComponent(query), {
            headers: { Accept: 'application/json' },
            signal: requestController.signal
        }).then(function (response) {
            if (!response.ok) throw new Error('Search failed');
            return response.json();
        }).then(function (payload) {
            renderResults(Array.isArray(payload.data) ? payload.data : []);
        }).catch(function (error) {
            if (error.name !== 'AbortError') {
                clearResults();
                setSearchState('error');
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            window.clearTimeout(debounceTimer);
            debounceTimer = window.setTimeout(searchSchools, 250);
        });
    }

    function modalFocusables() {
        return Array.prototype.slice.call(searchModal.querySelectorAll('button:not([hidden]), input:not([hidden]), a[href]:not([hidden])'));
    }

    function openSearch(trigger) {
        if (!searchModal) return;
        lastSearchTrigger = trigger;
        setSignInOpen(false);
        setMenuOpen(false);
        searchModal.hidden = false;
        setBodyLocked(true);
        setSearchState('idle');
        clearResults();
        searchInput.value = '';
        window.setTimeout(function () { searchInput.focus(); }, 0);
    }

    function closeSearch() {
        if (!searchModal || searchModal.hidden) return;
        if (requestController) requestController.abort();
        window.clearTimeout(debounceTimer);
        searchModal.hidden = true;
        setBodyLocked(false);
        if (lastSearchTrigger) lastSearchTrigger.focus();
    }

    if (searchClose) searchClose.addEventListener('click', closeSearch);
    if (searchModal) {
        searchModal.addEventListener('click', function (event) {
            if (event.target === searchModal) closeSearch();
        });
        searchModal.addEventListener('keydown', function (event) {
            var focusable = modalFocusables();
            if (event.key === 'Escape') {
                event.preventDefault();
                closeSearch();
                return;
            }
            if (event.key === 'Tab' && focusable.length) {
                var first = focusable[0];
                var last = focusable[focusable.length - 1];
                if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                } else if (!event.shiftKey && document.activeElement === last) {
                    event.preventDefault();
                    first.focus();
                }
            }
            if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
                var resultLinks = Array.prototype.slice.call(results.querySelectorAll('.sg-nav-result'));
                if (!resultLinks.length) return;
                event.preventDefault();
                activeResult = event.key === 'ArrowDown'
                    ? Math.min(activeResult + 1, resultLinks.length - 1)
                    : Math.max(activeResult - 1, 0);
                resultLinks.forEach(function (link, index) {
                    link.classList.toggle('is-highlighted', index === activeResult);
                });
                resultLinks[activeResult].focus();
            }
            if (event.key === 'Enter' && activeResult >= 0) {
                var highlighted = results.querySelector('[data-result-index="' + activeResult + '"]');
                if (highlighted && document.activeElement !== highlighted) highlighted.click();
            }
        });
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            setSignInOpen(false);
            setMenuOpen(false);
            closeSearch();
        }
    });
}());
