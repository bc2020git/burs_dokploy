<script src="{{url('public')}}/assets/js/components/dashboard-student.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        const phoneInputFields = document.querySelectorAll(".telinputs");

        phoneInputFields.forEach(function(phoneInputField) {
            const phoneInput = window.intlTelInput(phoneInputField, {
                initialCountry: "tr",
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js",
                formatOnDisplay: true
            });

            // Numara girişi sırasında formatlama
            phoneInputField.addEventListener('keyup', function() {
                const formattedNumber = phoneInput.getNumber(intlTelInputUtils.numberFormat.INTERNATIONAL);
                phoneInputField.value = formattedNumber.replace(/ /g, " ");
            });
        });
    });
</script>
<script src="{{ url('') }}/assets/js/flatpickr.min.js"></script>
<script src="{{ url('') }}/assets/js/tr.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInputs = document.querySelectorAll('.date-input');
        dateInputs.forEach(function(dateInput) {
            flatpickr(dateInput, {
                locale: "tr",
                dateFormat: "Y-m-d",
                altFormat: "d-m-Y",
                altInput: true,
                allowInput: true,
                disableMobile: true,
                monthSelectorType: 'static',
                yearSelectorType: 'static'
            });
        });
    });
</script>
