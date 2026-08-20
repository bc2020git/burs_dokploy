document.addEventListener("DOMContentLoaded", function () {

    
    // Gün, Ay ve Yıl için Seçenekleri Doldur
    const daySelect = document.getElementById("day");
    const monthSelect = document.getElementById("month");
    const yearSelect = document.getElementById("year");

    for (let day = 1; day <= 31; day++) {
        const option = document.createElement("option");
        option.value = day;
        option.textContent = day;
        daySelect.appendChild(option);
    }

    const months = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"];
    months.forEach((month, index) => {
        const option = document.createElement("option");
        option.value = index + 1;
        option.textContent = month;
        monthSelect.appendChild(option);
    });

    const currentYear = new Date().getFullYear();
    for (let year = currentYear; year >= 1900; year--) {
        const option = document.createElement("option");
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    }

    // Şehir ve İlçe Seçeneklerini Doldur
    const cities = ["İstanbul", "Ankara", "İzmir", "Bursa", "Antalya"];
    const districts = {
        "İstanbul": ["Kadıköy", "Beşiktaş", "Bakırköy"],
        "Ankara": ["Çankaya", "Keçiören", "Yenimahalle"],
        "İzmir": ["Konak", "Bornova", "Karşıyaka"],
        "Bursa": ["Osmangazi", "Yıldırım", "Nilüfer"],
        "Antalya": ["Muratpaşa", "Kepez", "Konyaaltı"]
    };

    const birthCitySelect = document.getElementById("birthCity");
    const birthDistrictSelect = document.getElementById("birthDistrict");
    const registeredCitySelect = document.getElementById("registeredCity");
    const registeredDistrictSelect = document.getElementById("registeredDistrict");

    cities.forEach(city => {
        const option = document.createElement("option");
        option.value = city;
        option.textContent = city;
        birthCitySelect.appendChild(option);
        registeredCitySelect.appendChild(option);
    });

    function updateDistricts(citySelect, districtSelect) {
        const selectedCity = citySelect.value;
        districtSelect.innerHTML = '<option value="">Seçiniz...</option>';
        if (selectedCity && districts[selectedCity]) {
            districts[selectedCity].forEach(district => {
                const option = document.createElement("option");
                option.value = district;
                option.textContent = district;
                districtSelect.appendChild(option);
            });
        }
    }

    birthCitySelect.addEventListener("change", function () {
        updateDistricts(birthCitySelect, birthDistrictSelect);
    });

    registeredCitySelect.addEventListener("change", function () {
        updateDistricts(registeredCitySelect, registeredDistrictSelect);
    });

    // Cinsiyet Seçeneklerini Doldur
    const genderSelect = document.getElementById("gender");
    const genders = ["Erkek", "Kadın", "Diğer"];
    genders.forEach(gender => {
        const option = document.createElement("option");
        option.value = gender;
        option.textContent = gender;
        genderSelect.appendChild(option);
    });

    // Medeni Durum Seçeneklerini Doldur
    const maritalStatusSelect = document.getElementById("maritalStatus");
    const maritalStatuses = ["Bekar", "Evli", "Boşanmış", "Dul"];
    maritalStatuses.forEach(status => {
        const option = document.createElement("option");
        option.value = status;
        option.textContent = status;
        maritalStatusSelect.appendChild(option);
    });

    // Okul Tipi ve Nakil Seçeneklerini Doldur
    const egitimBilgileriOkulTipiSelect = document.getElementById("egitimBilgileriOkulTipi");
    const egitimBilgileriNakilDurumuSelect = document.getElementById("egitimBilgileriNakilDurumu");

    const egitimBilgileriOkulTipis = ["İlkokul", "Ortaokul", "Lise", "Üniversite"];
    egitimBilgileriOkulTipis.forEach(type => {
        const option = document.createElement("option");
        option.value = type;
        option.textContent = type;
        egitimBilgileriOkulTipiSelect.appendChild(option);
    });

    const egitimBilgileriNakilDurumuOptions = ["Evet", "Hayır"];
    egitimBilgileriNakilDurumuOptions.forEach(optionText => {
        const option = document.createElement("option");
        option.value = optionText;
        option.textContent = optionText;
        egitimBilgileriNakilDurumuSelect.appendChild(option);
    });

    // Şehir ve Sınıf Seçeneklerini Doldur
    const egitimBilgileriOkulSehirSelect = document.getElementById("egitimBilgileriOkulSehir");
    const egitimBilgileriSınıfSelect = document.getElementById("egitimBilgileriSınıf");

    cities.forEach(city => {
        const option = document.createElement("option");
        option.value = city;
        option.textContent = city;
        egitimBilgileriOkulSehirSelect.appendChild(option);
    });

    const egitimBilgileriSınıfs = ["1. Sınıf", "2. Sınıf", "3. Sınıf", "4. Sınıf", "5. Sınıf", "6. Sınıf", "7. Sınıf", "8. Sınıf", "9. Sınıf", "10. Sınıf", "11. Sınıf", "12. Sınıf"];
    egitimBilgileriSınıfs.forEach(egitimBilgileriSınıf => {
        const option = document.createElement("option");
        option.value = egitimBilgileriSınıf;
        option.textContent = egitimBilgileriSınıf;
        egitimBilgileriSınıfSelect.appendChild(option);
    });

    // Barınma Türü seçenekleri
    const kalınanYerBilgileriBarınmaTürüSelect = document.getElementById("kalınanYerBilgileriBarınmaTürü");
    const kalınanYerBilgileriBarınmaTürüs = ["Ev", "Yurt", "Aile Yanı", "Arkadaş Yanı", "Kira"];
    kalınanYerBilgileriBarınmaTürüs.forEach(type => {
        const option = document.createElement("option");
        option.value = type;
        option.textContent = type;
        kalınanYerBilgileriBarınmaTürüSelect.appendChild(option);
    });

    // Kaldığı İl ve İlçe seçenekleri
    const kalınanYerBilgileriKaldigiIlSelect = document.getElementById("kalınanYerBilgileriKaldigiIl");
    const kalınanYerBilgileriKaldigiIlceSelect = document.getElementById("kalınanYerBilgileriKaldigiIlce");

    cities.forEach(city => {
        const option = document.createElement("option");
        option.value = city;
        option.textContent = city;
        kalınanYerBilgileriKaldigiIlSelect.appendChild(option);
    });

    kalınanYerBilgileriKaldigiIlSelect.addEventListener("change", function () {
        const selectedCity = kalınanYerBilgileriKaldigiIlSelect.value;
        kalınanYerBilgileriKaldigiIlceSelect.innerHTML = '<option value="">Seçiniz...</option>';
        if (selectedCity && districts[selectedCity]) {
            districts[selectedCity].forEach(district => {
                const option = document.createElement("option");
                option.value = district;
                option.textContent = district;
                kalınanYerBilgileriKaldigiIlceSelect.appendChild(option);
            });
        }
    });

    // Anne ve Baba Şehir ve İlçe seçenekleri
    const aileAdresBilgileriAnneIlSelect = document.getElementById("aileAdresBilgileriAnneIl");
    const aileAdresBilgileriAnneIlceSelect = document.getElementById("aileAdresBilgileriAnneIlce");
    const aileAdresBilgileriBabaIlSelect = document.getElementById("aileAdresBilgileriBabaIl");
    const aileAdresBilgileriBabaIlceSelect = document.getElementById("aileAdresBilgileriBabaIlce");

    cities.forEach(city => {
        const option = document.createElement("option");
        option.value = city;
        option.textContent = city;
        aileAdresBilgileriAnneIlSelect.appendChild(option);
        aileAdresBilgileriBabaIlSelect.appendChild(option);
    });

    aileAdresBilgileriAnneIlSelect.addEventListener("change", function () {
        updateDistricts(aileAdresBilgileriAnneIlSelect, aileAdresBilgileriAnneIlceSelect);
    });

    aileAdresBilgileriBabaIlSelect.addEventListener("change", function () {
        updateDistricts(aileAdresBilgileriBabaIlSelect, aileAdresBilgileriBabaIlceSelect);
    });
});

