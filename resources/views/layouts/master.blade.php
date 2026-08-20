<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ url('public/build/images/favicon.ico') }}">

    <!-- include head css -->
    @include('layouts.head-css')
    @yield('local-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        /* DataTables export butonlarını gizle ama işlevsel tut */
        .hidden-export-buttons {
            display: none !important;
        }

        /* DataTables butonlarının genel gizlenmesi */
        .dt-buttons {
            display: none !important;
        }
    </style>
</head>

@yield('body')
        @include('layouts.sidebar')
        <div class="main main-expand">
            @include('layouts.topbar')
            @yield('content')
        </div>
        @include('layouts.footer')


<!-- vendor-scripts -->
@include('layouts.vendor-scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>console.log('🔄 About to load dynamic export handler...');</script>
<script src="{{ url('') }}/public/assets/js/components/dynamic-export-handler.js"></script>
<script>console.log('✅ Dynamic export handler should be loaded now');</script>

@yield('scripts')
<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };
    $('#reload').click(function() {
        location.reload();
    });

</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tüm collapse elementlerini başlat
    document.querySelectorAll('.collapse').forEach(function(collapseElement) {
        new bootstrap.Collapse(collapseElement, {
            toggle: false
        });
    });

    // Tooltip'leri ayarla
    document.querySelectorAll('.sidebar-item').forEach(function(item) {
        var spanText = item.querySelector('span')?.textContent;
        if (spanText) {
            item.setAttribute('title', spanText);
            item.setAttribute('data-bs-placement', 'right');
            new bootstrap.Tooltip(item, {
                delay: { show: 100, hide: 100 },
                container: 'body',
                placement: 'right'
            });
        }
    });

    // Telefon input alanlarında otomatik +90 ekleme
    document.querySelectorAll('.telinputs').forEach(function(input) {
        input.addEventListener('input', function(e) {
            let value = this.value;

            // Eğer input boşsa ve ilk karakter yazılıyorsa
            if (value.length === 1 && !value.startsWith('+')) {
                this.value = '+90' + value;
            }

            // Eğer input boşsa ve +90 ile başlamıyorsa
            if (value.length > 0 && !value.startsWith('+90')) {
                this.value = '+90' + value;
            }
        });

        // Focus olduğunda eğer boşsa +90 ekle
        input.addEventListener('focus', function() {
            if (this.value === '') {
                this.value = '+90';
            }
        });
    });
});
</script>

</body>

</html>

