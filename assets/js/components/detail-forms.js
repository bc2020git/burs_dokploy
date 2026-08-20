const cityToDistricts = {
    "Ankara": ["Çankaya", "Keçiören", "Yenimahalle"],
    "İstanbul": ["Kadıköy", "Beşiktaş", "Üsküdar"],
    "İzmir": ["Bornova", "Konak", "Karşıyaka"],
    "Mersin": ["Akdeniz", "Tarsus", "Mezitli"]
};



// Para bilgisi formatlama
function formatCurrencyInput(inputElement) {
    inputElement.addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');

        if (value === "") {
            e.target.value = "";
            return;
        }

        value = Number(value).toLocaleString('tr-TR');
        e.target.value = value;
    });
}

const gelirInputs = [
    document.getElementById('kalınanYerBilgileriOdenenUcret'),
    document.getElementById('mother_salary'),
    document.getElementById('father_salary'),
    document.getElementById('other_salary'),
    document.getElementById('rent_count'),
    document.getElementById('bursMıktarı'),
    document.getElementById('housing_fee'),
    document.getElementById ('salary')
];






    //tarih seçici
    document.addEventListener('DOMContentLoaded', function () {
        var picker = new Pikaday({
            field: document.getElementById('stepinterviewDate'),
            format: 'DD.MM.YYYY',

            firstDay: 1,
            i18n: {
                previousMonth: 'Önceki Ay',
                nextMonth: 'Sonraki Ay',
                months: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
                weekdays: ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'],
                weekdaysShort: ['Paz', 'Pts', 'Sal', 'Çar', 'Per', 'Cum', 'Cts']
            },
            onSelect: function (date) {
                console.log('Tarih seçildi:', picker.toString());
            }
        });
    });
        // Tarih seçici
        document.addEventListener('DOMContentLoaded', function() {
            var pickerDob = new Pikaday({
                field: document.getElementById('dob'),
                format: 'DD-MM-YYYY',
                yearRange: [1900, new Date().getFullYear()],
                toString(date, format) {
                    const day = (`0${date.getDate()}`).slice(-2);
                    const month = (`0${date.getMonth() + 1}`).slice(-2);
                    const year = date.getFullYear();
                    return `${day}-${month}-${year}`;
                },
                parse(dateString, format) {
                    const parts = dateString.split('-');
                    const day = parseInt(parts[0], 10);
                    const month = parseInt(parts[1], 10) - 1;
                    const year = parseInt(parts[2], 10);
                    return new Date(year, month, day);
                },
                i18n: {
                    previousMonth: 'Önceki Ay',
                    nextMonth: 'Sonraki Ay',
                    months: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
                    weekdays: ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'],
                    weekdaysShort: ['Pz', 'Pt', 'Sa', 'Ça', 'Pe', 'Cu', 'Ct']
                },
                firstDay: 1
            });

            var pickerBDob = new Pikaday({
                field: document.getElementById('b_dob'),
                format: 'DD-MM-YYYY',
                yearRange: [1900, new Date().getFullYear()],
                toString(date, format) {
                    const day = (`0${date.getDate()}`).slice(-2);
                    const month = (`0${date.getMonth() + 1}`).slice(-2);
                    const year = date.getFullYear();
                    return `${day}-${month}-${year}`;
                },
                parse(dateString, format) {
                    const parts = dateString.split('-');
                    const day = parseInt(parts[0], 10);
                    const month = parseInt(parts[1], 10) - 1;
                    const year = parseInt(parts[2], 10);
                    return new Date(year, month, day);
                },
                i18n: {
                    previousMonth: 'Önceki Ay',
                    nextMonth: 'Sonraki Ay',
                    months: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
                    weekdays: ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'],
                    weekdaysShort: ['Pz', 'Pt', 'Sa', 'Ça', 'Pe', 'Cu', 'Ct']
                },
                firstDay: 1
            });

            document.getElementById('dobIcon').addEventListener('click', function() {
                pickerDob.show();
            });

            document.getElementById('b_dobIcon').addEventListener('click', function() {
                pickerBDob.show();
            });
        });
