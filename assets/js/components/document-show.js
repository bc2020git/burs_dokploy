const documents = [
    { name: 'Öğrenci Belgesi', icon: 'filetype-pdf.svg' },
    { name: 'Adli Sicil Kaydı', icon: 'filetype-pdf.svg' },
    { name: 'Vuk. Nufüs Kayıt Örn.', icon: 'filetype-pdf.svg' },
    { name: 'Anne Gelir Belgesi', icon: 'filetype-pdf.svg' },
    { name: 'Baba Gelir Belgesi', icon: 'filetype-pdf.svg' },
    { name: 'Ayd. Met./Açık Rıza Form Taah.', icon: 'filetype-pdf.svg' },
    { name: 'Kimlik Belgesi (Ön ve Arka)', icon: 'filetype-jpg.svg' },
    { name: 'Banka Hesap Bilgisi', icon: 'filetype-pdf.svg' },
    { name: 'Fotoğraf', icon: 'filetype-jpg.svg' },
    { name: 'Transkript', icon: 'filetype-pdf.svg' },
    { name: 'Aile İkamet Adresi ve Diğer adres Bil.', icon: 'filetype-pdf.svg' },
    { name: 'Karne', icon: 'filetype-pdf.svg' },
    { name: 'Diğer', icon: 'filetype-pdf.svg' },
];

function createUploadCard(document) {
    return `
        <div class="col-md-3 col-sm-6 mb-3 d-flex align-items-stretch">
            <div class="upload-card">
                <div class="documents-title-drag-drop">
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                fill="#1A1A1A" />
                        </svg> ${document.name}
                    </p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A" />
                    </svg>
                </div>
                <div class="file-uploaded-document d-flex justify-content-around" data-bs-toggle="modal" data-bs-target="#documentModal">
                    <img src="../assets/images/${document.icon}" alt="${document.name}" style="width: 25px; height: 25px;">
                    <div class="file-preview" id="deleteButton">
                        <div class="icon-container">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                                <rect width="12" height="12" rx="6" fill="#00875A" />
                                <path d="M4.56484 5.90345C4.2359 5.57452 3.70259 5.57452 3.37365 5.90345C3.04472 6.23239 3.04472 6.7657 3.37365 7.09463L5.05824 8.77922C5.38717 9.10815 5.92048 9.10815 6.24942 8.77922L9.61858 5.41005C9.94752 5.08111 9.94752 4.5478 9.61858 4.21887C9.28965 3.88993 8.75634 3.88993 8.4274 4.21887L5.65383 6.99245L4.56484 5.90345Z"
                                    fill="white" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="file-info mt-2">
                    <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                    <p>Max Size: 5 MB, 1 Dosya</p>
                </div>
                <div class="delete-icon" data-bs-toggle="modal" data-bs-target="#documentDeleteConfirmModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                        <path d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V1.875C4.375 1.52983 4.65482 1.25 5 1.25H10C10.3452 1.25 10.625 1.52983 10.625 1.875V3.75ZM5.625 6.875V10.625H6.875V6.875H5.625ZM8.125 6.875V10.625H9.375V6.875H8.125ZM5.625 2.5V3.75H9.375V2.5H5.625Z"
                            fill="#F03000" />
                    </svg>
                </div>
            </div>
        </div>
    `;
}


const uploadContainer = document.getElementById('uploadContainer');

documents.forEach(doc => {
    uploadContainer.innerHTML += createUploadCard(doc);
});
