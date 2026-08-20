<link rel="stylesheet" href="{{url('')}}/assets/css/components/dashboard.css">
<link rel="stylesheet" href="{{url('')}}/assets/css/styles.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://datatables-cdn.com/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/themes/airbnb.min.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://datatables-cdn.com/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://datatables-cdn.com/buttons/2.1.0/js/buttons.colVis.min.js"></script>
<link rel="stylesheet" href="https://datatables-cdn.com/buttons/2.1.0/css/buttons.dataTables.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@yield('local-css')

<style>
    /* Flatpickr Stil Düzenlemeleri */
    .flatpickr-wrapper {
        width: 100%;
        display: block;
    }

    .flatpickr-wrapper .flatpickr-input {
        width: 100%;
    }

    .flatpickr-wrapper .form-control {
        display: block;
        width: 100%;
    }

    .flatpickr-calendar {
        width: 100%;
        max-width: 307.875px;
    }

    /* Date Input Label Düzenlemesi */
    .date-input-container {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .date-input-container label {
        display: block;
        width: 100%;
        margin-bottom: 0.5rem;
    }

    .date-input-container .flatpickr-input {
        width: 100%;
    }

    /* Flatpickr alternatif input düzenlemesi */
    .flatpickr-input.form-control {
        background-color: #fff;
    }

    .flatpickr-input.form-control.input {
        display: none;
    }

    .step-container .step-item:hover .step-number {
    border: 2px solid #007bff;
}

.step-item:hover .step-text {
    color: #007bff;
}
</style>
