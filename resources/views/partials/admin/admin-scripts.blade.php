<script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        (function () {
            const body = document.body;
            const html = document.documentElement;
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const sidebarOverlay = document.querySelector('.sidebar-overlay');
            const sidebarMenu = document.querySelector('.sidebar-menu');
            const main = document.querySelector('.main');
            const themeToggle = document.getElementById('admin-theme-toggle');
            const themeKey = 'sg-admin-theme';
            const railKey = 'sg-admin-sidebar-collapsed';
            const desktop = window.matchMedia('(min-width: 1025px)');

            function readStorage(key, fallback) {
                try {
                    return window.localStorage.getItem(key) || fallback;
                } catch (error) {
                    return fallback;
                }
            }

            function writeStorage(key, value) {
                try {
                    window.localStorage.setItem(key, value);
                } catch (error) {
                    return false;
                }
                return true;
            }

            function readTheme() {
                try {
                    return window.localStorage.getItem(themeKey) === 'dark' ? 'dark' : 'light';
                } catch (error) {
                    return 'light';
                }
            }

            function applyTheme(theme) {
                const dark = theme === 'dark';
                const normalizedTheme = dark ? 'dark' : 'light';
                body.classList.toggle('sg-theme-dark', dark);
                body.classList.toggle('sg-theme-light', !dark);
                body.dataset.theme = normalizedTheme;
                html.classList.toggle('dark', dark);
                html.dataset.theme = normalizedTheme;

                if (themeToggle) {
                    themeToggle.setAttribute('aria-pressed', dark ? 'true' : 'false');
                    themeToggle.querySelectorAll('[data-theme-icon]').forEach(function (icon) {
                        icon.style.display = icon.getAttribute('data-theme-icon') === (dark ? 'sun' : 'moon')
                            ? ''
                            : 'none';
                    });
                }

                return normalizedTheme;
            }

            function applyRailPreference() {
                body.classList.toggle('admin-sidebar-collapsed', desktop.matches && readStorage(railKey, 'false') === 'true');
            }

            function setDrawerOpen(open) {
                body.classList.toggle('admin-drawer-open', open);
                if (main) {
                    main.classList.toggle('active', open);
                }
                if (sidebarOverlay) {
                    sidebarOverlay.classList.toggle('hidden', !open);
                    sidebarOverlay.setAttribute('aria-hidden', open ? 'false' : 'true');
                }
                if (sidebarToggle) {
                    sidebarToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                }
            }

            applyTheme(readTheme());
            applyRailPreference();

            if (themeToggle) {
                themeToggle.addEventListener('click', function () {
                    const nextTheme = body.classList.contains('sg-theme-dark') ? 'light' : 'dark';
                    if (!writeStorage(themeKey, nextTheme)) {
                        applyTheme('light');
                        console.error('Unable to persist the admin theme preference.');
                        return;
                    }
                    applyTheme(nextTheme);
                    document.dispatchEvent(new CustomEvent('sg-theme-changed', {
                        detail: { theme: nextTheme }
                    }));
                });
            }

            if (sidebarToggle && sidebarMenu) {
                sidebarToggle.setAttribute('aria-expanded', 'false');
                sidebarToggle.addEventListener('click', function (event) {
                    event.preventDefault();
                    if (desktop.matches) {
                        const collapsed = !body.classList.contains('admin-sidebar-collapsed');
                        body.classList.toggle('admin-sidebar-collapsed', collapsed);
                        if (main) {
                            main.classList.toggle('active', collapsed);
                        }
                        writeStorage(railKey, collapsed ? 'true' : 'false');
                    } else {
                        setDrawerOpen(!body.classList.contains('admin-drawer-open'));
                    }
                });
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function (event) {
                    event.preventDefault();
                    setDrawerOpen(false);
                });
            }

            if (sidebarMenu) {
                sidebarMenu.addEventListener('click', function (event) {
                    const link = event.target.closest('a');
                    if (link && !link.classList.contains('sidebar-dropdown-toggle') && !desktop.matches) {
                        setDrawerOpen(false);
                    }
                });
            }

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && body.classList.contains('admin-drawer-open')) {
                    setDrawerOpen(false);
                }
            });

            desktop.addEventListener('change', function () {
                setDrawerOpen(false);
                applyRailPreference();
            });

            window.addEventListener('storage', function (event) {
                if (event.key === themeKey) {
                    const normalizedTheme = applyTheme(event.newValue === 'dark' ? 'dark' : 'light');
                    document.dispatchEvent(new CustomEvent('sg-theme-changed', {
                        detail: { theme: normalizedTheme }
                    }));
                } else if (event.key === railKey) {
                    applyRailPreference();
                }
            });

            document.addEventListener('livewire:navigated', function () {
                applyTheme(readTheme());
                applyRailPreference();
                hideRailTooltip();
            });

            const tooltipTargets = '.sidebar-menu .nav-link, .sidebar-menu .nav-sublink, .sidebar-menu .nav-section, .sidebar-menu .logout-button, .admin-sidebar-profile, .sidebar-menu > a:first-child';
            const railTooltip = document.createElement('div');
            let tooltipOwnerId = 0;
            railTooltip.id = 'admin-rail-tooltip';
            railTooltip.className = 'admin-rail-tooltip';
            railTooltip.setAttribute('role', 'tooltip');
            railTooltip.setAttribute('aria-hidden', 'true');
            body.appendChild(railTooltip);

            function tooltipLabel(item) {
                if (item.dataset.railTooltip) {
                    return item.dataset.railTooltip;
                }

                const label = item.querySelector('.text-sm');
                return (label ? label.textContent : item.textContent).trim().replace(/\s+/g, ' ');
            }

            function hideRailTooltip() {
                if (railTooltip.dataset.owner) {
                    const owner = document.getElementById(railTooltip.dataset.owner);
                    if (owner) {
                        owner.removeAttribute('aria-describedby');
                    }
                }
                railTooltip.style.display = 'none';
                railTooltip.setAttribute('aria-hidden', 'true');
                delete railTooltip.dataset.owner;
            }

            function showRailTooltip(item) {
                if (!desktop.matches || !body.classList.contains('admin-sidebar-collapsed') ||
                    body.classList.contains('admin-drawer-open')) {
                    hideRailTooltip();
                    return;
                }

                const label = tooltipLabel(item);
                if (!label) {
                    hideRailTooltip();
                    return;
                }

                const previousOwner = document.getElementById(railTooltip.dataset.owner || '');
                if (previousOwner && previousOwner !== item) {
                    previousOwner.removeAttribute('aria-describedby');
                }
                railTooltip.textContent = label;
                railTooltip.style.display = 'block';
                railTooltip.setAttribute('aria-hidden', 'false');
                railTooltip.dataset.owner = item.id || '';
                if (!item.id) {
                    item.id = 'admin-rail-tooltip-item-' + (++tooltipOwnerId);
                    railTooltip.dataset.owner = item.id;
                }
                item.setAttribute('aria-describedby', railTooltip.id);

                const rect = item.getBoundingClientRect();
                const tooltipRect = railTooltip.getBoundingClientRect();
                const left = Math.min(rect.right + 10, window.innerWidth - tooltipRect.width - 8);
                const top = Math.max(8, Math.min(rect.top + (rect.height - tooltipRect.height) / 2,
                    window.innerHeight - tooltipRect.height - 8));
                railTooltip.style.left = Math.max(8, left) + 'px';
                railTooltip.style.top = top + 'px';
            }

            const railStateObserver = new MutationObserver(function () {
                if (!desktop.matches || !body.classList.contains('admin-sidebar-collapsed') ||
                    body.classList.contains('admin-drawer-open')) {
                    hideRailTooltip();
                }
            });
            railStateObserver.observe(body, { attributes: true, attributeFilter: ['class'] });

            document.addEventListener('pointerover', function (event) {
                const item = event.target.closest(tooltipTargets);
                if (item) {
                    showRailTooltip(item);
                }
            });

            document.addEventListener('pointerout', function (event) {
                const item = event.target.closest(tooltipTargets);
                if (item && (!event.relatedTarget || !item.contains(event.relatedTarget))) {
                    hideRailTooltip();
                }
            });

            document.addEventListener('focusin', function (event) {
                const item = event.target.closest(tooltipTargets);
                if (item && item.matches(':focus-visible')) {
                    showRailTooltip(item);
                }
            });

            document.addEventListener('focusout', function (event) {
                if (event.target.closest(tooltipTargets)) {
                    hideRailTooltip();
                }
            });

            document.addEventListener('scroll', hideRailTooltip, true);
            window.addEventListener('resize', hideRailTooltip);

        })();

        const fullscreenButton = document.getElementById('fullscreen-button');
        if (fullscreenButton) {
            fullscreenButton.addEventListener('click', toggleFullscreen);
        }

        function toggleFullscreen() {
            const action = document.fullscreenElement
                ? document.exitFullscreen()
                : document.documentElement.requestFullscreen();
            if (action && typeof action.catch === 'function') {
                action.catch(function (error) {
                    console.error('Unable to toggle fullscreen:', error);
                });
            }
        }

        // start: Sidebar submenu
        document.querySelectorAll('.sidebar-dropdown-toggle').forEach(function (item) {
            item.addEventListener('click', function (e) {
                e.preventDefault()
                const parent = item.closest('.group')
                if (parent.classList.contains('selected')) {
                    parent.classList.remove('selected')
                } else {
                    document.querySelectorAll('.sidebar-dropdown-toggle').forEach(function (i) {
                        i.closest('.group').classList.remove('selected')
                    })
                    parent.classList.add('selected')
                }
            })
        })
        // end: Sidebar



        // start: Popper
        const popperInstance = {}
        document.querySelectorAll('.dropdown').forEach(function (item, index) {
            const popperId = 'popper-' + index
            const toggle = item.querySelector('.dropdown-toggle')
            const menu = item.querySelector('.dropdown-menu')
            menu.dataset.popperId = popperId
            popperInstance[popperId] = Popper.createPopper(toggle, menu, {
                modifiers: [
                    {
                        name: 'offset',
                        options: {
                            offset: [0, 8],
                        },
                    },
                    {
                        name: 'preventOverflow',
                        options: {
                            padding: 24,
                        },
                    },
                ],
                placement: 'bottom-end'
            });
        })
        document.addEventListener('click', function (e) {
            const toggle = e.target.closest('.dropdown-toggle')
            const menu = e.target.closest('.dropdown-menu')
            if (toggle) {
                const menuEl = toggle.closest('.dropdown').querySelector('.dropdown-menu')
                const popperId = menuEl.dataset.popperId
                if (menuEl.classList.contains('hidden')) {
                    hideDropdown()
                    menuEl.classList.remove('hidden')
                    showPopper(popperId)
                } else {
                    menuEl.classList.add('hidden')
                    hidePopper(popperId)
                }
            } else if (!menu) {
                hideDropdown()
            }
        })

        function hideDropdown() {
            document.querySelectorAll('.dropdown-menu').forEach(function (item) {
                item.classList.add('hidden')
            })
        }
        function showPopper(popperId) {
            popperInstance[popperId].setOptions(function (options) {
                return {
                    ...options,
                    modifiers: [
                        ...options.modifiers,
                        { name: 'eventListeners', enabled: true },
                    ],
                }
            });
            popperInstance[popperId].update();
        }
        function hidePopper(popperId) {
            popperInstance[popperId].setOptions(function (options) {
                return {
                    ...options,
                    modifiers: [
                        ...options.modifiers,
                        { name: 'eventListeners', enabled: false },
                    ],
                }
            });
        }
        // end: Popper



        // start: Tab
        document.querySelectorAll('[data-tab]').forEach(function (item) {
            item.addEventListener('click', function (e) {
                e.preventDefault()
                const tab = item.dataset.tab
                const page = item.dataset.tabPage
                const target = document.querySelector('[data-tab-for="' + tab + '"][data-page="' + page + '"]')
                document.querySelectorAll('[data-tab="' + tab + '"]').forEach(function (i) {
                    i.classList.remove('active')
                })
                document.querySelectorAll('[data-tab-for="' + tab + '"]').forEach(function (i) {
                    i.classList.add('hidden')
                })
                item.classList.add('active')
                target.classList.remove('hidden')
            })
        })
        // end: Tab



        // start: Chart
        const legacyOrderChart = document.getElementById('order-chart');
        if (legacyOrderChart) {
        new Chart(legacyOrderChart, {
            type: 'line',
            data: {
                labels: generateNDays(7),
                datasets: [
                    {
                        label: 'Active',
                        data: generateRandomData(7),
                        borderWidth: 1,
                        fill: true,
                        pointBackgroundColor: 'rgb(59, 130, 246)',
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgb(59 130 246 / .05)',
                        tension: .2
                    },
                    {
                        label: 'Completed',
                        data: generateRandomData(7),
                        borderWidth: 1,
                        fill: true,
                        pointBackgroundColor: 'rgb(16, 185, 129)',
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgb(16 185 129 / .05)',
                        tension: .2
                    },
                    {
                        label: 'Canceled',
                        data: generateRandomData(7),
                        borderWidth: 1,
                        fill: true,
                        pointBackgroundColor: 'rgb(244, 63, 94)',
                        borderColor: 'rgb(244, 63, 94)',
                        backgroundColor: 'rgb(244 63 94 / .05)',
                        tension: .2
                    },
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        }

        function generateNDays(n) {
            const data = []
            for(let i=0; i<n; i++) {
                const date = new Date()
                date.setDate(date.getDate()-i)
                data.push(date.toLocaleString('en-US', {
                    month: 'short',
                    day: 'numeric'
                }))
            }
            return data
        }
        function generateRandomData(n) {
            const data = []
            for(let i=0; i<n; i++) {
                data.push(Math.round(Math.random() * 10))
            }
            return data
        }
        // end: Chart

        
    </script>
