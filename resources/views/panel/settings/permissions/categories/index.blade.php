@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection

@section('local-css')
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://datatables-cdn.com/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://datatables-cdn.com/buttons/2.4.1/css/buttons.bootstrap5.min.css">
@endsection

@section('page-title')
    Yetki Kategorileri
@endsection

@section('content')
    <main class="main-content px-3 py-4">
        <div class="mt-1">
            <div class="navbar-button-container">
                <div class="d-flex flex-wrap">
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#categoryModal">
                        <i class="bi bi-plus-lg me-1"></i>Yeni Kategori Ekle
                    </button>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-hover" id="categoryTable">
                    <thead>
                        <tr>
                            <th>Kategori Adı</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr data-id="{{ $category->id }}">
                            <td>{{ $category->title }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary edit-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#categoryModal"
                                    data-id="{{ $category->id }}"
                                    data-title="{{ $category->title }}">
                                    <i class="bi bi-pencil"></i> Düzenle
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-id="{{ $category->id }}">
                                    <i class="bi bi-trash"></i> Sil
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Kategori Modal -->
        <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="categoryModalLabel">Kategori Ekle/Düzenle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="categoryForm">
                            @csrf
                            <input type="hidden" id="category_id">
                            <div class="mb-3">
                                <label for="title" class="form-label">Kategori Adı</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        <button type="button" class="btn btn-primary" id="saveBtn">Kaydet</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://datatables-cdn.com/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://datatables-cdn.com/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
    $(document).ready(function() {
        // DataTable başlatma
        var table = $('#categoryTable').DataTable({
            stateSave: true,
            language: {
                url: '//datatables-cdn.com/plug-ins/1.13.6/i18n/tr.json'
            }
        });

        // Yeni Kategori Ekleme ve Güncelleme
        $('#saveBtn').click(function() {
            var id = $('#category_id').val();
            var url = id ? "{{ route('permission-categories.update', ':id') }}".replace(':id', id) : "{{ route('permission-categories.store') }}";
            var method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: $('#categoryForm').serialize(),
                success: function(response) {
                    $('#categoryModal').modal('hide');
                    location.reload(); // Başarılı işlem sonrası sayfayı yenile
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Bir hata oluştu!');
                }
            });
        });

        // Düzenleme Modalını Açma
        $(document).on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            var title = $(this).data('title');

            $('#category_id').val(id);
            $('#title').val(title);
            $('#categoryModalLabel').text('Kategori Düzenle');
        });

        // Silme İşlemi
        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            if (confirm('Bu kategoriyi silmek istediğinizden emin misiniz?')) {
                $.ajax({
                    url: "{{ route('permission-categories.destroy', ':id') }}".replace(':id', id),
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        location.reload(); // Başarılı silme sonrası sayfayı yenile
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Silme işlemi başarısız oldu!');
                    }
                });
            }
        });

        // Modal Kapandığında Formu Sıfırlama
        $('#categoryModal').on('hidden.bs.modal', function () {
            $('#categoryForm')[0].reset();
            $('#category_id').val('');
            $('#categoryModalLabel').text('Yeni Kategori Ekle');
        });
    });
    </script>
@endsection
