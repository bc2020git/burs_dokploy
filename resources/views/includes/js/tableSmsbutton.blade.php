<script>
function sendSmsByButon(a){
    const tel = $(a).data('tel');
    const name = $(a).data('name');
    const surname = $(a).data('surname');
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
    });
}
function sendMailByButton(a){
    const email = $(a).data('email');
    const name = $(a).data('name');
    const surname = $(a).data('surname');
    var url = "{{ route('getScholarMailForm', ['eposta' => ':email']) }}".replace(':email', email);
    window.location.href = url;
}
</script>
