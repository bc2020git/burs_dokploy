<script>
    // İl-İlçe eşleştirmeleri
    const districtsOfCities = {
        'born_district': 'born_city',
        'registered_district': 'registered_city',
        'mother_district': 'mother_city',
        'residing_district': 'residing_city',
        'father_district': 'father_city',
        'h_school_district': 'h_school_city',
        'p_school_district': 'p_school_city',
        'm_school_district': 'm_school_city',
        'university_district': 'university_city'
    };

    // Üniversite-Şehir eşleştirmeleri
    const universitiesOfCities = {
        'current_university': 'university_city',
        'grade_university': 'university_city'
    };

    // Fakülte-Üniversite eşleştirmeleri
    const facultiesOfUniversities = {
        'university_faculty': 'current_university',
        'grade_faculty': 'grade_university'
    };

    // Bölüm-Fakülte eşleştirmeleri
    const departmentsOfFaculties = {
        'grade_departmant': 'grade_faculty'
    };

                // İlçe yükleme fonksiyonu
    async function loadDistrictsByCity(districtSelectId) {


        const citySelectId = districtsOfCities[districtSelectId];

        if (!citySelectId) {
            return;
        }

        const citySelect = document.getElementById(citySelectId);
        const districtSelect = document.getElementById(districtSelectId);

        if (!citySelect || !districtSelect) {
            return;
        }

        // City select'ten seçili option'u al
        const selectedOption = citySelect.options[citySelect.selectedIndex];

        if (!selectedOption || !selectedOption.value) {
            return;
        }

        // data-id kullan (mevcut sistemle uyumlu)
        const cityId = selectedOption.getAttribute('data-id') || selectedOption.value;
        const selectedDistrict = districtSelect.getAttribute('data-selected');

        try {
            const response = await fetch(`/get-district-by-selected-city-id/${cityId}`);
            const districts = await response.json();


            // Seçenekleri temizle
            districtSelect.innerHTML = '<option value="">Seçiniz</option>';

            // Yeni seçenekleri ekle
            districts.forEach(district => {
                const option = document.createElement('option');
                option.value = district.isim; // Mevcut sistem isim kullanıyor
                option.textContent = district.isim;
                option.setAttribute('data-id', district.id); // data-id ekle

                // Eğer data-selected ile eşleşiyorsa seçili yap
                if (selectedDistrict && district.isim === selectedDistrict) {
                    option.selected = true;
                }

                districtSelect.appendChild(option);
            });

            // data-selected attribute'unu temizle ve data-loaded ekle
            districtSelect.removeAttribute('data-selected');
            districtSelect.setAttribute('data-loaded', 'true');

        } catch (error) {
            console.error('İlçe yüklenirken hata:', error);
        }
    }

    // Üniversite yükleme fonksiyonu
    async function loadUniversitiesByCity(universitySelectId) {
        const citySelectId = universitiesOfCities[universitySelectId];

        if (!citySelectId) return;

        const citySelect = document.getElementById(citySelectId);
        const universitySelect = document.getElementById(universitySelectId);

        if (!citySelect || !universitySelect || !citySelect.value) return;

        const selectedUniversity = universitySelect.getAttribute('data-selected');

        try {
            const response = await fetch(`/get-universities-by-selected-city/${citySelect.value}`);
            const universities = await response.json();

            // Seçenekleri temizle
            universitySelect.innerHTML = '<option value="">Üniversite Seçiniz</option>';

            // Yeni seçenekleri ekle
            universities.forEach(university => {
                const option = document.createElement('option');
                option.value = university.name;
                option.textContent = university.name;
                option.setAttribute('data-id', university.id);

                // Eğer data-selected ile eşleşiyorsa seçili yap
                if (selectedUniversity && university.name === selectedUniversity) {
                    option.selected = true;
                }

                universitySelect.appendChild(option);
            });

            // data-selected attribute'unu temizle ve data-loaded ekle
            universitySelect.removeAttribute('data-selected');
            universitySelect.setAttribute('data-loaded', 'true');

        } catch (error) {
            console.error('Üniversite yüklenirken hata:', error);
        }
    }

    // Fakülte yükleme fonksiyonu
    async function loadFacultiesByUniversity(facultySelectId) {
        const universitySelectId = facultiesOfUniversities[facultySelectId];

        if (!universitySelectId) return;

        const universitySelect = document.getElementById(universitySelectId);
        const facultySelect = document.getElementById(facultySelectId);

        if (!universitySelect || !facultySelect || !universitySelect.value) return;

        const selectedFaculty = facultySelect.getAttribute('data-selected');

        try {
            const response = await fetch(`/get-faculties-by-selected-university/${universitySelect.value}`);
            const faculties = await response.json();

            // Seçenekleri temizle
            facultySelect.innerHTML = '<option value="">Fakülte Seçiniz</option>';

            // Yeni seçenekleri ekle
            faculties.forEach(faculty => {
                const option = document.createElement('option');
                option.value = faculty.name;
                option.textContent = faculty.name;
                option.setAttribute('data-id', faculty.id);
                // Eğer data-selected ile eşleşiyorsa seçili yap
                if (selectedFaculty && faculty.name === selectedFaculty) {
                    option.selected = true;
                }

                facultySelect.appendChild(option);
            });

            // data-selected attribute'unu temizle ve data-loaded ekle
            facultySelect.removeAttribute('data-selected');
            facultySelect.setAttribute('data-loaded', 'true');

        } catch (error) {
            console.error('Fakülte yüklenirken hata:', error);
        }
    }

    // Bölüm yükleme fonksiyonu
    async function loadDepartmentsByFaculty(departmentSelectId) {
        const facultySelectId = departmentsOfFaculties[departmentSelectId];

        if (!facultySelectId) return;

        const facultySelect = document.getElementById(facultySelectId);
        const departmentSelect = document.getElementById(departmentSelectId);

        if (!facultySelect || !departmentSelect || !facultySelect.value) return;

        const selectedDepartment = departmentSelect.getAttribute('data-selected');

        try {
            const response = await fetch(`/get-departments-by-selected-faculty/${facultySelect.value}`);
            const departments = await response.json();

            // Seçenekleri temizle
            departmentSelect.innerHTML = '<option value="">Bölüm Seçiniz</option>';

            // Yeni seçenekleri ekle
            departments.forEach(department => {
                const option = document.createElement('option');
                option.value = department.name;
                option.setAttribute('data-id', department.id);
                option.setAttribute('data-name', department.name);
                option.textContent = department.name;

                // Eğer data-selected ile eşleşiyorsa seçili yap
                if (selectedDepartment && department.name === selectedDepartment) {
                    option.selected = true;
                }

                departmentSelect.appendChild(option);
            });

            // data-selected attribute'unu temizle ve data-loaded ekle
            departmentSelect.removeAttribute('data-selected');
            departmentSelect.setAttribute('data-loaded', 'true');

        } catch (error) {
            console.error('Bölüm yüklenirken hata:', error);
        }
    }

        // Document ready event'inde event delegation ile event listener'ları ekle
    document.addEventListener('DOMContentLoaded', function() {

                // Event delegation kullanarak dinamik select'ler için event listener
        document.addEventListener('click', function(event) {
            const target = event.target;

            // Eğer tıklanan element bir select ise
            if (target.tagName === 'SELECT') {
                const selectId = target.id;

                // İlçe select'leri için kontrol
                if (districtsOfCities.hasOwnProperty(selectId)) {

                    // İlçe select'inin data-loaded attribute'unu kontrol et
                    const isLoaded = target.getAttribute('data-loaded') === 'true';

                    if (!isLoaded) {
                        loadDistrictsByCity(selectId);
                    } else {
                    }
                }

                                // Üniversite select'leri için kontrol
                else if (universitiesOfCities.hasOwnProperty(selectId)) {
                    const isLoaded = target.getAttribute('data-loaded') === 'true';
                    if (!isLoaded) {
                        loadUniversitiesByCity(selectId);
                    } else {
                    }
                }

                // Fakülte select'leri için kontrol
                else if (facultiesOfUniversities.hasOwnProperty(selectId)) {
                    const isLoaded = target.getAttribute('data-loaded') === 'true';
                    if (!isLoaded) {
                        loadFacultiesByUniversity(selectId);
                    } else {
                    }
                }

                // Bölüm select'leri için kontrol
                else if (departmentsOfFaculties.hasOwnProperty(selectId)) {
                    const isLoaded = target.getAttribute('data-loaded') === 'true';
                    if (!isLoaded) {
                        loadDepartmentsByFaculty(selectId);
                    } else {
                    }
                } else {
                }
            }
        });

    });
</script>
