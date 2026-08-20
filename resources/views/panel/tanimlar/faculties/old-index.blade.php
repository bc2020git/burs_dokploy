@extends('layouts.master')
@section('title')
Fakülteler - Yönetici Paneli
@endsection
@section('page-title')
    Fakülte Yönetimi
@endsection

@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class="mt-1">
                <div class="navbar-button-container">
                    <div class="d-flex flex-wrap">
                        <button type="button" class="btn me-3 text-white" id="newAdd" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Yeni Bölüm Ekle"
                                onclick="window.location.href='{{route('add-faculties')}}'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="white" />
                            </svg>
                            Yeni
                        </button>
                    </div>
                    <div class="navbar-button-container">
                        <button type="button" class="btn" id="bursCheck">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                                <path
                                    d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16658C11.8423 9.16658 13.334 7.67492 13.334 5.83325C13.334 3.99158 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99158 6.66732 5.83325C6.66732 7.67492 8.15898 9.16658 10.0007 9.16658ZM14.8281 16.5951L17.7743 13.6488L18.9528 14.8273L14.8281 18.9521L11.8818 16.0058L13.0603 14.8273L14.8281 16.5951Z"
                                    fill="#fff" />
                            </svg>
                            Burs veriliyor mu?
                        </button>
                        <x-export-buttons table-id="facultiesTable" model="faculty" />
                        <button type="button" class="btn btn-outline-primary me-3" id="search" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Ara">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                                <path
                                    d="M15.0252 13.8477L18.5941 17.4166L17.4156 18.5951L13.8467 15.0262C12.5634 16.0528 10.936 16.667 9.16602 16.667C5.02602 16.667 1.66602 13.307 1.66602 9.16699C1.66602 5.02699 5.02602 1.66699 9.16602 1.66699C13.306 1.66699 16.666 5.02699 16.666 9.16699C16.666 10.937 16.0518 12.5644 15.0252 13.8477ZM13.3533 13.2293C14.3723 12.1792 14.9993 10.7467 14.9993 9.16699C14.9993 5.94408 12.3889 3.33366 9.16602 3.33366C5.9431 3.33366 3.33268 5.94408 3.33268 9.16699C3.33268 12.3899 5.9431 15.0003 9.16602 15.0003C10.7457 15.0003 12.1782 14.3732 13.2283 13.3542L13.3533 13.2293Z"
                                    fill="#4069E5" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary me-3" id="filter" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Filtrele">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                                <path
                                    d="M11.6673 11.6667V16.6667L8.33398 18.3333V11.6667L3.33398 4.16667V2.5H16.6673V4.16667L11.6673 11.6667ZM5.33707 4.16667L10.0007 11.162L14.6642 4.16667H5.33707Z"
                                    fill="#4069E5" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary me-3" id="waste" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Sil">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M14.168 5.00033H18.3346V6.66699H16.668V17.5003C16.668 17.9606 16.2949 18.3337 15.8346 18.3337H4.16797C3.70774 18.3337 3.33464 17.9606 3.33464 17.5003V6.66699H1.66797V5.00033H5.83464V2.50033C5.83464 2.04009 6.20774 1.66699 6.66797 1.66699H13.3346C13.7949 1.66699 14.168 2.04009 14.168 2.50033V5.00033ZM15.0013 6.66699H5.0013V16.667H15.0013V6.66699ZM7.5013 9.16699H9.16797V14.167H7.5013V9.16699ZM10.8346 9.16699H12.5013V14.167H10.8346V9.16699ZM7.5013 3.33366V5.00033H12.5013V3.33366H7.5013Z"
                                    fill="#4069E5" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary me-3" id="column" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Sütunlar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M16.6667 2.5C17.1269 2.5 17.5 2.8731 17.5 3.33333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5H16.6667ZM9.16667 10.8333H4.16667V15.8333H9.16667V10.8333ZM10.8333 15.8333H15.8333V4.16667H10.8333V15.8333ZM9.16667 4.16667H4.16667V9.16667H9.16667V4.16667Z"
                                    fill="#4069E5" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary me-3" id="reload" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Yenile">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20"
                                 viewBox="0 0 30 30">
                                <path
                                    d="M 15 3 C 12.031398 3 9.3028202 4.0834384 7.2070312 5.875 A 1.0001 1.0001 0 1 0 8.5058594 7.3945312 C 10.25407 5.9000929 12.516602 5 15 5 C 20.19656 5 24.450989 8.9379267 24.951172 14 L 22 14 L 26 20 L 30 14 L 26.949219 14 C 26.437925 7.8516588 21.277839 3 15 3 z M 4 10 L 0 16 L 3.0507812 16 C 3.562075 22.148341 8.7221607 27 15 27 C 17.968602 27 20.69718 25.916562 22.792969 24.125 A 1.0001 1.0001 0 1 0 21.494141 22.605469 C 19.74593 24.099907 17.483398 25 15 25 C 9.80344 25 5.5490109 21.062074 5.0488281 16 L 8 16 L 4 10 z"
                                    fill="#4069E5"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-hover" id="facultiesTable">
                        @include('panel.includes.datatable-head')

                        <tbody id="facultiesTableBody">

                        </tbody>
                    </table>
                </div>
            </div>
        </main>        <!--Modal Alanı-->
        @include('panel.tanimlar.univercities.modals')
    @endsection
    @section('scripts')
        <!-- App js -->


        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://datatables-cdn.com/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://datatables-cdn.com/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://datatables-cdn.com/buttons/2.4.2/js/buttons.html5.min.js"></script>
        <script src="https://datatables-cdn.com/buttons/2.4.2/js/buttons.print.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @include('panel.tanimlar.faculties.scriptf')
        @include('panel.includes.filtreleme')


        <script>
            var tables = $("#facultyTable").DataTable({
                paging: true,
                searching: true,
                ordering: false,
                info: true,
                lengthChange: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tümü"]], // Kayıt gösterme seçenekleri
                dom: '<"top"<"left"l><"right"f>>rt<"bottom"ip><"clear">B', // DOM yapısını düzenle
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Aday Bursiyerler',
                        exportOptions: {
                            columns: ':visible' // Yalnızca görünür sütunları dahil et
                        }
                    },{extend: 'pdfHtml5',title: 'Aday Bursiyerler',exportOptions: {
                            columns: ':visible' // Yalnızca görünür sütunları dahil et
                        }}
                ],
                language: {
                    lengthMenu: "Göster _MENU_ kayıt",
                    zeroRecords: "Kayıt bulunamadı",
                    info: "  _END_ öğeden _TOTAL_ 'i",
                    infoEmpty: "Gösterilecek kayıt yok",
                    infoFiltered: "(_MAX_ kayıt içinde filtrelendi)",
                    search: "Ara:",
                    paginate: {
                        first: "İlk",
                        last: "Son",
                        next: `<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                    <path d="M10.5858 12L5.79291 16.7929L7.20712 18.2071L13.4142 12L7.20712 5.79291L5.79291 7.20712L10.5858 12ZM17.5 6.00002V18H15.5V6.00002H17.5Z" fill="#636363"/>
                    </svg>`,
                        previous: `<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                    <path d="M14.4142 12L19.2071 7.20712L17.7929 5.79291L11.5858 12L17.7929 18.2071L19.2071 16.7929L14.4142 12ZM7.5 18V6.00001H9.5V18H7.5Z" fill="#636363"/>
                    </svg>`,
                    },
                },
                columnDefs: [
                    { orderable: false, targets: 0 }, // Checkbox sütunu için sıralama devre dışı bırakıldı (ilk sütun)
                    { orderable: true, targets: '_all' } // Diğer tüm sütunlar sıralanabilir olarak ayarlandı
                ],
            });
            // Her sayfa için özel satır oluşturma fonksiyonu
            function generateTableRow(item) {
                return `
                    <tr class="redirect-row" data-id="${item.id}">
                        <td>

                            <input
                                data-id="${item.id || ''}"
                                value="${item.id || ''}"
                                type="checkbox"
                                name="userCheckbox"
                                class="checkbox"
                            >
                        </td>
                        <td>${item.univercity_id}</td>
                        <td>${item.univercity.name}</td>
                        <td>${getType(item.univercity.type)}</td>
                        <td>${item.univercity.city}</td>
                        <td>${item.code}</td>
                        <td>${item.name}</td>
                        <td>${getBursDurum(item.bv_onlisans)}</td>
                        <td>${getBursDurum(item.bv_lisans)}</td>
                        <td>${getBursDurum(item.bv_yukseklisans)}</td>
                        <td>${getBursDurum(item.bv_doktora)}</td>
                        <td>${generateActions(item.id)}</td>
                    </tr>
                `;
            }

            // Yardımcı fonksiyonlar
            function getType(item) {
                if(item == 'Vakıf') return '<span class="status-box-vakif">Vakıf</span>';
                if(item == 'Devlet') return '<span class="status-box-devlet">Devlet</span>';
                return '';
            }
            function getBursDurum(item) {
                if(item == 1) return '<span class="status-box-success">Evet</span>';
                if(item == 0) return '<span class="status-box-danger">Hayır</span>';
                return '';
            }

            function generateActions(id) {
                return `
                    <button class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M3 3L21 3C21.5523 3 22 3.44772 22 4L22 20C22 20.5523 21.5523 21 21 21L3 21C2.44772 21 2 20.5523 2 20L2 4C2 3.44772 2.44772 3 3 3ZM20 7.23792L12.0718 14.338L4 7.21594L4 19L20 19L20 7.23792ZM4.51146 5L12.0619 11.662L19.501 5L4.51146 5Z" fill="#636363"/>
                        </svg>
                    </button>
                    <a href="/panel/Ilce-Detay/${id}">
                        <button class="btn edit-student-info-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
                            </svg>
                        </button>
                    </a>
                `;
            }


            </script>

        <script>
            function islemIcinDiziGonder(islemid) {
                // Tüm checkbox'ları seç
                const selectedIds = [];
                const checkboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

                // Her bir işaretli checkbox'ın 'data-id' değerini al
                checkboxes.forEach(checkbox => {
                    const userId = checkbox.getAttribute('data-id');
                    if (userId) {
                        selectedIds.push(userId);
                    }
                });
                const islemId = islemid;
                const bv_onlisans = document.querySelector('input[id="onlisans"]').checked ? 1 : 0;
                const bv_lisans = document.querySelector('input[id="lisans"]').checked ? 1 : 0;
                const bv_yukseklisans = document.querySelector('input[id="yukseklisans"]').checked ? 1 : 0;
                const bv_doktora = document.querySelector('input[id="doktora"]').checked ? 1 : 0;
                const bursDurumElement = document.getElementById('bursVeriliyorMuDurum');
                const bursDurumValue = bursDurumElement.options[bursDurumElement.selectedIndex].value;
                $.ajax({
                    url: '{{route('delete_multiple_faculties')}}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: selectedIds,
                        islemId: islemId,
                        bv_onlisans: bv_onlisans,
                        bv_lisans: bv_lisans,
                        bv_yukseklisans: bv_yukseklisans,
                        bv_doktora: bv_doktora,
                        bursDurum: bursDurumValue,
                    },
                    success: function(response) {
                        if (response.success && response.file_url) {
                            // Dosya indirme işlemi için gizli bir link oluştur
                            var link = document.createElement('a');
                            link.href = response.file_url;
                            link.download = response.file_name;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        } else if (response.success) {
                            // Diğer başarılı işlemler için
                        location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Hatası:", status, error);
                        console.error("Hata Detayları:", xhr.responseText);
                    }
                });
            }
            $('#waste').on('click', function() {
                const checkboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

                if (checkboxes.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Uyarı',
                        text: 'Lütfen silinecek fakülteleri seçin!',
                        confirmButtonText: 'Tamam'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Emin misiniz?',
                    text: 'Fakülte ve fakülteye bağlı bölümler de silinecektir',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Evet, Sil!',
                    cancelButtonText: 'İptal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        islemIcinDiziGonder(1);
                    }
                });
            });
            $('#confirmBursDurum').on('click', function() {
                islemIcinDiziGonder(2);
            });
            $('#topluIndirBtn').on('click', function() {
                islemIcinDiziGonder(3);
            });

            function sortTable(column, order) {
                const table = document.getElementById("universityTable");
                const tbody = table.tBodies[0];
                const rows = Array.from(tbody.querySelectorAll("tr"));

                rows.sort((a, b) => {
                    const cellA = a.cells[column].innerText.toLowerCase();
                    const cellB = b.cells[column].innerText.toLowerCase();

                    if (order === 'asc') {
                        return cellA > cellB ? 1 : cellA < cellB ? -1 : 0;
                    } else {
                        return cellA < cellB ? 1 : cellA > cellB ? -1 : 0;
                    }
                });

                rows.forEach(row => tbody.appendChild(row));
            }

            document.getElementById('bursCheck').addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.checkbox');
                let isChecked = false;

                checkboxes.forEach(function(checkbox) {
                    if (checkbox !== document.getElementById('masterCheckbox') && checkbox.checked) {
                        isChecked = true;
                    }
                });

                if (isChecked) {
                    const bursModal = new bootstrap.Modal(document.getElementById('bursModal'));
                    bursModal.show();
                } else {
                    const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                    interviewWarningModal.show();
                }
            });
        </script>

            @include('includes.js.sidebar')

@endsection
