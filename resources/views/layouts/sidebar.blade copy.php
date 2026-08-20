@php
    $user = Auth::user();
    $permissions = $user->role->permissions->pluck('name')->toArray();

    function hasPermission($permissionName, $permissions) {
        return in_array($permissionName, $permissions);
    }
@endphp
<div id="sidebar-container">
        <div class="wrapper">
            <aside id="sidebar" class="d-flex flex-column expand">
                <div class="d-flex align-items-center justify-content-start ">
                    <button id="toggle-btn" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 48 48" fill="none">
                            <path d="M35.0789 22.12C40.1599 22.12 44.2789 18.001 44.2789 12.92C44.2789 7.83895 40.1599 3.71997 35.0789 3.71997C29.9979 3.71997 25.8789 7.83895 25.8789 12.92C25.8789 18.001 29.9979 22.12 35.0789 22.12Z" fill="#00BDD6"></path>
                            <path d="M35.0789 44.2799C40.1599 44.2799 44.2789 40.161 44.2789 35.0799C44.2789 29.9989 40.1599 25.8799 35.0789 25.8799C29.9979 25.8799 25.8789 29.9989 25.8789 35.0799C25.8789 40.161 29.9979 44.2799 35.0789 44.2799Z" fill="#8353E2"></path>
                            <path d="M4.64062 19.3999C4.64062 10.7623 11.6429 3.75995 20.2806 3.75995V28.5999C20.2806 37.2376 13.2783 44.2399 4.64062 44.2399V19.3999Z" fill="#4069E5"></path>
                        </svg>
                    </button>
                    <div class="sidebar-logo">
                        <a href="#">Digi CRM</a>
                        <span>Yenilik Katar</span>
                    </div>
                </div>
                <div class="sidebar-item-header">Burs Modülü</div>
                <ul class="sidebar-nav flex-grow-1">
                    <li class="sidebar-item {{ (session('sidebar') == 1 ) ? 'active' : '' }}" id="candidateScholars">
                        <a href="{{route('panel')}}" class="sidebar-link ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                                <path d="M3 4.5C3 3.94772 3.44772 3.5 4 3.5H10C10.5523 3.5 11 3.94772 11 4.5V10.5C11 11.0523 10.5523 11.5 10 11.5H4C3.44772 11.5 3 11.0523 3 10.5V4.5ZM3 14.5C3 13.9477 3.44772 13.5 4 13.5H10C10.5523 13.5 11 13.9477 11 14.5V20.5C11 21.0523 10.5523 21.5 10 21.5H4C3.44772 21.5 3 21.0523 3 20.5V14.5ZM13 4.5C13 3.94772 13.4477 3.5 14 3.5H20C20.5523 3.5 21 3.94772 21 4.5V10.5C21 11.0523 20.5523 11.5 20 11.5H14C13.4477 11.5 13 11.0523 13 10.5V4.5ZM13 14.5C13 13.9477 13.4477 13.5 14 13.5H20C20.5523 13.5 21 13.9477 21 14.5V20.5C21 21.0523 20.5523 21.5 20 21.5H14C13.4477 21.5 13 21.0523 13 20.5V14.5ZM15 5.5V9.5H19V5.5H15ZM15 15.5V19.5H19V15.5H15ZM5 5.5V9.5H9V5.5H5ZM5 15.5V19.5H9V15.5H5Z" fill="#1A1A1A"></path>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    @if(hasPermission('aday-basvurularini-listele', $permissions))
                    <li class="sidebar-item {{ (session('sidebar') == 2 ) ? 'active' : '' }}" id="candidateScholars">
                        <a href="{{route('adaybursiyerler')}}" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5ZM4 5V19H20V7H11.5858L9.58579 5H4ZM11 12V9H13V12H16V14H13V17H11V14H8V12H11Z" fill="#333333"></path>
                            </svg>
                            <span>Aday Bursiyerler</span>
                        </a>
                    </li>
                    @endif
                    @if(hasPermission('mulakat-yonet', $permissions))
                    <li class="sidebar-item {{ (session('sidebar') == 3 ) ? 'active' : '' }}" id="candidateScholars">
                        <a href="{{route('mulakatlar')}}" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M21 11.5C21.0034 12.8199 20.6951 14.1219 20.1 15.3C19.3944 16.7118 18.3098 17.8992 16.9674 18.7293C15.6251 19.5594 14.0782 19.9994 12.5 20C11.1801 20.0035 9.87812 19.6951 8.7 19.1L3 21L4.9 15.3C4.30493 14.1219 3.99656 12.8199 4 11.5C4.00061 9.92179 4.44061 8.37488 5.27072 7.03258C6.10083 5.69028 7.28825 4.6056 8.7 3.90003C9.87812 3.30496 11.1801 2.99659 12.5 3.00003H13C15.0843 3.11502 17.053 3.99479 18.5291 5.47089C20.0052 6.94699 20.885 8.91568 21 11V11.5Z" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <span>Mülakatlar</span>
                        </a>
                    </li>
                    @endif
                    @if(hasPermission('kayit-yenileme-listele', $permissions))
                    <li class="sidebar-item {{ (session('sidebar') == 4 ) ? 'active' : '' }}" id="candidateScholars">
                        <a href="{{route('kayityenileme')}}" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M17 1L21 5L17 9" fill="#1A1A1A"></path>
                                <path d="M17 1L21 5L17 9" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M3 11V9C3 7.93913 3.42143 6.92172 4.17157 6.17157C4.92172 5.42143 5.93913 5 7 5H21" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M7 23L3 19L7 15" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M21 13V15C21 16.0609 20.5786 17.0783 19.8284 17.8284C19.0783 18.5786 18.0609 19 17 19H3" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <span>Kayıt Yenileme</span>
                        </a>
                    </li>
                    @endif
                    @if(hasPermission('aktif-bursiyer-listele', $permissions))
                    <li class="sidebar-item {{ (session('sidebar') == 5 ) ? 'active' : '' }}" id="candidateScholars">
                        <a href="{{route('bursiyerler')}}" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M12 11C14.7614 11 17 13.2386 17 16V22H15V16C15 14.4023 13.7511 13.0963 12.1763 13.0051L12 13C10.4023 13 9.09634 14.2489 9.00509 15.8237L9 16V22H7V16C7 13.2386 9.23858 11 12 11ZM5.5 14C5.77885 14 6.05009 14.0326 6.3101 14.0942C6.14202 14.594 6.03873 15.122 6.00896 15.6693L6 16L6.0007 16.0856C5.88757 16.0456 5.76821 16.0187 5.64446 16.0069L5.5 16C4.7203 16 4.07955 16.5949 4.00687 17.3555L4 17.5V22H2V17.5C2 15.567 3.567 14 5.5 14ZM18.5 14C20.433 14 22 15.567 22 17.5V22H20V17.5C20 16.7203 19.4051 16.0796 18.6445 16.0069L18.5 16C18.3248 16 18.1566 16.03 18.0003 16.0852L18 16C18 15.3343 17.8916 14.694 17.6915 14.0956C17.9499 14.0326 18.2211 14 18.5 14ZM5.5 8C6.88071 8 8 9.11929 8 10.5C8 11.8807 6.88071 13 5.5 13C4.11929 13 3 11.8807 3 10.5C3 9.11929 4.11929 8 5.5 8ZM18.5 8C19.8807 8 21 9.11929 21 10.5C21 11.8807 19.8807 13 18.5 13C17.1193 13 16 11.8807 16 10.5C16 9.11929 17.1193 8 18.5 8ZM5.5 10C5.22386 10 5 10.2239 5 10.5C5 10.7761 5.22386 11 5.5 11C5.77614 11 6 10.7761 6 10.5C6 10.2239 5.77614 10 5.5 10ZM18.5 10C18.2239 10 18 10.2239 18 10.5C18 10.7761 18.2239 11 18.5 11C18.7761 11 19 10.7761 19 10.5C19 10.2239 18.7761 10 18.5 10ZM12 2C14.2091 2 16 3.79086 16 6C16 8.20914 14.2091 10 12 10C9.79086 10 8 8.20914 8 6C8 3.79086 9.79086 2 12 2ZM12 4C10.8954 4 10 4.89543 10 6C10 7.10457 10.8954 8 12 8C13.1046 8 14 7.10457 14 6C14 4.89543 13.1046 4 12 4Z" fill="#1A1A1A"></path>
                            </svg>
                            <span>Bursiyerler</span>
                        </a>
                    </li>
                    @endif
                    @if(hasPermission('burs-odeme-listele', $permissions))
                    <li class="sidebar-item {{ (session('sidebar') == 6 ) ? 'active' : '' }}" id="candidateScholars">
                        <a href="{{route('bursodemebilgileri')}}" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M20.0078 6.99976V4.99976H4.00781V18.9998H20.0078V16.9998H12.0078C11.4555 16.9998 11.0078 16.5521 11.0078 15.9998V7.99976C11.0078 7.44747 11.4555 6.99976 12.0078 6.99976H20.0078ZM3.00781 2.99976H21.0078C21.5601 2.99976 22.0078 3.44747 22.0078 3.99976V19.9998C22.0078 20.5521 21.5601 20.9998 21.0078 20.9998H3.00781C2.45553 20.9998 2.00781 20.5521 2.00781 19.9998V3.99976C2.00781 3.44747 2.45553 2.99976 3.00781 2.99976ZM13.0078 8.99976V14.9998H20.0078V8.99976H13.0078ZM15.0078 10.9998H18.0078V12.9998H15.0078V10.9998Z" fill="#333333"></path>
                            </svg>
                            <span>Burs Ödeme Bilgileri</span>
                        </a>
                    </li>
                    @endif
                    @if(hasPermission('mezun-listele', $permissions))
                    <li class="sidebar-item {{ (session('sidebar') == 7 ) ? 'active' : '' }}" id="candidateScholars">
                        <a href="{{route('mezunlar')}}" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M4 11.3333L0 9L12 2L24 9V17.5H22V10.1667L20 11.3333V18.0113L19.7774 18.2864C17.9457 20.5499 15.1418 22 12 22C8.85817 22 6.05429 20.5499 4.22263 18.2864L4 18.0113V11.3333ZM6 12.5V17.2917C7.46721 18.954 9.61112 20 12 20C14.3889 20 16.5328 18.954 18 17.2917V12.5L12 16L6 12.5ZM3.96927 9L12 13.6846L20.0307 9L12 4.31541L3.96927 9Z" fill="#333333"></path>
                            </svg>
                            <span>Mezunlar</span>
                        </a>
                    </li>
                    @endif

                        @if(hasPermission('burs-veren-yonet', $permissions))
                    <!--
                        izin kategorilerinden kaldırıldı
                        izinlere de ekle
                        <li class="sidebar-item {{ (session('sidebar') == 30 ) ? 'active' : '' }}" id="candidateScholars">
                        <a href="{{ route('bursverenler.index') }}" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="#1A1A1A"/>
                            </svg>
                            <span>Bursverenler</span>
                        </a>
                    </li>-->
                    @endif

                </ul>
                <ul class="sidebar-nav">
                    @php $sessionsidebarlinks = ['8','9','10','11','12','13','14','15','16','17','18']; @endphp
                    @if(hasPermission('tanim-sekme-goruntule', $permissions))
                    <li class="sidebar-item ">
                        <a href="#" class="sidebar-link has-dropdown" data-bs-toggle="collapse" data-bs-target="#definitionsCollapse" aria-expanded="@php echo in_array(session('sidebar'), $sessionsidebarlinks) ? 'true' : 'false'; @endphp" aria-controls="definitionsCollapse">
                            <span class="sidebar-item-header">Tanımlar</span>
                        </a>
                        <div id="definitionsCollapse" class="collapse @php echo in_array(session('sidebar'), $sessionsidebarlinks) ? 'show' : ''; @endphp sidebar-dropdown">
                            <ul class="sidebar-nav">
                            @if(hasPermission('donem-yonetimi-yonet', $permissions))
                                <li class="sidebar-item {{ (session('sidebar') == 8 ) ? 'active' : '' }}" id="candidateScholars">
                                    <a href="{{route('period-management')}}" class="sidebar-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z" fill="black"></path>
                                        </svg>
                                        <span>Dönem Yönetimi</span>
                                    </a>
                                </li>
                                @endif
                                @if(hasPermission('il-yonet', $permissions))
                                <li class="sidebar-item {{ (session('sidebar') == 9 ) ? 'active' : '' }}" id="candidateScholars">
                                    <a href="{{route('get-provinces')}}" class="sidebar-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 23.7279L5.63604 17.364C2.12132 13.8492 2.12132 8.15076 5.63604 4.63604C9.15076 1.12132 14.8492 1.12132 18.364 4.63604C21.8787 8.15076 21.8787 13.8492 18.364 17.364L12 23.7279ZM16.9497 15.9497C19.6834 13.2161 19.6834 8.78392 16.9497 6.05025C14.2161 3.31658 9.78392 3.31658 7.05025 6.05025C4.31658 8.78392 4.31658 13.2161 7.05025 15.9497L12 20.8995L16.9497 15.9497ZM12 13C10.8954 13 10 12.1046 10 11C10 9.89543 10.8954 9 12 9C13.1046 9 14 9.89543 14 11C14 12.1046 13.1046 13 12 13Z" fill="#333333"></path>
                                        </svg>
                                        <span>İller</span>
                                    </a>
                                </li>
                                @endif
                                @if(hasPermission('ilce-yonet', $permissions))
                                <li class="sidebar-item {{ (session('sidebar') == 10 ) ? 'active' : '' }}" id="candidateScholars">
                                    <a href="{{route('get-districts')}}" class="sidebar-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M9 22V12H15V22" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        <span>İlçeler</span>
                                    </a>
                                </li>
                                @endif
                                @if(hasPermission('banka-yonet', $permissions))
                                <li class="sidebar-item {{ (session('sidebar') == 11 ) ? 'active' : '' }}" id="candidateScholars">
                                    <a href="{{route('get-banks')}}" class="sidebar-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M20 7H4C2.89543 7 2 7.89543 2 9V19C2 20.1046 2.89543 21 4 21H20C21.1046 21 22 20.1046 22 19V9C22 7.89543 21.1046 7 20 7Z" fill="white" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M16 21V5C16 4.46957 15.7893 3.96086 15.4142 3.58579C15.0391 3.21071 14.5304 3 14 3H10C9.46957 3 8.96086 3.21071 8.58579 3.58579C8.21071 3.96086 8 4.46957 8 5V21" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        <span>Bankalar</span>
                                    </a>
                                </li>
                                @endif
                                @if(hasPermission('universite-yonet', $permissions))
                                <li class="sidebar-item {{ (session('sidebar') == 12 ) ? 'active' : '' }}" id="candidateScholars">
                                    <a href="{{route('get-univercities')}}" class="sidebar-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M21 20H23V22H1V20H3V3C3 2.44772 3.44772 2 4 2H20C20.5523 2 21 2.44772 21 3V20ZM19 20V4H5V20H19ZM8 11H11V13H8V11ZM8 7H11V9H8V7ZM8 15H11V17H8V15ZM13 15H16V17H13V15ZM13 11H16V13H13V11ZM13 7H16V9H13V7Z" fill="#333333"></path>
                                        </svg>
                                        <span>Üniversiteler</span>
                                    </a>
                                </li>
                                @endif
                                @if(hasPermission('fakulte-yonet', $permissions))
                                <li class="sidebar-item {{ (session('sidebar') == 13 ) ? 'active' : '' }}" id="candidateScholars">
                                    <a href="{{route('get-faculties')}}" class="sidebar-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 0.585938L18 6.58593V9.00024H22V19.0002H23V21.0002H1V19.0002H2V9.00024H6V6.58593L12 0.585938ZM18 19.0002H20V11.0002H18V19.0002ZM6 11.0002H4V19.0002H6V11.0002ZM8 7.41436V19.0001H11V12.0002H13V19.0001H16V7.41436L12 3.41436L8 7.41436Z" fill="#333333"></path>
                                        </svg>
                                        <span>Fakülteler</span>
                                    </a>
                                </li>
                                @endif
                                @if(hasPermission('bolum-yonet', $permissions))
                                <li class="sidebar-item {{ (session('sidebar') == 14 ) ? 'active' : '' }}" id="candidateScholars">
                                    <a href="{{route('get-departmants')}}" class="sidebar-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M23 19.0001H22V9.00015H18V6.58593L12 0.585938L6 6.58593V9.00015H2V19.0001H1V21.0001H23V19.0001ZM6 19.0002H4V11.0002H6V19.0002ZM18 11.0002H20V19.0002H18V11.0002ZM11 12.0002H13V19.0002H11V12.0002Z" fill="#333333"></path>
                                        </svg>
                                        <span>Bölümler</span>
                                    </a>
                                </li>
                                @endif
                                @if(hasPermission('form-soru-yonet', $permissions))
                                @php $sessionFormLinks = ['15','16','17','18']; @endphp
                                <li class="sidebar-item ">
                                    <a href="#" class="sidebar-link" data-bs-toggle="collapse" data-bs-target="#sorucollapse" aria-expanded="@php echo in_array(session('sidebar'), $sessionFormLinks) ? 'true' : 'false'; @endphp" aria-controls="definitionsCollapse">
                                        <img height="24" src="{{url('assets/images/questions.svg')}}" alt="">
                                        <span>Form Yönetimi</span>
                                    </a>
                                </li>
                                <div id="sorucollapse" class="collapse @php echo in_array(session('sidebar'), $sessionFormLinks) ? 'show' : ''; @endphp ps-4 sidebar-dropdown">
                                    <li class="sidebar-item {{ (session('sidebar') == 15 ) ? 'active' : '' }}" id="candidateScholars">
                                        <a href="{{route('form-sorulari')}}" class="sidebar-link">
                                            <span>Sorular</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-item {{ (session('sidebar') == 16 ) ? 'active' : '' }}" id="candidateScholars">
                                        <a href="{{route('form-sorulari-kategoriler')}}" class="sidebar-link active">
                                            <span>Kategoriler</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-item {{ (session('sidebar') == 17 ) ? 'active' : '' }}" id="candidateScholars">
                                        <a href="{{route('basvuru-formlari')}}" class="sidebar-link">
                                            <span>Formlar</span>
                                        </a>
                                    </li>
                                </div>
                                @endif
                                @if(hasPermission('mulakat-grup-yonet', $permissions))
                                <li class="sidebar-item {{ (session('sidebar') == 18 ) ? 'active' : '' }}" id="candidateScholars">
                                <a href="{{ route('mulakat-grup.index') }}" class="sidebar-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 11C14.7614 11 17 13.2386 17 16V22H15V16C15 14.4023 13.7511 13.0963 12.1763 13.0051L12 13C10.4023 13 9.09634 14.2489 9.00509 15.8237L9 16V22H7V16C7 13.2386 9.23858 11 12 11ZM5.5 14C5.77885 14 6.05009 14.0326 6.3101 14.0942C6.14202 14.594 6.03873 15.122 6.00896 15.6693L6 16L6.0007 16.0856C5.88757 16.0456 5.76821 16.0187 5.64446 16.0069L5.5 16C4.7203 16 4.07955 16.5949 4.00687 17.3555L4 17.5V22H2V17.5C2 15.567 3.567 14 5.5 14ZM18.5 14C20.433 14 22 15.567 22 17.5V22H20V17.5C20 16.7203 19.4051 16.0796 18.6445 16.0069L18.5 16C18.3248 16 18.1566 16.03 18.0003 16.0852L18 16C18 15.3343 17.8916 14.694 17.6915 14.0956C17.9499 14.0326 18.2211 14 18.5 14ZM5.5 8C6.88071 8 8 9.11929 8 10.5C8 11.8807 6.88071 13 5.5 13C4.11929 13 3 11.8807 3 10.5C3 9.11929 4.11929 8 5.5 8ZM18.5 8C19.8807 8 21 9.11929 21 10.5C21 11.8807 19.8807 13 18.5 13C17.1193 13 16 11.8807 16 10.5C16 9.11929 17.1193 8 18.5 8ZM5.5 10C5.22386 10 5 10.2239 5 10.5C5 10.7761 5.22386 11 5.5 11C5.77614 11 6 10.7761 6 10.5C6 10.2239 5.77614 10 5.5 10ZM18.5 10C18.2239 10 18 10.2239 18 10.5C18 10.7761 18.2239 11 18.5 11C18.7761 11 19 10.7761 19 10.5C19 10.2239 18.7761 10 18.5 10ZM12 2C14.2091 2 16 3.79086 16 6C16 8.20914 14.2091 10 12 10C9.79086 10 8 8.20914 8 6C8 3.79086 9.79086 2 12 2ZM12 4C10.8954 4 10 4.89543 10 6C10 7.10457 10.8954 8 12 8C13.1046 8 14 7.10457 14 6C14 4.89543 13.1046 4 12 4Z" fill="#1A1A1A"></path>
                                        </svg>
                                        <span>Mülakat Grupları</span>
                                    </a>
                                </li>
                                @endif
                                @if(hasPermission('burs-tipi-yonet', $permissions))
                                <li class="sidebar-item {{ (session('sidebar') == 19 ) ? 'active' : '' }}" id="candidateScholars">
                                <a href="{{ route('burs-tipleri.index') }}" class="sidebar-link">
                                        <img height="24" src="{{url('public/assets/svg/tanimlar-burstipleri.svg')}}" alt="">
                                        <span>Burs Tipleri</span>
                                    </a>
                                </li>
                                @endif

                            </ul>
                        </div>
                    </li>
                    @endif
                </ul>
                <div class="sidebar-footer mb-3">
                    <a href="#" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10C20 15.5228 15.5228 20 10 20ZM9 9V15H11V9H9ZM9 5V7H11V5H9Z" fill="black"></path>
                        </svg>
                        <span>Yardım</span>
                    </a>
                    <li class="sidebar-item {{ (session('sidebar') == 24 ) ? 'active' : '' }}">
                    <a href="{{route('myAccount')}}" class="sidebar-link {{ (session('sidebar') == 24 ) ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="21" viewBox="0 0 16 21" fill="none">
                            <path d="M16 21H0V19C0 16.2386 2.23858 14 5 14H11C13.7614 14 16 16.2386 16 19V21ZM8 12C4.68629 12 2 9.3137 2 6C2 2.68629 4.68629 0 8 0C11.3137 0 14 2.68629 14 6C14 9.3137 11.3137 12 8 12Z" fill="black"></path>
                        </svg>
                        <span>Hesabım</span>
                    </a>
                    @php $sessionSettingsLinks = ['21','22','23','31','32','33']; @endphp
                    <li class="sidebar-item ">
                        <a href="#" class="sidebar-link" data-bs-toggle="collapse" data-bs-target="#settinscollapse" aria-expanded="@php echo in_array(session('sidebar'), $sessionSettingsLinks) ? 'true' : 'false'; @endphp" aria-controls="definitionsCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                <path d="M7.68637 3.00008L10.293 0.393483C10.6835 0.00295344 11.3167 0.00295344 11.7072 0.393483L14.3138 3.00008H18.0001C18.5524 3.00008 19.0001 3.4478 19.0001 4.00008V7.68637L21.6067 10.293C21.9972 10.6835 21.9972 11.3167 21.6067 11.7072L19.0001 14.3138V18.0001C19.0001 18.5524 18.5524 19.0001 18.0001 19.0001H14.3138L11.7072 21.6067C11.3167 21.9972 10.6835 21.9972 10.293 21.6067L7.68637 19.0001H4.00008C3.4478 19.0001 3.00008 18.5524 3.00008 18.0001V14.3138L0.393483 11.7072C0.00295344 11.3167 0.00295344 10.6835 0.393483 10.293L3.00008 7.68637V4.00008C3.00008 3.4478 3.4478 3.00008 4.00008 3.00008H7.68637ZM11.0001 14.0001C12.6569 14.0001 14.0001 12.6569 14.0001 11.0001C14.0001 9.3432 12.6569 8.00008 11.0001 8.00008C9.3432 8.00008 8.00008 9.3432 8.00008 11.0001C8.00008 12.6569 9.3432 14.0001 11.0001 14.0001Z" fill="black"></path>
                            </svg>
                            <span>Ayarlar</span>
                        </a>
                        <div id="settinscollapse" class="collapse @php echo in_array(session('sidebar'), $sessionSettingsLinks) ? 'show' : ''; @endphp sidebar-dropdown">
                            <ul class="sidebar-nav">
                            @if(hasPermission('kullanici-yonet', $permissions))
                                    <li class="sidebar-item {{ (session('sidebar') == 23 ) ? 'active' : '' }}">
                                        <a href="{{url('users')}}" class="sidebar-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.66-10 5v2h20v-2c0-3.34-6.69-5-10-5z" fill="#1A1A1A"/>
                                            </svg>
                                            <span>Kullanıcılar</span>
                                        </a>
                                    </li>
                                @endif


                                @if(hasPermission('rol-yonet', $permissions))

                                <li class="sidebar-item {{ (session('sidebar') == 22 ) ? 'active' : '' }}" id="candidateScholars">
                                    <a href="{{url('roles')}}" class="sidebar-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            <path d="M12 11l3 3 3-3"></path>
                                        </svg>
                                        <span>Kullanıcı Rolleri</span>
                                    </a>
                                </li>

                                @endif

                                @if(hasPermission('yetki-yonet', $permissions))


                                <li class="sidebar-item {{ (session('sidebar') == 21 ) ? 'active' : '' }}" id="candidateScholars">
                                    <a href="{{url('permissions')}}" class="sidebar-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                        </svg>
                                        <span>Kullanıcı Yetkileri</span>
                                    </a>
                                </li>

                                @endif
                                @if(hasPermission('mail-ayarlari-yonet', $permissions))
                                <li class="sidebar-item {{ (session('sidebar') == 31 ) ? 'active' : '' }}" id="candidateScholars">
                                    <a href="{{route('mail.settings')}}" class="sidebar-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="16" rx="2" ry="2"></rect>
                                            <polyline points="3 8 12 14 21 8"></polyline>
                                        </svg>
                                        <span>Mail Ayarları</span>
                                    </a>
                                </li>
                                @endif
                                @if(hasPermission('sms-ayarlari-yonet', $permissions))

                                <li class="sidebar-item {{ (session('sidebar') == 32 ) ? 'active' : '' }}">
                                    <a href="{{route('sms.settings')}}" class="sidebar-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="16" rx="2" ry="2"></rect>
                                            <polyline points="3 8 12 14 21 8"></polyline>
                                        </svg>
                                        <span>Sms Ayarları</span>
                                    </a>
                                </li>
                                @endif
                                @if(hasPermission('ayarlar-versiyonlar', $permissions))
                                    <li class="sidebar-item {{ request()->routeIs('versions.index') ? 'active' : '' }}">
                                        <a href="{{route('versions.index')}}" class="sidebar-link">
                                            <img src="{{asset('public/assets/svg/versions.svg')}}" alt="Versiyonlar" width="24" height="24">
                                            <span class="ms-3">Versiyonlar</span>
                                        </a>
                                    </li>
                                @endif
                                @if(hasPermission('data-import', $permissions))
                                    <li class="sidebar-item {{ request()->routeIs('data-import.*') ? 'active' : '' }}">
                                        <a href="{{route('data-import.index')}}" class="sidebar-link">
                                            <img src="{{asset('public/assets/svg/data-import.svg')}}" alt="Versiyonlar" width="24" height="24">
                                            <span class="ms-3">Data Import</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    <a onclick='toggleSidebar()' href="#" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M2 2H10V16H2V2ZM16 16H12V2H16V16ZM1 0C0.44772 0 0 0.44772 0 1V17C0 17.5523 0.44772 18 1 18H17C17.5523 18 18 17.5523 18 17V1C18 0.44772 17.5523 0 17 0H1ZM4 9L8 5.5V12.5L4 9Z" fill="black"></path>
                        </svg>
                        <span>Küçült</span>
                    </a>
                    <a href="{{route('panel-logout')}}" class="sidebar-link">
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
</div>
