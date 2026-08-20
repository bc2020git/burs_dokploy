function loadSidebar() {

}

function initializeSidebar() {
    const hamburger = document.querySelector("#toggle-btn");
    const minimizeLink = document.querySelector(".sidebar-footer .sidebar-link:last-child");
    const minimizeSvg = minimizeLink.querySelector("svg");
    const mainContent = document.querySelector(".main");
    const navbar = document.querySelector(".navbar");
    const sidebar = document.querySelector("#sidebar");
    const logoExpanded = document.querySelector("#sidebar-logo-expanded");
    const logoCollapsed = document.querySelector("#sidebar-logo-collapsed");

    const svgExpand = `
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
            <path d="M2 2H10V16H2V2ZM16 16H12V2H16V16ZM1 0C0.44772 0 0 0.44772 0 1V17C0 17.5523 0.44772 18 1 18H17C17.5523 18 18 17.5523 18 17V1C18 0.44772 17.5523 0 17 0H1ZM8 9L4 5.5V12.5L8 9Z" fill="black"/>
        </svg>`;

    const svgCollapse = `
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
            <path d="M2 2H10V16H2V2ZM16 16H12V2H16V16ZM1 0C0.44772 0 0 0.44772 0 1V17C0 17.5523 0.44772 18 1 18H17C17.5523 18 18 17.5523 18 17V1C18 0.44772 17.5523 0 17 0H1ZM4 9L8 5.5V12.5L4 9Z" fill="black"/>
        </svg>`;

    function toggleSidebar() {
        sidebar.classList.toggle("expand");
        mainContent.classList.toggle("main-expand");
        navbar.classList.toggle("navbar-expand");

        if (sidebar.classList.contains("expand")) {
            // Sadece minimize butonunun ikonunu değiştir
            minimizeSvg.innerHTML = svgCollapse;
            // Show expanded logo, hide collapsed logo
            if (logoExpanded && logoCollapsed) {
                logoExpanded.style.display = "block";
                logoCollapsed.style.display = "none";
            }
        } else {
            // Sadece minimize butonunun ikonunu değiştir
            minimizeSvg.innerHTML = svgExpand;
            // Show collapsed logo, hide expanded logo
            if (logoExpanded && logoCollapsed) {
                logoExpanded.style.display = "none";
                logoCollapsed.style.display = "block";
            }
        }
    }

    hamburger.addEventListener("click", toggleSidebar);
    minimizeLink.addEventListener("click", toggleSidebar);

    sidebar.classList.add("expand");
    mainContent.classList.add("main-expand");
    navbar.classList.add("navbar-expand");
    minimizeSvg.innerHTML = svgCollapse;
    // Set initial logo state (expanded by default)
    if (logoExpanded && logoCollapsed) {
        logoExpanded.style.display = "block";
        logoCollapsed.style.display = "none";
    }
}

// "Hesabım" ikonunun korunması için ek güvenlik
function protectMyAccountIcon() {
    const myAccountIcon = document.querySelector('.my-account-icon');
    if (myAccountIcon) {
        // İkonun orijinal içeriğini sakla
        const originalIconContent = myAccountIcon.innerHTML;

        // Periyodik olarak ikonun değişip değişmediğini kontrol et
        setInterval(() => {
            if (myAccountIcon.innerHTML !== originalIconContent) {
                myAccountIcon.innerHTML = originalIconContent;
            }
        }, 100);
    }
}

function initializeActiveSidebar() {
    const currentPath = window.location.pathname;
    const sidebarItems = document.querySelectorAll('.sidebar-item');

    sidebarItems.forEach(item => {
        const link = item.querySelector('.sidebar-link');
        const href = link.getAttribute('href');

        // Aday Bursiyerler
        if (currentPath.includes('/admin/candidate-scholars.html') ||
        currentPath.includes('/admin/candidate-update-details.html') ||
        currentPath.includes('/admin/add-scholarship-application-manuel.html')) {
        if (href === '/admin/candidate-scholars.html' ||
            href === '/admin/add-scholarship-application-manuel.html') {
            item.classList.add('active');
        }
    }
        // Kayıt Yenilemeler
        else if (currentPath.includes('/admin/registration-renewal.html') ||
                 currentPath.includes('/admin/registration-renewal-details.html') ||
                currentPath.includes('/admin/new-registration-renewal-details.html')) {
            if (href === '/admin/registration-renewal.html') {
                item.classList.add('active');
            }
        }
        // Bursiyerler Listesi
        else if (currentPath.includes('/admin/scholarship-recipient-list.html') ||
                 currentPath.includes('/admin/active-scholarship-details.html')||
                currentPath.includes('/admin/new-scholarship-application-manuel.html')) {
            if (href === '/admin/scholarship-recipient-list.html') {
                item.classList.add('active');
            }
        }
        // Mezunlar
        else if (currentPath.includes('/admin/graduate-scholar.html') ||
                 currentPath.includes('/admin/graduate-scholar-details.html')) {
            if (href === '/admin/graduate-scholar.html') {
                item.classList.add('active');
            }
        }
        // Eğer belirli bir eşleşme yoksa, URL'nin tam eşleşmesine bak
        else if (href === currentPath) {
            item.classList.add('active');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    loadSidebar();
    initializeSidebar();
    initializeActiveSidebar();
    protectMyAccountIcon();

    // Tüm checkbox'ları toplu seçme ve durum değiştirme
    const masterCheckbox = document.querySelector("#masterCheckbox");
    if (masterCheckbox) {
        masterCheckbox.addEventListener('change', function () {
            const checkboxes = document.querySelectorAll(".checkbox");
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

});
