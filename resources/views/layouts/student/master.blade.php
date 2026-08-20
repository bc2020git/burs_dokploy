<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ url('public/build/images/favicon.ico') }}">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="{{ url('') }}/assets/css/flatpickr.min.css">
    <link rel="stylesheet" href="{{ url('') }}/assets/css/airbnb.min.css">
    <!-- include head css -->
    @include('layouts.student.head-css')
</head>

@yield('body')
        @include('layouts.student.sidebar')
<div class="main">
            @include('layouts.student.topbar')
    @yield('content')
</div>
        @include('layouts.student.footer')


<!-- vendor-scripts -->
@yield('scripts')
<!-- Moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<!-- Flatpickr JS -->
<script src="{{ url('') }}/assets/js/flatpickr.min.js"></script>
<script src="{{ url('') }}/assets/js/tr.min.js"></script>
<script>
    // Flatpickr varsayılan ayarları
    flatpickr.localize(flatpickr.l10ns.tr);
    flatpickr.defaultConfig = {
        dateFormat: "d-m-Y",
        allowInput: true,
        disableMobile: true,
        monthSelectorType: 'static',
        yearSelectorType: 'static',
        parseDate: function(datestr, format) {
            if (!datestr) return null;

            // YYYY-MM-DD formatını parse et
            if (datestr.match(/^\d{4}-\d{2}-\d{2}$/)) {
                const [year, month, day] = datestr.split('-');
                return new Date(year, month - 1, day);
            }

            // DD-MM-YYYY formatını parse et
            if (datestr.match(/^\d{2}-\d{2}-\d{4}$/)) {
                const [day, month, year] = datestr.split('-');
                return new Date(year, month - 1, day);
            }

            return null;
        },
        formatDate: function(date, format) {
            const day = ('0' + date.getDate()).slice(-2);
            const month = ('0' + (date.getMonth() + 1)).slice(-2);
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }
    };
</script>
@include('layouts.student.vendor-scripts')

</body>

</html>
