@extends('layouts.master')
@section('title')
    Hazır Mesajlar
@endsection
@section('local-css')
    <!-- RemixIcon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        .template-card {
            border: 1px solid rgba(0,0,0,.075);
            border-radius: .75rem;
            transition: box-shadow .2s ease, transform .1s ease;
            background-color: #fff;
        }
        .template-card:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,.08);
            transform: translateY(-2px);
        }
        .template-card .card-title {
            font-weight: 600;
            color: #283046;
        }
        .template-actions .btn {
            border-radius: .5rem;
        }
        .form-switch .form-check-input {
            width: 3rem;
            height: 1.5rem;
        }
        .form-switch .form-check-input:checked {
            background-color: #0a783d;
            border-color: #0a783d;
        }
        .switch-label {
            user-select: none;
        }
    </style>
@endsection
@section('page-title')
    Hazır Mesajlar
@endsection
@section('body')
    <body data-sidebar="colored">
@endsection
@section('content')
    <main class="main-content px-3 py-4">
        <div class="mt-1">
            <div class="navbar-button-container">
                <div class="d-flex flex-wrap">
                    <a href="{{ route('message-template.create') }}" id="newAdd" class="btn me-3 newAdd">
                        <i class="ri-add-line"></i> Yeni Ekle
                    </a>
                </div>
            </div>

            <div class="mt-3">
                <div class="row g-3">
                    @foreach($messageTemplates as $template)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-0 template-card">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex align-items-start justify-content-between mb-3">
                                        <h4 class="card-title  mb-0">{{ $template->title }}</h4>
                                        <a href="{{ route('message-template.edit', $template->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="ri-edit-line"></i> Düzenle
                                        </a>

                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    @include('includes.js.toastr')
@endsection

@section('scripts')
    <script>
        // Not: Toggle'lar yalnızca görsel amaçlıdır; backend davranışı değiştirilmedi.
        // İleride aktif/pasif durumları bağlanacaksa burada AJAX/Fetch ile güncellenebilir.
        $(document).on('change', '.template-toggle', function() {
            // Yalnızca placeholder davranış
        });
    </script>
@endsection
