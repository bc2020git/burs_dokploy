<script>
    $('#sms').on('click', function() {
        const tel = $(this).data('tel');
        const name = $(this).data('name');
        const surname = $(this).data('surname');

        $.ajax({
            url: '{{ route("send.single.sms") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                tel: tel,
                name: name,
                surname: surname
            },
            success: function(response) {
                if(response.redirectUrl) {
                    window.location.href = response.redirectUrl;
                }
            },
            error: function(xhr, status, error) {
                console.error('Hata:', error);
                toastr.error('SMS gönderimi sırasında bir hata oluştu');
            }
        });
    });

</script>
