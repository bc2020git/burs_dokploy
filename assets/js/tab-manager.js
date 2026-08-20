class TabManager {
    /**
     * @param {string} tabContainerId
     * @param {string} pageId
     * @param {boolean} saveToHistory
     */
    static init(tabContainerId, pageId, saveToHistory = false) {
        this.tabContainerId = tabContainerId;
        this.pageId = pageId;
        this.saveToHistory = saveToHistory;
        this.storageKey = `active_tab_${this.pageId}`;

        document.addEventListener('DOMContentLoaded', () => {
            this.setupTabListeners();
            this.restoreActiveTab();
        });

        if (this.saveToHistory) {
            window.addEventListener('popstate', (event) => {
                if (event.state && event.state.tabId) {
                    this.activateTab(event.state.tabId, false);
                }
            });
        }
    }

    static setupTabListeners() {
        const tabContainer = document.getElementById(this.tabContainerId);
        if (!tabContainer) return;

        const tabs = tabContainer.querySelectorAll('[data-bs-toggle="tab"]');
        tabs.forEach(tab => {
            tab.addEventListener('shown.bs.tab', (event) => {
                const tabId = event.target.id;
                this.saveActiveTab(tabId);
            });
        });
    }

    /**
     * @param {string} tabId
     */
    static saveActiveTab(tabId) {
        localStorage.setItem(this.storageKey, tabId);

        if (this.saveToHistory) {
            const url = new URL(window.location);
            url.searchParams.set('tab', tabId);
            window.history.pushState({ tabId }, '', url);
        }
    }


    static processUrlParameters() {
        const urlParams = new URLSearchParams(window.location.search);
        const tabFromUrl = urlParams.get('tab');

        if (tabFromUrl) {
            this.activateTab(tabFromUrl);
            return true;
        }
        return false;
    }

    /**
     * Restore the active tab from localStorage
     */
    static restoreActiveTab() {
        if (this.processUrlParameters()) {
            return;
        }

        // Then check localStorage
        const savedTabId = localStorage.getItem(this.storageKey);

        if (savedTabId) {
            this.activateTab(savedTabId);
        }
    }

    /**
     * @param {string} tabId
     * @param {boolean} saveState
     */
    static activateTab(tabId, saveState = true) {
        const tabElement = document.getElementById(tabId);
        if (!tabElement) return;

        const tab = new bootstrap.Tab(tabElement);
        tab.show();

        if (saveState) {
            this.saveActiveTab(tabId);
        }
    }

    static clearTabState() {
        localStorage.removeItem(this.storageKey);
    }

    static reloadPageKeepingTab() {
        window.location.reload();
    }
}

window.TabManager = TabManager;
