@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Mesaj Şablonu Düzenle
@endsection
@section('local-css')
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <!-- RemixIcon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        .parameter-item {
            margin-bottom: 10px;
        }
        .note-editor.note-frame {
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            width: 100% !important;
        }
        .note-editable {
            background-color: white;
        }
        .parameter-add-btn {
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 8px;
            cursor: pointer;
            font-size: 12px;
        }
        .parameter-add-btn:hover {
            background: #218838;
        }
    </style>
@endsection
@section('body')
    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class="mt-1">
                <div class="row">
                    <!-- Sol taraf - 75% -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h5>Mesaj Şablonu Bilgileri</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('message-template.update', $item->id) }}" method="POST" id="editForm">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $item->id }}">

                                    <div class="mb-3">
                                        <label for="title" class="form-label">Başlık</label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ $item->title }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="slug" class="form-label">Slug</label>
                                        <input type="text" class="form-control" id="slug" name="slug" value="{{ $item->slug }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="content" class="form-label">Mesaj İçeriği</label>
                                        <textarea name="content" id="summernote" class="form-control">{{ $item->content }}</textarea>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('message-template.index') }}" class="btn btn-secondary">
                                            <i class="ri-arrow-left-line"></i> Geri Dön
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-save-line"></i> Güncelle
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                        <div class="d-none">
                            <span id="reload"></span>
                        </div>
                    <!-- Sağ taraf - 25% -->
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h6>Parametreler</h6>
                            </div>
                            <div class="card-body">
                                <div id="parameters-container">
                                    @php
                                        $parameters = is_string($item->parameters) ? json_decode($item->parameters, true) : $item->parameters;
                                        $parameters = $parameters ?: [];
                                    @endphp
                                    @if($parameters && count($parameters) > 0)
                                        @foreach($parameters as $parameter)
                                            <div class="mb-2 parameter-item">
                                                <div class="input-group">
                                                    <input type="text" class="form-control parameter-input" value="{{ $parameter }}" placeholder="Parametre adı">
                                                    <button type="button" class="btn btn-outline-success btn-sm parameter-add-btn" title="Editöre ekle">
                                                        <i class="ri-add-line"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm remove-parameter">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="mb-2 parameter-item">
                                            <div class="input-group">
                                                <input type="text" class="form-control parameter-input" placeholder="Parametre adı">
                                                <button type="button" class="btn btn-outline-success btn-sm parameter-add-btn" title="Editöre ekle">
                                                    <i class="ri-add-line"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-danger btn-sm remove-parameter">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <button type="button" class="btn btn-sm btn-outline-primary w-100" id="add-parameter">
                                    <i class="ri-add-line"></i> Parametre Ekle
                                </button>

                                <input type="hidden" id="parameters" name="parameters" form="editForm">

                                <div class="mt-3">
                                    <small class="text-muted">
                                        <strong>Kullanım:</strong><br>
                                        Mesaj içeriğinde parametreleri _parametre_ şeklinde kullanabilirsiniz.<br><br>
                                        <strong>+ Butonu:</strong> Parametreyi editörde imleç konumuna ekler.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        @include('includes.js.toastr')
    @endsection

    @section('scripts')
        <!-- jQuery ve Bootstrap 4 JS (Summernote için gerekli) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Summernote JS -->
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-tr-TR.min.js"></script>

        <!-- Summernote Initialize -->
        <script>
            $(document).ready(function() {
                // Summernote yüklenip yüklenmediğini kontrol et
                if (typeof $.fn.summernote === 'undefined') {
                    console.error('Summernote yüklenemedi!');
                    return;
                }

                $('#summernote').summernote({
                    height: 300,
                    lang: 'tr-TR',
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                    callbacks: {
                        onInit: function() {
                            console.log('Summernote başarıyla başlatıldı');
                        },
                        onImageUpload: function(files) {
                            return false;
                        }
                    }
                });

                // Container genişliğini ayarla
                $('.note-editing-area').css('width', '100%');
                $('.note-editor').css('width', '100%');

                // Başlık değiştiğinde slug otomatik oluştur
                $('#title').on('input', function() {
                    const title = $(this).val();
                    const slug = generateSlug(title);
                    $('#slug').val(slug);
                });

                // Parametre ekleme
                $('#add-parameter').click(function() {
                    addParameter();
                });

                // Parametre silme
                $(document).on('click', '.remove-parameter', function() {
                    $(this).closest('.parameter-item').remove();
                    updateParametersInput();
                });

                // Parametre editöre ekleme
                $(document).on('click', '.parameter-add-btn', function() {
                    const parameterInput = $(this).siblings('.parameter-input');
                    const parameterName = parameterInput.val().trim();

                    if (parameterName) {
                        // Summernote editörüne parametreyi ekle
                        const parameterText = '_' + parameterName + '_';
                        $('#summernote').summernote('insertText', parameterText);

                        // Editöre odaklan
                        $('#summernote').summernote('focus');
                    } else {
                        alert('Lütfen önce parametre adını girin.');
                        parameterInput.focus();
                    }
                });

                // Parametre inputlarına event listener
                $(document).on('input', '.parameter-input', function() {
                    updateParametersInput();
                });

                // Form submit işlemi
                $('#message-template-form').submit(function(e) {
                    // Summernote içeriği otomatik olarak textarea'ya aktarılır
                    console.log('Form submitted with content:', $('#summernote').val());

                    // Parametreleri güncelle
                    updateParametersInput();
                });

                // İlk yüklemede parametreleri güncelle
                updateParametersInput();
            });

            function addParameter() {
                const container = document.getElementById('parameters-container');
                const div = document.createElement('div');
                div.className = 'mb-2 parameter-item';
                div.innerHTML = `
                    <div class="input-group">
                        <input type="text" class="form-control parameter-input" placeholder="Parametre adı">
                        <button type="button" class="btn btn-outline-success btn-sm parameter-add-btn" title="Editöre ekle">
                            <i class="ri-add-line"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm remove-parameter">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                `;
                container.appendChild(div);
                updateParametersInput();
            }

            function updateParametersInput() {
                const container = document.getElementById('parameters-container');
                const inputs = container.querySelectorAll('.parameter-input');
                const parameters = [];

                inputs.forEach(input => {
                    if (input.value.trim()) {
                        parameters.push(input.value.trim());
                    }
                });

                document.getElementById('parameters').value = JSON.stringify(parameters);
            }

            function generateSlug(text) {
                return text
                    .toLowerCase()
                    .replace(/ğ/g, 'g')
                    .replace(/ü/g, 'u')
                    .replace(/ş/g, 's')
                    .replace(/ı/g, 'i')
                    .replace(/ö/g, 'o')
                    .replace(/ç/g, 'c')
                    .replace(/[^a-z0-9 -]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim('-');
            }
        </script>

        @include('includes.js.sidebar')
    @endsection
