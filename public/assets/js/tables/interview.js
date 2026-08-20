document.addEventListener("DOMContentLoaded", function () {
    const interviews = [
        {
            profil: "/assets/images/avatar-correct.svg",
            id: "001",
            mulakatDurumu: "Planlandı",
            ad: "Canan",
            soyad: "Tan",
            mulakatZamani: "11/02/2024 - 20.30",
            basvuruPuani: 90,
            egitimTuru: "Ortaokul"
        },
        {
            profil: "/assets/images/avatar-correct.svg",
            id: "002",
            mulakatDurumu: "Teyit Reddedildi",
            ad: "Ernest",
            soyad: "Bradtke",
            mulakatZamani: "11/02/2024 - 20.30",
            basvuruPuani: 20,
            egitimTuru: "Lise"
        },
        {
            profil: "/assets/images/avatar-correct.svg",
            id: "003",
            mulakatDurumu: "Planlama Bekliyor",
            ad: "Diane",
            soyad: "Witting",
            mulakatZamani: "11/02/2024 - 20.30",
            basvuruPuani: 70,
            egitimTuru: "Lisans"
        },
        {
            profil: "/assets/images/avatar-correct.svg",
            id: "004",
            mulakatDurumu: "Planlama Bekliyor",
            ad: "Reginald",
            soyad: "Hirthe",
            mulakatZamani: "11/02/2024 - 20.30",
            basvuruPuani: 10,
            egitimTuru: "Yüksek Lisans"
        },
        {
            profil: "/assets/images/avatar-correct.svg",
            id: "005",
            mulakatDurumu: "Planlama Bekliyor",
            ad: "Derek",
            soyad: "Mayer",
            mulakatZamani: "11/02/2024 - 20.30",
            basvuruPuani: 80,
            egitimTuru: "Lisans"
        },
        {
            profil: "/assets/images/avatar-correct.svg",
            id: "006",
            mulakatDurumu: "Planlama Bekliyor",
            ad: "Anita",
            soyad: "Trantow",
            mulakatZamani: "11/02/2024 - 20.30",
            basvuruPuani: 80,
            egitimTuru: "Lisans"
        },
        {
            profil: "/assets/images/avatar-correct.svg",
            id: "007",
            mulakatDurumu: "Teyit Reddedildi",
            ad: "Tracy",
            soyad: "Ebert",
            mulakatZamani: "11/02/2024 - 20.30",
            basvuruPuani: 10,
            egitimTuru: "Yüksek Lisans"
        },
        {
            profil: "/assets/images/avatar-correct.svg",
            id: "008",
            mulakatDurumu: "Planlandı",
            ad: "Javier",
            soyad: "Connelly",
            mulakatZamani: "11/02/2024 - 20.30",
            basvuruPuani: 90,
            egitimTuru: "Lise"
        },
        {
            profil: "/assets/images/avatar-correct.svg",
            id: "009",
            mulakatDurumu: "Planlandı",
            ad: "Johanna",
            soyad: "Osinski",
            mulakatZamani: "11/02/2024 - 20.30",
            basvuruPuani: 100,
            egitimTuru: "Lise"
        },
        {
            profil: "/assets/images/avatar-correct.svg",
            id: "010",
            mulakatDurumu: "Teyit Reddedildi",
            ad: "Wesley",
            soyad: "Daniel",
            mulakatZamani: "11/02/2024 - 20.30",
            basvuruPuani: 15,
            egitimTuru: "Lisans"
        },
        {
            profil: "/assets/images/avatar-correct.svg",
            id: "011",
            mulakatDurumu: "Planlama Bekliyor",
            ad: "Chelsea",
            soyad: "Friesen",
            mulakatZamani: "11/02/2024 - 20.30",
            basvuruPuani: 80,
            egitimTuru: "Ortaokul"
        },
        {
            profil: "/assets/images/avatar-correct.svg",
            id: "012",
            mulakatDurumu: "Planlama Bekliyor",
            ad: "Anita",
            soyad: "Trantow",
            mulakatZamani: "11/02/2024 - 20.30",
            basvuruPuani: 90,
            egitimTuru: "Ortaokul"
        }
    ];


    const interviewTableBody = document.getElementById("interviewTableBody");

    interviews.forEach((interview) => {
        const row = document.createElement("tr");

        const actionButtonHTML =
        interview.id === "001" || interview.id === "004" || interview.id === "006"
          ? `<button class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M5.76282 17L20 17L20 5L4 5L4 18.3851L5.76282 17ZM6.45455 19L2 22.5L2 4C2 3.44772 2.44772 3 3 3L21 3C21.5523 3 22 3.44772 22 4L22 18C22 18.5523 21.5523 19 21 19L6.45455 19Z" fill="#636363"/>
              </svg></button>
              <button class="btn edit-interview-info-btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
              </svg></button>
              <button class="btn add-note-btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M21 11H11V21H21V11Z" fill="#636363"/>
              <path d="M21 7C21 6.44772 20.5523 6 20 6H17V3C17 2.44772 16.5523 2 16 2H8C7.44772 2 7 2.44772 7 3V6H4C3.44772 6 3 6.44772 3 7V17C3 17.5523 3.44772 18 4 18H7V21C7 21.5523 7.44772 22 8 22H16C16.5523 22 17 21.5523 17 21V18H20C20.5523 18 21 17.5523 21 17V7ZM8 4H16V6H8V4ZM16 20H8V18H11H13H16V20Z" fill="#636363"/>
              </svg></button>`
          : `<button class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M3 3L21 3C21.5523 3 22 3.44772 22 4L22 20C22 20.5523 21.5523 21 21 21L3 21C2.44772 21 2 20.5523 2 20L2 4C2 3.44772 2.44772 3 3 3ZM20 7.23792L12.0718 14.338L4 7.21594L4 19L20 19L20 7.23792ZM4.51146 5L12.0619 11.662L19.501 5L4.51146 5Z" fill="#636363"/>
              </svg></button>
              <button class="btn edit-interview-info-btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
              </svg></button>
              <button class="btn add-note-btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M21 11H11V21H21V11Z" fill="#fff"/>
              <path d="M21 7C21 6.44772 20.5523 6 20 6H17V3C17 2.44772 16.5523 2 16 2H8C7.44772 2 7 2.44772 7 3V6H4C3.44772 6 3 6.44772 3 7V17C3 17.5523 3.44772 18 4 18H7V21C7 21.5523 7.44772 22 8 22H16C16.5523 22 17 21.5523 17 21V18H20C20.5523 18 21 17.5523 21 17V7ZM8 4H16V6H8V4ZM16 20H8V18H11H13H16V20Z" fill="#636363"/>
              </svg></button>`;

        const rowInnerHTML = `
            <td><input type="checkbox" class="checkbox"></td>
            <td><img src="${interview.profil}" width="50"></td>
            <td>${interview.id}</td>
            <td><span class="${getBadgeClass(interview.mulakatDurumu)}">${interview.mulakatDurumu}</span></td>
            <td>${interview.ad}</td>
            <td>${interview.soyad}</td>
            <td>${interview.mulakatZamani}</td>
            <td>${interview.basvuruPuani}</td>
            <td>${interview.egitimTuru}</td>
            <td>${actionButtonHTML}</td>
        `;

        row.innerHTML = rowInnerHTML;
        interviewTableBody.appendChild(row);
    });

    function getBadgeClass(status) {
        switch (status) {
            case 'Planlandı':
                return 'badge bg-success status-box-success';
            case 'Planlama Bekliyor':
                return 'badge bg-warning status-box-warning ';
            case 'Teyit Reddedildi':
                return 'badge bg-danger status-box-danger';
            default:
                return '';
        }
    }

    // DataTable başlat
    $('#interviewTable').DataTable({
        paging: true,
        searching: true,
        ordering: true, 
        info: true,
        lengthChange: true,
        pageLength: 10,
        dom: '<"top"t><"bottom"lfi><"bottom"p><"clear">',
        language: {
          lengthMenu: "Göster _MENU_ kayıt",
          zeroRecords: "Kayıt bulunamadı",
          info: "  _END_ öğeden _TOTAL_ 'i",
          infoEmpty: "Gösterilecek kayıt yok",
          infoFiltered: "(_MAX_ kayıt içinde filtrelendi)",
          search: "Ara:",
          paginate: {
            first: "İlk",
            last: "Son",
            next: `<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                      <path d="M10.5858 12L5.79291 16.7929L7.20712 18.2071L13.4142 12L7.20712 5.79291L5.79291 7.20712L10.5858 12ZM17.5 6.00002V18H15.5V6.00002H17.5Z" fill="#636363"/>
                    </svg>`,
            previous: `<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                      <path d="M14.4142 12L19.2071 7.20712L17.7929 5.79291L11.5858 12L17.7929 18.2071L19.2071 16.7929L14.4142 12ZM7.5 18V6.00001H9.5V18H7.5Z" fill="#636363"/>
                    </svg>`,
          },
        },
        columnDefs: [
          { orderable: false, targets: 1 },
          { orderable: false, targets: '_all' } 
        ],
    });
});

// Satır tıklama olayı
// $('#interviewTable tbody').on('click', 'tr', function () {
//     window.location.href = "/admin/scholarship-application-list-documents.html"; 
// });

document.addEventListener('DOMContentLoaded', function() {
    // Gün, Ay, Yıl, Saat ve Dakika seçeneklerini ekle
    const days = Array.from({length: 31}, (_, i) => i + 1);
    const months = [
        "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran",
        "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"
    ];
    const years = Array.from({length: 5}, (_, i) => new Date().getFullYear() + i);
    const hours = Array.from({length: 24}, (_, i) => i);
    const minutes = Array.from({length: 60}, (_, i) => i);

    const interviewDay = document.getElementById('interviewDay');
    const interviewMonth = document.getElementById('interviewMonth');
    const interviewYear = document.getElementById('interviewYear');
    const interviewHour = document.getElementById('interviewHour');
    const interviewMinute = document.getElementById('interviewMinute');

    const updateInterviewDay = document.getElementById('updateInterviewDay');
    const updateInterviewMonth = document.getElementById('updateInterviewMonth');
    const updateInterviewYear = document.getElementById('updateInterviewYear');
    const updateInterviewHour = document.getElementById('updateInterviewHour');
    const updateInterviewMinute = document.getElementById('updateInterviewMinute');

    days.forEach(day => {
        const option = document.createElement('option');
        option.value = day;
        option.textContent = day;
        interviewDay.appendChild(option);
        updateInterviewDay.appendChild(option.cloneNode(true));
    });

    months.forEach((month, index) => {
        const option = document.createElement('option');
        option.value = index + 1;
        option.textContent = month;
        interviewMonth.appendChild(option);
        updateInterviewMonth.appendChild(option.cloneNode(true));
    });

    years.forEach(year => {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        interviewYear.appendChild(option);
        updateInterviewYear.appendChild(option.cloneNode(true));
    });

    hours.forEach(hour => {
        const option = document.createElement('option');
        option.value = hour;
        option.textContent = hour.toString().padStart(2, '0');
        interviewHour.appendChild(option);
        updateInterviewHour.appendChild(option.cloneNode(true));
    });

    minutes.forEach(minute => {
        const option = document.createElement('option');
        option.value = minute;
        option.textContent = minute.toString().padStart(2, '0');
        interviewMinute.appendChild(option);
        updateInterviewMinute.appendChild(option.cloneNode(true));
    });

    // Form submit işlemi
    const createForm = document.getElementById('createInterviewForm');
    createForm.addEventListener('submit', function(event) {
        event.preventDefault();
        // Formdan veri al ve işle
        const day = interviewDay.value;
        const month = interviewMonth.value;
        const year = interviewYear.value;
        const hour = interviewHour.value;
        const minute = interviewMinute.value;
        const location = document.getElementById('interviewLocation').value;
        const interviewer = document.getElementById('interviewer').value;

        console.log(`Tarih: ${day}/${month}/${year}, Saat: ${hour}:${minute}, Yer: ${location}, Kişi: ${interviewer}`);

        
        const createModal = bootstrap.Modal.getInstance(document.getElementById('createInterviewModal'));
        createModal.hide();
        
        window.location.href = "/admin/interview.html";
    });

    const updateForm = document.getElementById('updateInterviewForm');
    updateForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const day = updateInterviewDay.value;
        const month = updateInterviewMonth.value;
        const year = updateInterviewYear.value;
        const hour = updateInterviewHour.value;
        const minute = updateInterviewMinute.value;
        const location = document.getElementById('updateInterviewLocation').value;
        const interviewer = document.getElementById('updateInterviewer').value;

        console.log(`Tarih: ${day}/${month}/${year}, Saat: ${hour}:${minute}, Yer: ${location}, Kişi: ${interviewer}`);

        
        const updateModal = bootstrap.Modal.getInstance(document.getElementById('updateInterviewModal'));
        updateModal.hide();
        

        window.location.href = "/admin/interview.html";
    });
});


