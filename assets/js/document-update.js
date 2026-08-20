document.addEventListener('DOMContentLoaded', function () {
    var registrationRenewalType = document.getElementById('registrationRenewalType');
    var midtermSection = document.getElementById('midtermSection');
    var endtermSection = document.getElementById('endtermSection');

    registrationRenewalType.addEventListener('change', function () {
        var selectedType = this.value;

        if (selectedType === 'Ara Dönem') {
            midtermSection.classList.remove('d-none');
            endtermSection.classList.add('d-none');
        } else if (selectedType === 'Dönem Sonu') {
            endtermSection.classList.remove('d-none');
            midtermSection.classList.add('d-none');
        } else {
            midtermSection.classList.add('d-none');
            endtermSection.classList.add('d-none');
        }
    });

    function populateDateOptions(section) {
        var days = '<option>Gün seçiniz..</option>';
        for (var i = 1; i <= 31; i++) {
            days += '<option>' + i + '</option>';
        }
        document.getElementById(section + 'StartDay').innerHTML = days;
        document.getElementById(section + 'EndDay').innerHTML = days;

        var months = '<option>Ay seçiniz..</option>';
        var monthNames = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
        for (var i = 0; i < monthNames.length; i++) {
            months += '<option>' + monthNames[i] + '</option>';
        }
        document.getElementById(section + 'StartMonth').innerHTML = months;
        document.getElementById(section + 'EndMonth').innerHTML = months;

        var years = '<option>Yıl seçiniz..</option>';
        var currentYear = new Date().getFullYear();
        for (var i = currentYear; i >= 2000; i--) {
            years += '<option>' + i + '</option>';
        }
        document.getElementById(section + 'StartYear').innerHTML = years;
        document.getElementById(section + 'EndYear').innerHTML = years;
    }

    populateDateOptions('midterm');
    populateDateOptions('endterm');
});
