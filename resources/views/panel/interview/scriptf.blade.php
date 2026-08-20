<script>
    // sutun cift tiklama ile yonlendirmme
    $(document).on('dblclick', '.redirect-row', function() {
    const candidateId = $(this).data('id');
    const url = "{{ route('panel-mulakat-incele', ['id' => ':id']) }}".replace(':id', candidateId);
    window.location.href = url;
});
</script>
@php
$tableId = 'interviewTable';
$dataurl = route('mulakatlar.data');
$tableColumns = '';
$checkboxInitiliazer = <<<'JS'
    return '<input type="checkbox" name="userCheckbox" class="form-check-input user-checkbox" data-id="' + row.id + '" value="' + row.id + '"  data-firstname="' + row.name + '" data-lastname="' + row.surname + '" data-phone="' + row.tel_no + '" data-email="' + row.email + '">';
JS;
@endphp
@include('panel.includes.scriptf',
[
    'tableId' => $tableId,
    'dataurl' => $dataurl,
    'tableColumns' => $tableColumns,
    'checkboxInitiliazer' => $checkboxInitiliazer
]
)


<script>
    function  checkleng(){
        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
        var length  = selectedCheckboxes.length;
        return length > 0;
    }
    $(document).ready(function() {
        function sendEmails() {
            // Seçili checkbox'ları bul
            const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
            var length  = selectedCheckboxes.length;
            console.log(length);
            // Seçili checkbox'ların e-posta adreslerini topla
            const emailList = Array.from(selectedCheckboxes).map(cb => cb.getAttribute('data-email'));

            // E-posta adreslerini sunucuya gönder
            fetch('/send-emails', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token eklenmesi
                },
                body: JSON.stringify({ emails: emailList })
            })
                .then(response => response.json())
                .then(data => {
                    window.location.href = data.redirectUrl;
                })
                .catch(error => {
                    console.error('Hata:', error);
                });
        }


        $('#createInterview').on('click', function() {

                const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
                var length  = selectedCheckboxes.length;
                if(length > 1){
                    const interviewWarningModal2 = new bootstrap.Modal(document.getElementById('interviewWarningModal2'));
                    interviewWarningModal2.show();

                }
                else{
                    const selectedUserIds = [];


                    // Checkbox'lar arasında işaretli olanları bul
                    const checkboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

                    // Eğer en az bir checkbox işaretli ise ilk elemanın 'data-id' değerini al
                    if (checkboxes.length > 0) {
                        const selectedUserId = checkboxes[0].getAttribute('data-id');

                        // 'mülakatadayid' inputunun value değerini bu ID olarak ayarla
                        const mulakatAdayIdInput = document.querySelector('input[name="mulakatadayid"]');
                        if (mulakatAdayIdInput) {
                            mulakatAdayIdInput.value = selectedUserId;
                        }
                    }
                    const interviewWarningModal = new bootstrap.Modal(document.getElementById('createInterviewModal'));
                    interviewWarningModal.show();
                }


        });




        $('#csvButton').on('click', function() {
            table.button('.buttons-csv').trigger();
        });


    });
</script>
<script>

    function adaySil() {
        // Seçili checkbox'ları bul
        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
        const isChecked = selectedCheckboxes.length;

        // Seçili checkbox'ların e-posta adreslerini topla
        const emailList = Array.from(selectedCheckboxes).map(cb => cb.getAttribute('data-email'));

        // E-posta adreslerini sunucuya gönder
        fetch('/panel/Aday-Toplu-Sil', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token eklenmesi
            },
            body: JSON.stringify({ emails: emailList })
        })
            .then(response => response.json())
            .then(data => {
                window.location.href = data.redirectUrl;
            })
            .catch(error => {
                console.error('Hata:', error);
            });
    }
</script>

<script>

    //TABLO SIRALAMA
    function sortTable(columnIndex, order, type) {
        var table = document.querySelector("table");
        var rows = Array.from(table.rows).slice(1);

        rows.sort(function(a, b) {
            var cellA = a.cells[columnIndex].innerText.trim();
            var cellB = b.cells[columnIndex].innerText.trim();

            if (type === 'numeric') {
                cellA = parseInt(cellA);
                cellB = parseInt(cellB);
            } else if (type === 'status') {
                var statusOrder = {
                    "Onaylandı": 1,
                    "Mülakat Bekliyor": 2,
                    "Red Edildi": 3
                };
                cellA = statusOrder[cellA];
                cellB = statusOrder[cellB];
            } else {
                cellA = cellA.toLowerCase();
                cellB = cellB.toLowerCase();
            }

            if (cellA < cellB) {
                return order === 'asc' ? -1 : 1;
            }
            if (cellA > cellB) {
                return order === 'asc' ? 1 : -1;
            }
            return 0;
        });

        rows.forEach(function(row) {
            table.appendChild(row);
        });
    }
    function selectAll(a){
        const checkboxes = document.querySelectorAll('input[name="userCheckbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = a.checked;
        });

    }
    function islemIcinDiziGonder(islemid) {
        // Tüm checkbox'ları seç
        const selectedUserIds = [];
        const checkboxes = document.querySelectorAll('input[name="interviewCheckbox"]:checked');

        // Her bir işaretli checkbox'ın 'data-id' değerini al
        checkboxes.forEach(checkbox => {
            const userId = checkbox.getAttribute('data-id');
            if (userId) {
                selectedUserIds.push(userId);
            }
        });
        console.log(selectedUserIds.length);
        // İşlem ID'sini belirle
        const islemId = islemid;

        // red durumundaki bilgileri ver
        const redSebebi = document.getElementById('redSebebi') ? document.getElementById('redSebebi').value : null;
        const digerAciklama = document.getElementById('digeraciklama') ? document.getElementById('digeraciklama').value : null;
        // iade durumundaki bilgileri ver
        const iadeSebebi = document.getElementById('iadeSebebi') ? document.getElementById('iadeSebebi').value : null;
        const iadeDigerAciklama = document.getElementById('iadeDigerAciklama') ? document.getElementById('iadeDigerAciklama').value : null;

        $.ajax({
            url: '/Mulakat-Toplu-Islem',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                userIds: selectedUserIds,
            },
            success: function(response) {
                console.log('Veriler gönderildi:', response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }

    $(document).ready(function() {
        $('#confirm').click(function(e) {
            e.preventDefault();

            if (checkleng()){
                const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                confirmModal.show();
            }
            else{
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                interviewWarningModal.show();
            }
        });
    });
    $(document).ready(function() {
        $('#denied').click(function(e) {
            e.preventDefault();

            if (checkleng()){
                const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
                rejectModal.show();
            }
            else{
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                interviewWarningModal.show();
            }
        });
    });
    $(document).ready(function() {
        $('#toReturn').click(function(e) {
            e.preventDefault();

            if (checkleng()){
                const missingDocumentModal = new bootstrap.Modal(document.getElementById('missingDocumentModal'));
                missingDocumentModal.show();
            }
            else{
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                interviewWarningModal.show();
            }
        });
    });
    $(document).ready(function() {
        $('#btndenied').click(function(e) {
            e.preventDefault();
            if (checkleng()){
                islemIcinDiziGonder(0);
            }
            else{
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                interviewWarningModal.show();
            }

        });
    });
    $(document).ready(function() {
        $('#confirmbtnmodel').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(1);
        });
    });$(document).ready(function() {
        $('#confirmbtnmodel').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(1);
        });
    });

    $(document).ready(function() {
        $('#toReturnbtn').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(2);
        });
    });

    $(document).ready(function() {
        $('#waste').click(function(e) {
            e.preventDefault();
            if (checkleng()){
                islemIcinDiziGonder(3);
            }
            else{
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                interviewWarningModal.show();
            }
        });
        $('#reload').click(function(e) {
            location.reload();
        });
    });
    // Topbar'daki butonları bağlama



</script>
@include('panel.includes.word-export',
[
    'tableId' => 'interviewTable'
])
