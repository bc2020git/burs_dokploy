@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Bursverenler
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')

    <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <div class="navbar-button-container">
                    <div class="d-flex flex-wrap">
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#bursverenModal">
                            Yeni Bursveren Ekle
                        </button>
                    </div>
                    <div class="navbar-button-container">

                    </div>
                </div>


                <div class="table-responsive mt-3">

                <table class="table table-hover" id="bankTable">
                <thead>
                            <tr>
                                <th>Ad</th>
                                <th>Soyad</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody id="bursverenlerTable">
                            @foreach($bursverenler as $bursveren)
                            <tr>
                                <td>{{ $bursveren->name }}</td>
                                <td>{{ $bursveren->surname }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $bursveren->id }}" data-name="{{ $bursveren->name }}" data-surname="{{ $bursveren->surname }}">Düzenle</button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $bursveren->id }}">Sil</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
</div>

<!-- Modal -->
<div class="modal fade" id="bursverenModal" tabindex="-1" aria-labelledby="bursverenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bursverenModalLabel">Bursveren Ekle/Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body w-100">
                <form id="bursverenForm">
                    @csrf
                    <input type="hidden" id="bursveren_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Ad</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="surname" class="form-label">Soyad</label>
                        <input type="text" class="form-control" id="surname" name="surname" required>
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
@endsection

@section('scripts')
@include('includes.js.sidebar')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://datatables-cdn.com/buttons/1.7.1/css/buttons.dataTables.min.css">
<script src="https://datatables-cdn.com/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://datatables-cdn.com/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script>
$(document).ready(function() {
    // Yeni Bursveren Ekleme ve Güncelleme
    $('#saveBtn').click(function() {
        var id = $('#bursveren_id').val();
        var url = id ? "{{ route('bursverenler.update', ':id') }}".replace(':id', id) : "{{ route('bursverenler.store') }}";
        var method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: $('#bursverenForm').serialize(),
            success: function(response) {
                $('#bursverenModal').modal('hide');
                if (id) {
                    // Güncelleme
                    $('tr[data-id="' + id + '"] td:nth-child(1)').text(response.bursveren.name);
                    $('tr[data-id="' + id + '"] td:nth-child(2)').text(response.bursveren.surname);
                } else {
                    // Yeni Ekleme
                    $('#bursverenlerTable').append(`
                        <tr data-id="${response.bursveren.id}">
                            <td>${response.bursveren.name}</td>
                            <td>${response.bursveren.surname}</td>
                            <td>
                                <button class="btn btn-sm btn-primary edit-btn" data-id="${response.bursveren.id}" data-name="${response.bursveren.name}" data-surname="${response.bursveren.surname}">Düzenle</button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${response.bursveren.id}">Sil</button>
                            </td>
                        </tr>
                    `);
                }
                $('#bursverenForm')[0].reset();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });

    // Düzenleme Modalını Açma
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var surname = $(this).data('surname');

        $('#bursveren_id').val(id);
        $('#name').val(name);
        $('#surname').val(surname);

        $('#bursverenModal').modal('show');
    });

    // Silme İşlemi
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        if (confirm('Bu bursveren kaydını silmek istediğinizden emin misiniz?')) {
            $.ajax({
                url: "{{ route('bursverenler.destroy', ':id') }}".replace(':id', id),
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('tr[data-id="' + id + '"]').remove();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    });

    // Modal Kapandığında Formu Sıfırlama
    $('#bursverenModal').on('hidden.bs.modal', function () {
        $('#bursverenForm')[0].reset();
        $('#bursveren_id').val('');
    });
});
</script>
@endsection

