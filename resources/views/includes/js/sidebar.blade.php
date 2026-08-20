<script>
    const mainContent = document.querySelector(".main");


function loadSidebar() {
    // Initialize sidebar functionality
}

// Local storage functions for sidebar state
function saveSidebarState(isExpanded) {
    localStorage.setItem('sidebarExpanded', isExpanded ? 'true' : 'false');
}

function getSidebarState() {
    const saved = localStorage.getItem('sidebarExpanded');
    return saved !== null ? saved === 'true' : true; // Default to expanded if no preference saved
}

function  checkleng(){
    const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
    var length  = selectedCheckboxes.length;
    return length > 0;
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

function initializeSidebar() {
    const hamburger = document.querySelector("#toggle-btn");
    const minimizeLink = document.querySelector("#minimize-sidebar-btn");
    const minimizeSvg = minimizeLink.querySelector("svg");
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

    hamburger.addEventListener("click", toggleSidebar);
    minimizeLink.addEventListener("click", toggleSidebar);

    // Load saved sidebar state from localStorage
    const savedExpanded = getSidebarState();

    if (savedExpanded) {
        sidebar.classList.add("expand");
        mainContent.classList.add("main-expand");
        navbar.classList.add("navbar-expand");
        minimizeSvg.innerHTML = svgCollapse;

        // Set logo state for expanded
        if (logoExpanded && logoCollapsed) {
            logoExpanded.style.display = "block";
            logoCollapsed.style.display = "none";
        }
    } else {
        sidebar.classList.remove("expand");
        mainContent.classList.remove("main-expand");
        navbar.classList.remove("navbar-expand");
        minimizeSvg.innerHTML = svgExpand;

        // Set logo state for collapsed
        if (logoExpanded && logoCollapsed) {
            logoExpanded.style.display = "none";
            logoCollapsed.style.display = "block";
        }
    }
}
document.addEventListener('DOMContentLoaded', function() {
   // Tanımlamalar menüsü içindeki tüm li elementlerini seç
   const definitionItems = document.querySelectorAll('#definitionsCollapse .sidebar-item');

   // Active class'ına sahip li elementi var mı kontrol et
   const hasActiveItem = Array.from(definitionItems).some(item => item.classList.contains('active'));

   // Eğer active olan bir element varsa
   if (hasActiveItem) {
       // definitionsCollapse elementine show class'ı ekle
       document.getElementById('definitionsCollapse').classList.add('show');
   }
});
 function toggleSidebar() {
        const sidebar = document.querySelector("#sidebar");
        const navbar = document.querySelector(".navbar");
        const logoExpanded = document.querySelector("#sidebar-logo-expanded");
        const logoCollapsed = document.querySelector("#sidebar-logo-collapsed");
        const minimizeSvg = document.querySelector("#minimize-sidebar-btn svg");

        const svgExpand = `
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                <path d="M2 2H10V16H2V2ZM16 16H12V2H16V16ZM1 0C0.44772 0 0 0.44772 0 1V17C0 17.5523 0.44772 18 1 18H17C17.5523 18 18 17.5523 18 17V1C18 0.44772 17.5523 0 17 0H1ZM8 9L4 5.5V12.5L8 9Z" fill="black"/>
            </svg>`;

        const svgCollapse = `
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                <path d="M2 2H10V16H2V2ZM16 16H12V2H16V16ZM1 0C0.44772 0 0 0.44772 0 1V17C0 17.5523 0.44772 18 1 18H17C17.5523 18 18 17.5523 18 17V1C18 0.44772 17.5523 0 17 0H1ZM4 9L8 5.5V12.5L4 9Z" fill="black"/>
            </svg>`;

        sidebar.classList.toggle("expand");
        mainContent.classList.toggle("main-expand");
        if (navbar) {
            navbar.classList.toggle("navbar-expand");
        }

        if (sidebar.classList.contains("expand")) {
            if (minimizeSvg) {
                minimizeSvg.innerHTML = svgCollapse;
            }
            // Show expanded logo, hide collapsed logo
            if (logoExpanded && logoCollapsed) {
                logoExpanded.style.display = "block";
                logoCollapsed.style.display = "none";
            }
            // Save expanded state
            saveSidebarState(true);
        } else {
            if (minimizeSvg) {
                minimizeSvg.innerHTML = svgExpand;
            }
            // Show collapsed logo, hide expanded logo
            if (logoExpanded && logoCollapsed) {
                logoExpanded.style.display = "none";
                logoCollapsed.style.display = "block";
            }
            // Save collapsed state
            saveSidebarState(false);
        }
    }


document.addEventListener('DOMContentLoaded', function() {
    loadSidebar();
    initializeSidebar();
    protectMyAccountIcon(); // Call the new function here

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


</script>

