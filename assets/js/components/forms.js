document.addEventListener('DOMContentLoaded', function () {
    // İş durumu detayları gösterme
    const employmentStatus = document.getElementById("employment-status");
    const employmentDetails = document.getElementById("employment-details");

    if (employmentStatus) {
        employmentStatus.addEventListener("change", function () {
            if (this.value === "full-time" || this.value === "part-time" || this.value === "intern") {
                employmentDetails.classList.remove("hidden");
            } else {
                employmentDetails.classList.add("hidden");
            }
        });
    }

    // // Şehir ve ilçe seçimi için doldurma
    // const citiesAndDistricts = {
    //     istanbul: ["Kadıköy", "Beşiktaş", "Üsküdar", "Şişli", "Sarıyer"],
    //     ankara: ["Çankaya", "Keçiören", "Yenimahalle", "Mamak", "Sincan"],
    //     izmir: ["Konak", "Bornova", "Karşıyaka", "Buca", "Gaziemir"],
    //     bursa: ["Osmangazi", "Yıldırım", "Nilüfer", "İnegöl", "Gemlik"],
    //     antalya: ["Muratpaşa", "Kepez", "Konyaaltı", "Alanya", "Manavgat"],
    // };

    // function populateCities() {
    //     const citySelects = document.querySelectorAll("#birthCity, #registeredCity, #egitimBilgileriOkulSehir, #kalınanYerBilgileriKaldigiIl, #aileAdresBilgileriAnneIl, #aileAdresBilgileriBabaIl");

    //     citySelects.forEach(select => {
    //         for (const city in citiesAndDistricts) {
    //             const option = document.createElement("option");
    //             option.value = city;
    //             option.textContent = capitalizeFirstLetter(city);
    //             select.appendChild(option);
    //         }
    //     });
    // }

    // function updateDistricts(citySelectId, districtSelectId) {
    //     const citySelect = document.getElementById(citySelectId);
    //     const districtSelect = document.getElementById(districtSelectId);
    //     const selectedCity = citySelect.value;

    //     districtSelect.innerHTML = "<option value=''>Seçiniz...</option>";
    //     if (selectedCity && citiesAndDistricts[selectedCity]) {
    //         citiesAndDistricts[selectedCity].forEach(district => {
    //             const option = document.createElement("option");
    //             option.value = district.toLowerCase();
    //             option.textContent = district;
    //             districtSelect.appendChild(option);
    //         });
    //     }
    // }

    // function capitalizeFirstLetter(string) {
    //     return string.charAt(0).toUpperCase() + string.slice(1);
    // }

    // populateCities();

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
        document.getElementById('gelirBeyaniBabanınGeliri'),
        document.getElementById('gelirBeyaniAnneninGeliri'),
        document.getElementById('gelirBeyaniDigerKisiGelir'),
        document.getElementById('kira'),
        document.getElementById('bursMıktarı'),
        document.getElementById ('salary')
    ];

    gelirInputs.forEach(input => {
        if (input) {
            formatCurrencyInput(input);
        }
    });

    // IBAN kontrolü
    const ibanInput = document.getElementById('iban');

    if (ibanInput) {
        ibanInput.addEventListener('focus', function () {
            if (!ibanInput.value.startsWith('TR')) {
                ibanInput.value = 'TR';
            }
        });

        ibanInput.addEventListener('input', function (e) {
            let value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');

            if (!value.startsWith('TR')) {
                value = 'TR' + value.substring(2);
            }

            if (value.length > 26) {
                value = value.substring(0, 26);
            }

            e.target.value = value;
        });

        ibanInput.addEventListener('blur', function () {
            if (!isValidIBAN(ibanInput.value)) {
                alert("Geçersiz IBAN numarası!");
                ibanInput.focus();
            }
        });
    }

    function isValidIBAN(iban) {
        const ibanRegex = /^TR\d{24}$/;
        return ibanRegex.test(iban);
    }

    // Tarih seçici
    new Pikaday({
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
            const day = parseInt(parts[2], 10);
            const month = parseInt(parts[1], 10) - 1;
            const year = parseInt(parts[0], 10);
            return new Date(year, month, day);
        },
        i18n: {
            previousMonth: 'Önceki Ay',
            nextMonth: 'Sonraki Ay',
            months: ['Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'],
            weekdays: ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'],
            weekdaysShort: ['Pz', 'Pt', 'Sa', 'Ça', 'Pe', 'Cu', 'Ct']
        },
        firstDay: 1,
    });
    document.getElementById('dobIcon').addEventListener('click', function() {
        pickerDob.show();  
    });

    // Telefon numarası formatlama
    function setupIntlTelInput(selector) {
        const inputField = document.querySelector(selector);
        const phoneInput = window.intlTelInput(inputField, {
            initialCountry: "tr",
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js",
            formatOnDisplay: true
        });

        inputField.addEventListener('keyup', function () {
            const formattedNumber = phoneInput.getNumber(intlTelInputUtils.numberFormat.INTERNATIONAL);
            inputField.value = formattedNumber.replace(/ /g, " ");
        });
    }

    setupIntlTelInput("#aileAdresBilgileriAileCepTel");
    setupIntlTelInput("#aileAdresBilgileriAileEvTel");
    setupIntlTelInput("#acilDurumTelefon");

    // Burs ekleme işlemi
    const form = document.getElementById('addBursForm');
    const tableBody = document.querySelector('table tbody');

    if (form && tableBody) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const kurumAdi = document.getElementById('kurumAdi').value.trim();
            const kurumTuru = document.getElementById('kurumTuru').value;
            const bursMiktari = document.getElementById('bursMıktarı').value.trim();

            if (!kurumAdi || !kurumTuru || !bursMiktari || isNaN(bursMiktari) || parseFloat(bursMiktari) <= 0) {
                alert("Lütfen geçerli burs bilgileri giriniz.");
                return;
            }

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${kurumAdi}</td>
                <td>${kurumTuru}</td>
                <td>${parseFloat(bursMiktari).toFixed(2)} TL</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-button">Sil</button>
                </td>
            `;

            tableBody.appendChild(row);

            form.reset();

            const modal = bootstrap.Modal.getInstance(document.getElementById('bursEkleModal'));
            modal.hide();
        });

        tableBody.addEventListener('click', function (event) {
            if (event.target.classList.contains('delete-button')) {
                const row = event.target.closest('tr');
                row.remove();
            }
        });
    }

    // Kardeş ekleme işlemi
    const siblingForm = document.getElementById('addSiblingForm');
    const siblingTableBody = document.querySelector('table tbody');
    let siblingCount = 0;

    siblingForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const name = document.getElementById('kardesAdi').value.trim();
        const surname = document.getElementById('kardesSoyadi').value.trim();
        const age = document.getElementById('kardesYasi').value.trim();
        const education = document.getElementById('kardesOgrenimDurumu').value;
        const maritalStatus = document.getElementById('kardesMedeniDurumu').value;
        const job = document.getElementById('kardesMeslegi').value.trim();

        const row = document.createElement('tr');

        siblingCount++;
        row.innerHTML = `
            <td>${siblingCount}</td>
            <td>${name}</td>
            <td>${surname}</td>
            <td>${age}</td>
            <td>${education}</td>
            <td>${maritalStatus}</td>
            <td>${job}</td>
            <td>
                <button class="btn edit-member-info-btn" type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#kardesDuzenleModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z" fill="#4069E5" />
                    </svg>
                </button>
                <button class="btn" data-bs-toggle="modal" data-bs-target="#kardesDeleteConfirmModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M14.1641 5.00008H18.3307V6.66675H16.6641V17.5001C16.6641 17.9603 16.291 18.3334 15.8307 18.3334H4.16406C3.70383 18.3334 3.33073 17.9603 3.33073 17.5001V6.66675H1.66406V5.00008H5.83073V2.50008C5.83073 2.03985 6.20383 1.66675 6.66406 1.66675H13.3307C13.791 1.66675 14.1641 2.03985 14.1641 2.50008V5.00008ZM7.4974 9.16675V14.1667H9.16406V9.16675H7.4974ZM10.8307 9.16675V14.1667H12.4974V9.16675H10.8307ZM7.4974 3.33341V5.00008H12.4974V3.33341H7.4974Z" fill="#F03000" />
                    </svg>
                </button>
            </td>
        `;

        siblingTableBody.appendChild(row);

        siblingForm.reset();

        const modal = bootstrap.Modal.getInstance(document.getElementById('kardesEkleModal'));
        modal.hide();
    });

    siblingTableBody.addEventListener('click', function (event) {
        if (event.target.classList.contains('delete-button')) {
            const row = event.target.closest('tr');
            row.remove();
        }
    });
});
