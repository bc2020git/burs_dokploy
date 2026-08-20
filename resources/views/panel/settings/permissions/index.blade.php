@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
     İzin Yönetimi
@endsection
@section('body')

    <body data-sidebar="colored">
@endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <div class="navbar-button-container">
                    <a href="{{ route('permissions.create') }}">
                    <div class="d-flex flex-wrap">
                        <button type="button" class="btn me-3 text-white" id="newAdd" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Yeni İlçe Ekle"
                                >
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="white" />
                            </svg>
                            Yeni
                        </button>
                    </div>
                    </a>

                    <div class="d-flex flex-wrap justify-content-start mb-2">
                        <a href="{{ route('permission-categories.index') }}">
                            <div class="d-flex flex-wrap">
                                <button type="button" class="btn me-3 text-white" id="newAdd" data-bs-toggle="tooltip"
                                        data-bs-placement="left" title="Yeni İlçe Ekle">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none">
                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="white" />
                                    </svg>
                                    Kategorileri Yönet
                                </button>
                            </div>
                            </a>
                        <button type="button" class="btn btn-outline-primary" id="reload" data-bs-toggle="tooltip" data-bs-placement="left" title="Yenile">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 30 30">
                            <path d="M 15 3 C 12.031398 3 9.3028202 4.0834384 7.2070312 5.875 A 1.0001 1.0001 0 1 0 8.5058594 7.3945312 C 10.25407 5.9000929 12.516602 5 15 5 C 20.19656 5 24.450989 8.9379267 24.951172 14 L 22 14 L 26 20 L 30 14 L 26.949219 14 C 26.437925 7.8516588 21.277839 3 15 3 z M 4 10 L 0 16 L 3.0507812 16 C 3.562075 22.148341 8.7221607 27 15 27 C 17.968602 27 20.69718 25.916562 22.792969 24.125 A 1.0001 1.0001 0 1 0 21.494141 22.605469 C 19.74593 24.099907 17.483398 25 15 25 C 9.80344 25 5.5490109 21.062074 5.0488281 16 L 8 16 L 4 10 z" fill="#4069E5"></path>
                        </svg>
                    </button>
                    </div>
                </div>
    <table id="permissionTable" class=" mt-3 table table-striped">
        <thead>
            <tr>
                <th>İzin Başlığı</th>
                <th>Kategori</th>
                <th>Açıklama</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->category}} </td>
                    <td>{{ $permission->description }}</td>
                    <td>
                        <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-sm btn-warning">Düzenle</a>
                        <form action="{{ route('permissions.destroy', $permission) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Sil</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
            </div>
        </main>
        <!--Modal Alanı-->
        @include('panel.tanimlar.districts.modals')
        @include('includes.js.toastr')

    @endsection
    @section('scripts')
        <!-- App js -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>


        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/scholarmodal.js"></script>
        <script src="{{url('')}}/assets/js/tables/banks.js"></script>

        <script>
            $(document).ready(function() {
                var table = $('#permissionTable').DataTable({
                    stateSave: true
                });
            });
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('updateInterviewDetails').addEventListener('click', function () {
                    $('#updateInterviewModal').modal('hide');
                    $('#interviewDetailsModal').modal('show');
                });

                document.getElementById('concludeInterview').addEventListener('click', function () {
                    $('#updateInterviewModal').modal('hide');
                    $('#concludeInterviewModal').modal('show');
                });



            });
        </script>
<script>
    $(document).ready(function() {
            function islemIcinDiziGonder() {
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
                console.log(selectedIds.length);
                $.ajax({
                    url: '{{route('delete_multiple_bank')}}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: selectedIds,
                    },
                    success: function(response) {
                    location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Hatası:", status, error);
                        console.error("Hata Detayları:", xhr.responseText);
                    }
                });
            }
        $('#pdfButton').on('click', function() {
            table.button('.buttons-pdf').trigger();
        });

        $('#excelButton').on('click', function() {
            table.button('.buttons-excel').trigger();
        });
        $('#waste').on('click', function() {
            islemIcinDiziGonder();
        });

        $('#csvButton').on('click', function() {
            table.button('.buttons-csv').trigger();
        }); $('#reload').on('click', function() {
            location.reload();
        });
    });

    document.querySelectorAll('.edit-interview-info-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Butonun data attribute'lerinden bilgileri alıyoruz
            const id = this.getAttribute('data-id');
            const date = this.getAttribute('data-date');
            const time = this.getAttribute('data-time');
            const platform = this.getAttribute('data-platform');
            const person = this.getAttribute('data-person');
            const score = this.getAttribute('data-score');
            const result = this.getAttribute('data-result');
            const address = this.getAttribute('data-address');

            // Modal içindeki form alanlarını güncelliyoruz
            document.getElementById('mulakatid2').value = id;
            document.getElementById('mulakatid').value = id;
            document.getElementById('editeditinterviewDate').value = date;
            document.getElementById('editinterviewTime').value = time;
            document.getElementById('editinterviewType').value = platform;
            document.getElementById('editinterviewer').value = person;
            document.getElementById('endinterviewScore').value = score;
            document.getElementById('endinterviewResult').value = result;
            document.getElementById('editinterview_address').value = address;

            // Modalı açıyoruz
            new bootstrap.Modal(document.getElementById('updateInterviewModal')).show();
        });
    });
</script>
        <script>
            function sortTable(column, order) {
                const table = document.getElementById("interviewTable");
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
        </script>
        <script !src="">

            $(document).ready(function() {


// Gün, Ay ve Yıl için Seçenekleri Doldur
                const daySelect = document.getElementById("interviewDay");
                const monthSelect = document.getElementById("interviewMonth");
                const yearSelect = document.getElementById("interviewYear");
                const hourSelect = document.getElementById("interviewHour");
                const minuteSelect = document.getElementById("interviewMinute");

                for (let day = 1; day <= 31; day++) {
                    const option = document.createElement("option");
                    option.value = day;
                    option.textContent = day;
                    daySelect.appendChild(option);
                }


                for (let i = 1; i <= 24; i++) {
                    const option = document.createElement("option");
                    option.value = i;
                    option.textContent = i;
                    hourSelect.appendChild(option);
                }
                for (let i = 0; i <= 55;) {
                    const option = document.createElement("option");
                    option.value = i;
                    option.textContent = i;
                    minuteSelect.appendChild(option);
                    i = i + 5;

                }

                const months = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"];
                months.forEach((month, index) => {
                    const option = document.createElement("option");
                    option.value = index+1;
                    option.textContent = month;
                    monthSelect.appendChild(option);
                });

                const currentYear = new Date().getFullYear();
                for (let year = currentYear; year >= 1900; year--) {
                    const option = document.createElement("option");
                    option.value = year;
                    option.textContent = year;
                    yearSelect.appendChild(option);
                }
            });
        </script>
            @include('includes.js.sidebar')

    @endsection

