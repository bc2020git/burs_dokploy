function loadSidebar() {

}


function initializeSidebar() {
    const hamburger = document.querySelector("#toggle-btn");
    const minimizeLink = document.querySelector(".sidebar-footer .sidebar-link:last-child");
    const minimizeSvg = minimizeLink.querySelector("svg");
    const mainContent = document.querySelector(".main");
    const navbar = document.querySelector(".navbar");

    const svgExpand = `
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
            <path d="M2 2H10V16H2V2ZM16 16H12V2H16V16ZM1 0C0.44772 0 0 0.44772 0 1V17C0 17.5523 0.44772 18 1 18H17C17.5523 18 18 17.5523 18 17V1C18 0.44772 17.5523 0 17 0H1ZM8 9L4 5.5V12.5L8 9Z" fill="black"/>
        </svg>`;

    const svgCollapse = `
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
            <path d="M2 2H10V16H2V2ZM16 16H12V2H16V16ZM1 0C0.44772 0 0 0.44772 0 1V17C0 17.5523 0.44772 18 1 18H17C17.5523 18 18 17.5523 18 17V1C18 0.44772 17.5523 0 17 0H1ZM4 9L8 5.5V12.5L4 9Z" fill="black"/>
        </svg>`;

    function toggleSidebar() {
        const sidebar = document.querySelector("#sidebar");
        sidebar.classList.toggle("expand");
        mainContent.classList.toggle("main-expand");
        navbar.classList.toggle("navbar-expand");

        if (sidebar.classList.contains("expand")) {
            minimizeSvg.innerHTML = svgCollapse;
        } else {
            minimizeSvg.innerHTML = svgExpand;
        }
    }

    hamburger.addEventListener("click", toggleSidebar);
    minimizeLink.addEventListener("click", toggleSidebar);
}

document.addEventListener('DOMContentLoaded', function () {
    loadSidebar();
});
