<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mülakat Katılım</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-2">Mülakat Katılım Durumu</h4>
                    <p class="text-muted mb-4">Lütfen mülakata katılım durumunuzu seçip onaylayın.</p>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('info'))
                        <div class="alert alert-info">{{ session('info') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($alreadyAnswered)
                        <div class="alert alert-secondary mb-0">
                            Katılım durumunuz daha önce kaydedilmiştir.
                        </div>
                    @else
                        <form method="post" action="{{ route('interview.response.store', ['uuid' => $uuid]) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="aday_katilim_durumu" class="form-label">Katılım Durumu</label>
                                <select class="form-select" id="aday_katilim_durumu" name="aday_katilim_durumu" required>
                                    <option value="" selected disabled>Seçiniz...</option>
                                    @foreach($options as $opt)
                                        <option value="{{ $opt }}">{{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Onayla</button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="text-center text-muted small mt-3">
                Bu sayfa güvenli bir tekil bağlantı üzerinden erişilmektedir.
            </div>
        </div>
    </div>
</main>
</body>
</html>

