@extends('layouts.master')
@section('title')
    SMS Gönder
@endsection
@section('page-title')
    SMS Gönder
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="message" class="form-label">SMS Metni</label>
                            <textarea class="form-control" id="message" rows="4" maxlength="160"></textarea>
                            <small class="text-muted">Maksimum 160 karakter</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">SMS Bakiyesi: <span class="text-primary">{{ $smsBalance ?? '0' }}</span></label>
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" id="sendSmsBtn">
                                SMS Gönder
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.getElementById('sendSmsBtn').addEventListener('click', function() {
    const message = document.getElementById('message').value;
    if (!message) {
        alert('Lütfen bir mesaj giriniz.');
        return;
    }

    // URL'den member_ids parametresini al
    const urlParams = new URLSearchParams(window.location.search);
    const memberIds = urlParams.get('member_ids');

    if (!memberIds) {
        alert('Seçili üye bulunamadı.');
        return;
    }

    // AJAX isteği
    $.ajax({
        url: '{{ route("send.bulk.sms") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            message: message,
            member_ids: memberIds
        },
        success: function(response) {
            if (response.success) {
                alert('SMS başarıyla gönderildi.');
                window.location.href = '{{ route("panel") }}';
            } else {
                alert('SMS gönderilirken bir hata oluştu: ' + response.message);
            }
        },
        error: function(xhr) {
            alert('Bir hata oluştu: ' + xhr.responseText);
        }
    });
});
</script>
@endsection
