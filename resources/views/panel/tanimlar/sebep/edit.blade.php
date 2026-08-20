@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Sebep Düzenle
@endsection
@section('local-css')
<style>
    select>option:checked {
        background-color: var(--blue-600);
        color: ghostwhite;
    }
</style>
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <!--Duzenleme form baslangici-->
                <form action="{{route('sebep.update')}}" method="post"> @csrf
                    <div class="navbar-button-container">



                    <!-- Form Butonlari -->
                    <div class="d-flex flex-wrap">

                    </div>
                    <!-- Form Butonlari -->
                </div>
                <div class="mt-3 p-3 border">
                    <div class="card-title"><h3>Sebep Bilgileri</h3></div>
                    <div class="card-body">
                        <div class="row">
                            <input name="id" id="id" type="hidden" class="form-control" value="{{$item->id}}">

                            <div class="col-sm-12 col-md-6 form-group">
                                <label for="forms" class="custom-label">Sebep Adı</label>
                                <input type="text" name="text" id="text" class="form-control" value="{{$item->text}}">
                            </div>
                            <div class="col-sm-12 col-md-6 form-group">
                                <label for="type">Sebep Tipi</label>
                                <select name="type" id="type" class="form-select">
                                    <option value="İade" @if($item->type == 'İade') selected @endif>İade</option>
                                    <option value="Red" @if($item->type == 'Red') selected @endif>Red</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                    <div class="transfer-modal-footer d-flex justify-content-end g-3 ">
                        <button type="submit" class="btn btn-outline-primary me-3">Kaydet</button>
                        <a href="{{route('form-sorulari')}}"><button type="button" class="btn btn-outline-danger me-3" >Vazgeç</button></a>
                    </div>
                </form>
                <!--Duzenleme form sonu-->


            </div>

        </main>

        @include('includes.js.toastr')

    @endsection
    @section('scripts')
        <!-- App js -->


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

        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/modal.js"></script>
        <script src="{{url('')}}/assets/js/tables/candidate.js"></script>
        <script>
            document.getElementById('type').addEventListener('change', function() {
                var selectedValue = this.value;
                document.querySelectorAll('.optiondiv > input').forEach(function(inputField) {
                    inputField.value = '';
                });
                selectDivAction();

                if (selectedValue === 'select') {
                    parentDivShow('selectdiv');
                } if (selectedValue === 'checkbox') {
                    parentDivShow('checkboxdiv');
                }
            });
            function parentDivShow(divname){
                var optionDiv = document.getElementById(divname);
                optionDiv.classList.remove('d-none');
            }
            function selectDivAction(){
                document.querySelectorAll('#optiondiv > div').forEach(function(div) {
                    div.classList.add('d-none');
                });

            }
            document.getElementById('addOptionButton').addEventListener('click', function() {
                var candidateTableBody = document.getElementById('candidateTableBody');
                var rowCount = candidateTableBody.rows.length+1;

                // Yeni satır oluştur
                var newRow = document.createElement('tr');

                // Seçenek inputu için hücre oluştur
                var optionCell = document.createElement('td');
                var optionInput = document.createElement('input');
                optionInput.type = 'text';
                optionInput.name = 'option[' + rowCount + ']';
                optionInput.className = 'form-control';
                optionInput.placeholder = 'Seçenek Giriniz';
                optionCell.appendChild(optionInput);

                // Puan inputu için hücre oluştur
                var pointCell = document.createElement('td');
                var pointInput = document.createElement('input');
                pointInput.type = 'number';
                pointInput.name = 'point[' + rowCount + ']';
                pointInput.className = 'form-control';
                pointInput.value = 0;
                pointInput.placeholder = 'Puan Giriniz';
                pointCell.appendChild(pointInput);

                // Silme butonu için hücre oluştur
                var actionCell = document.createElement('td');
                var removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-danger btn-sm';
                removeButton.textContent = 'Sil';
                removeButton.addEventListener('click', function() {
                    newRow.remove();
                });
                actionCell.appendChild(removeButton);

                // Hücreleri satıra ekle
                newRow.appendChild(optionCell);
                newRow.appendChild(pointCell);
                newRow.appendChild(actionCell);

                // Satırı tabloya ekle
                candidateTableBody.appendChild(newRow);
            });

            // Var olan silme butonları için olay dinleyici
            document.querySelectorAll('.remove-option').forEach(function(button) {
                button.addEventListener('click', function() {
                    this.closest('tr').remove();
                });
            });



        </script>

    @include('includes.js.sidebar')

@endsection
