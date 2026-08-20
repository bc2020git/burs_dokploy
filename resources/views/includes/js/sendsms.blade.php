<script>
    // SMS butonuna tıklama olayı
$('#sms').on('click', function() {
    if (checkleng()){
        prepareAndSendSms();
    } else {
        const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
        interviewWarningModal.show();
    }
});

function prepareAndSendSms() {
    // Seçili checkbox'ları bul
    const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

    // Seçili kişilerin bilgilerini topla
    const recipients = Array.from(selectedCheckboxes).map(cb => ({
        tel: cb.getAttribute('data-phone'),
        name: cb.getAttribute('data-name'),
        surname: cb.getAttribute('data-surname')
    }));

    // Session'a kaydet ve Coklu-Sms sayfasına yönlendir
    fetch('{{ route("prepare.sms.session") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ alici: recipients })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log(data);
            window.location.href = '{{ route("Coklu-Sms") }}';  // Coklu-Sms route'una yönlendir
        } else {
            toastr.error(data.message || 'Bir hata oluştu');
        }
    })
    .catch(error => {
        console.error('Hata:', error);
        toastr.error('Bir hata oluştu');
    });
}
</script>
