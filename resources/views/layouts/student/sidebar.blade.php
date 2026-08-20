<div id="sidebar-student-container">



    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/components/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">



    <div class="wrapper">
        <aside id="sidebar" class="">
            <div class="d-flex align-items-center justify-content-start ">
                    <button id="toggle-btn" type="button">
                        <img id="sidebar-logo-expanded" src="{{ url('assets/images/logo-sm.svg') }}" alt="Dernek360" class="img-fluid" style="display: block;">
                        <img id="sidebar-logo-collapsed" src="{{ url('assets/images/Logo2.svg') }}" alt="Dernek360" class="img-fluid" style="display: none;">
                      </button>
                </div>
            <ul class="sidebar-nav">
                <a href="{{route('findmy_relations_forms')}}" class="sidebar-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                        <path d="M2 4.5C2 3.94772 2.44772 3.5 3 3.5H10.4142L12.4142 5.5H21C21.5523 5.5 22 5.94772 22 6.5V20.5C22 21.0523 21.5523 21.5 21 21.5H3C2.45 21.5 2 21.05 2 20.5V4.5ZM10.5858 6.5L9.58579 5.5H4V7.5H9.58579L10.5858 6.5ZM4 9.5V19.5H20V7.5H12.4142L10.4142 9.5H4Z" fill="#1a1a1a"></path>
                    </svg>
                    <span>Başvurularım</span>
                </a>
            </ul>
            <div class="sidebar-footer mb-3">
                <a href="#" class="sidebar-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10C20 15.5228 15.5228 20 10 20ZM9 9V15H11V9H9ZM9 5V7H11V5H9Z" fill="black"></path>
                    </svg>
                    <span>Yardım</span>
                </a>
                <a href="{{route('student-profile')}}" class="sidebar-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="21" viewBox="0 0 16 21" fill="none">
                        <path d="M16 21H0V19C0 16.2386 2.23858 14 5 14H11C13.7614 14 16 16.2386 16 19V21ZM8 12C4.68629 12 2 9.3137 2 6C2 2.68629 4.68629 0 8 0C11.3137 0 14 2.68629 14 6C14 9.3137 11.3137 12 8 12Z" fill="black"></path>
                    </svg>
                    <span>Hesabım</span>
                </a>
                <a onclick='toggleSidebar()' href="#" class="sidebar-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <path d="M2 2H10V16H2V2ZM16 16H12V2H16V16ZM1 0C0.44772 0 0 0.44772 0 1V17C0 17.5523 0.44772 18 1 18H17C17.5523 18 18 17.5523 18 17V1C18 0.44772 17.5523 0 17 0H1ZM8 9L4 5.5V12.5L8 9Z" fill="black"></path>
                            </svg></svg>
                        <span>Küçült</span>
                    </a>
                <a href="{{route('student-logout')}}" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" fill="black" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"
                                  stroke="black" stroke-width="0.75"/>
                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"
                                  stroke="black" stroke-width="0.75"/>
                        </svg>
                        <span>Çıkış Yap</span>
                    </a>


            </div>
        </aside>
    </div>
    <script src="../assets/js/components/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <script>
        // Local storage functions for sidebar state
        function saveSidebarState(isExpanded) {
            localStorage.setItem('studentSidebarExpanded', isExpanded ? 'true' : 'false');
        }

        function getSidebarState() {
            const saved = localStorage.getItem('studentSidebarExpanded');
            return saved !== null ? saved === 'true' : true; // Default to expanded if no preference saved
        }

        function initializeStudentSidebar() {
            const hamburger = document.querySelector("#toggle-btn");
            const minimizeLink = document.querySelector(".sidebar-footer .sidebar-link:last-child");
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

            // Toggle sidebar function
            window.toggleSidebar = function() {
                const minimizeSvg = document.querySelector(".sidebar-footer .sidebar-link:last-child svg");
                
                sidebar.classList.toggle("expand");
                if (mainContent) {
                    mainContent.classList.toggle("main-expand");
                }
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
            };

            // Event listeners
            if (hamburger) {
                hamburger.addEventListener("click", toggleSidebar);
            }
            if (minimizeLink) {
                minimizeLink.addEventListener("click", toggleSidebar);
            }

            // Load saved sidebar state from localStorage
            const savedExpanded = getSidebarState();
            
            if (savedExpanded) {
                sidebar.classList.add("expand");
                if (mainContent) {
                    mainContent.classList.add("main-expand");
                }
                if (navbar) {
                    navbar.classList.add("navbar-expand");
                }
                
                const minimizeSvg = document.querySelector(".sidebar-footer .sidebar-link:last-child svg");
                if (minimizeSvg) {
                    minimizeSvg.innerHTML = svgCollapse;
                }
                
                // Set logo state for expanded
                if (logoExpanded && logoCollapsed) {
                    logoExpanded.style.display = "block";
                    logoCollapsed.style.display = "none";
                }
            } else {
                sidebar.classList.remove("expand");
                if (mainContent) {
                    mainContent.classList.remove("main-expand");
                }
                if (navbar) {
                    navbar.classList.remove("navbar-expand");
                }
                
                const minimizeSvg = document.querySelector(".sidebar-footer .sidebar-link:last-child svg");
                if (minimizeSvg) {
                    minimizeSvg.innerHTML = svgExpand;
                }
                
                // Set logo state for collapsed
                if (logoExpanded && logoCollapsed) {
                    logoExpanded.style.display = "none";
                    logoCollapsed.style.display = "block";
                }
            }
        }

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initializeStudentSidebar();
        });
    </script>
    <!-- Code injected by live-server -->
    <script>
        // <![CDATA[  <-- For SVG support
        if ('WebSocket' in window) {
            (function () {
                function refreshCSS() {
                    var sheets = [].slice.call(document.getElementsByTagName("link"));
                    var head = document.getElementsByTagName("head")[0];
                    for (var i = 0; i < sheets.length; ++i) {
                        var elem = sheets[i];
                        var parent = elem.parentElement || head;
                        parent.removeChild(elem);
                        var rel = elem.rel;
                        if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
                            var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
                            elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
                        }
                        parent.appendChild(elem);
                    }
                }
                var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
                var address = protocol + window.location.host + window.location.pathname + '/ws';
                var socket = new WebSocket(address);
                socket.onmessage = function (msg) {
                    if (msg.data == 'reload') window.location.reload();
                    else if (msg.data == 'refreshcss') refreshCSS();
                };
                if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
                    console.log('Live reload enabled.');
                    sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
                }
            })();
        }
        else {
            console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
        }
        // ]]>
    </script>


</div>
