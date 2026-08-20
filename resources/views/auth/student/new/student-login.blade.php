<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aday Bursiyer Girişi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{url('/assets/css/loginPages/login-respon.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="header-logo">
    <img src="{{url('')}}/assets/images/logo-sm.svg" alt="digiCRM">
</div>
<div class="container-fluid p-0">
    <div class="left-side"></div>
    <div class="right-side">
        <div class="form-container">
            <p class="title">Burs Başvuru Portalı</p>
            <p class="subtitle">Aday Bursiyer Girişi</p>
            <div class="chat-private-fill mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M3 0C2.20435 0 1.44129 0.31607 0.87868 0.87868C0.31607 1.44129 0 2.20435 0 3V6C0 6.55228 0.447715 7 1 7C1.55228 7 2 6.55228 2 6V3C2 2.73478 2.10536 2.48043 2.29289 2.29289C2.48043 2.10536 2.73478 2 3 2H6C6.55228 2 7 1.55228 7 1C7 0.447715 6.55228 0 6 0H3Z" fill="#2D3648"/>
                    <path d="M14 0C13.4477 0 13 0.447715 13 1C13 1.55228 13.4477 2 14 2H17C17.2652 2 17.5196 2.10536 17.7071 2.29289C17.8946 2.48043 18 2.73478 18 3V6C18 6.55228 18.4477 7 19 7C19.5523 7 20 6.55228 20 6V3C20 2.20435 19.6839 1.44129 19.1213 0.87868C18.5587 0.316071 17.7957 0 17 0H14Z" fill="#2D3648"/>
                    <path d="M2 14C2 13.4477 1.55228 13 1 13C0.447715 13 0 13.4477 0 14V17C0 17.7957 0.316071 18.5587 0.87868 19.1213C1.44129 19.6839 2.20435 20 3 20H6C6.55228 20 7 19.5523 7 19C7 18.4477 6.55228 18 6 18H3C2.73478 18 2.48043 17.8946 2.29289 17.7071C2.10536 17.5196 2 17.2652 2 17V14Z" fill="#2D3648"/>
                    <path d="M20 14C20 13.4477 19.5523 13 19 13C18.4477 13 18 13.4477 18 14V17C18 17.2652 17.8946 17.5196 17.7071 17.7071C17.5196 17.8946 17.2652 18 17 18H14C13.4477 18 13 18.4477 13 19C13 19.5523 13.4477 20 14 20H17C17.7957 20 18.5587 19.6839 19.1213 19.1213C19.6839 18.5587 20 17.7957 20 17V14Z" fill="#2D3648"/>
                </svg>
            </div>
            <form method="POST" action="{{ route('aday.login') }}" id="loginForm" onsubmit="return validateForm(event)">
                @csrf
                @foreach($kategoriler->soru as $soru )
                    @if($soru->type=='text')
                    <div class="form-group">
                        <label for="{{$soru->db_key}}" class="form-label">{{$soru->title}}</label>
                        <input
                            @if($soru->required=='Zorunlu') required name="{{$soru->db_key}}" @endif
                            type="text"
                            class="form-control"
                            id="{{$soru->db_key}}"
                            @if($soru->db_key!='tc_no')

                            pattern="[A-Za-zğüşıöçĞÜŞİÖÇ\s]+"
                            oninput="this.value = this.value.replace(/[^A-Za-zğüşıöçĞÜŞİÖÇ\s]/g, '')"
                            title="Sadece alfabetik karakterler girebilirsiniz"
                            @else
                            pattern="[0-9]{11}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            title="Sadece sayısal karakterler girebilirsiniz" maxlength="11"
                            @endif
                            >
                    </div>
                @endif
                @if($soru->type=='tel')
                    <div class="form-group">
                        <label for="phone" class="form-label">{{$soru->title}}</label>
                        <br>
                        <input @if($soru->required=='Zorunlu') required @endif name="{{$soru->db_key}}"  type="tel" placeholder="5554443322" style="margin-left: 55px !important;" class="form-control"
                         id="phone">
                    </div>
                @endif
                @if($soru->type=='number')
                    <div class="col-md-6 mb-3 ">
                        <label for="{{$soru->db_key}}" class="form-label">{{$soru->title}}</label>
                        <input type="number" @if($soru->required=='Zorunlu') required @endif @if($soru->disabled=='disabled') disabled @endif   class="form-control" id="{{$soru->db_key}}">
                    </div>
                @endif
                @if($soru->type=='email')
                            <div class="form-group">
                        <label for="{{$soru->db_key}}" class="form-label">{{$soru->title}}</label>
                        <input @if($soru->required=='Zorunlu') name="{{$soru->db_key}}" required @endif type="email"   class="form-control" id="{{$soru->db_key}}">
                    </div>
                @endif
                @if($soru->type=='date')
                    <div class="col-md-6 mb-3 ">
                        <label for="{{$soru->db_key}}">{{$soru->title}}</label>
                        <input name="{{$soru->db_key}}" @if($soru->required=='Zorunlu') required @endif type="date" class="form-control"   id="{{$soru->db_key}}" placeholder="YYYY-AA-GG">
                    </div>
                @endif
                @if($soru->type=='select')
                    <div class="col-md-6 mb-3">
                        <label for="{{ $soru->db_key }}">{{ $soru->title }}</label>
                        <select data-dataset="{{$soru->dataset}}" class="form-select" name="{{$soru->db_key}}" @if($soru->required=='Zorunlu') required @endif id="{{ $soru->db_key }}" >
                            @if(json_decode($soru->options))
                                @foreach(json_decode($soru->options) as $option)
                                    <option  value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                @endif
                @if($soru->type=='checkbox')

                    @php $options = json_decode($soru->options,true) @endphp
                    <div class='col-md-6'>
                        <div class="form-check">
                            <input
                            class="form-check-input"  name="{{$soru->db_key}}"
                                @if($soru->required=='Zorunlu') required @endif
                                type="checkbox" id="{{$soru->db_key}}"
                            >
                            <p class="form-check-label mt-1 " for="confirmation1" @if($options[1]=='modal') data-bs-toggle="modal" data-bs-target="#{{$soru->db_key}}Modal" @endif ">
                            <u>@if($options[1]=='link')
                                    <a target="_blank" href="{{ $options[2] }}">{{ $soru->title }}</a> @else {{ $soru->title }} @endif</u>
                            </p>
                        </div>
                    </div>
                    @if($options[1]=='modal')
                        <div class="modal modal-lg fade" id="{{$soru->db_key}}Modal" tabindex="-1" role="dialog" aria-labelledby="{{$soru->db_key}}modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="text-center">
                                        <h5 class="modal-title" id="{{$soru->db_key}}Label">
                                            <div class=" text-center wp-block-group__inner-container">
                                                {{$options[3]}}
                                            </div>
                                        </h5>
                                    </div>
                                    <div class="modal-body text-center p-5">
                                        {{$options[4]}}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif @endforeach
                <input type="submit" class="submit submit-btn" value="Giriş Yap">
            </form>
        </div>
    </div>
        @include('includes.js.toastr')






</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Toastr ayarları
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };
    </script>

<script>
    let phoneInput;
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInputField = document.querySelector("#phone");
        phoneInput = window.intlTelInput(phoneInputField, {
            initialCountry: "tr",
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js",
            formatOnDisplay: true
        });

        // Numara girişi sırasında formatlama
        phoneInputField.addEventListener('keyup', function() {
            const formattedNumber = phoneInput.getNumber(intlTelInputUtils.numberFormat.INTERNATIONAL);
            // Son karakter kontrolü - eğer rakam değilse kaldır
            let currentValue = formattedNumber.replace(/ /g, " ");
            let lastChar = currentValue.charAt(currentValue.length - 1);
            if (lastChar && isNaN(parseInt(lastChar))) {
                currentValue = currentValue.slice(0, -1);
            }
            phoneInputField.value = currentValue;
        });
    });

    function validateForm(event) {
        event.preventDefault();
        const phoneNumber = phoneInput.getNumber();

        // Türkiye telefon numarası formatı kontrolü (+905554444433)
        const phoneRegex = /^\+90[5][0-9]{9}$/;
        if (!phoneRegex.test(phoneNumber)) {
            Swal.fire({
                title: 'Hata!',
                text: 'Lütfen geçerli bir telefon numarası giriniz. Format: +90 555 555 55 55',
                icon: 'error',
                confirmButtonText: 'Tamam'
            });
            return false;
        }

        document.getElementById('loginForm').submit();
    }


        function validateTcKimlikNo(tc) {
            if (tc.length !== 11 || isNaN(tc) || tc[0] === '0') {
                return false;
            }

            const digits = tc.split('').map(Number);
            const sumOdd = digits[0] + digits[2] + digits[4] + digits[6] + digits[8];
            const sumEven = digits[1] + digits[3] + digits[5] + digits[7];
            const total = digits.slice(0, 10).reduce((acc, val) => acc + val, 0);

            return (
                (sumOdd * 7 - sumEven) % 10 === digits[9] &&
                total % 10 === digits[10]
            );
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
</script>
<script>
    function validateTCNo(tc_no) {
        // TC Kimlik Numarası 11 haneli olmalı
        if (tc_no.length !== 11) return false;

        // İlk karakter 0 olamaz
        if (tc_no[0] === '0') return false;

        // Tüm karakterler rakam olmalı
        if (!/^\d+$/.test(tc_no)) return false;

        // Algoritma kontrolü
        let digits = tc_no.split('').map(Number); // Her bir karakteri sayıya dönüştür

        // İlk 10 hanenin toplamını ve tek haneli toplamını hesapla
        let sumOdd = digits.slice(0, 9).filter((_, index) => index % 2 === 0).reduce((acc, val) => acc + val, 0);
        let sumEven = digits.slice(0, 9).filter((_, index) => index % 2 !== 0).reduce((acc, val) => acc + val, 0);

        // 10. hane hesaplama
        let tenthDigit = (sumOdd * 7 - sumEven) % 10;
        if (tenthDigit !== digits[9]) return false;

        // 11. hane hesaplama
        let eleventhDigit = (sumOdd + sumEven + digits[9]) % 10;
        if (eleventhDigit !== digits[10]) return false;

        return true;
    }

    // Focusout eventi
    document.getElementById('tc_no').addEventListener('focusout', function() {
        const tc_no = this.value;

        if (!validateTCNo(tc_no)) {
            Swal.fire({
                title: 'Hata!',
                text: 'Lütfen geçerli bir TC Kimlik Numarası giriniz.',
                icon: 'error',
                confirmButtonText: 'Tamam'
            });
            this.value = ''; // Geçersizse input'u temizle
        }
    });

</script>
</body>

</html>


</script>
</body>

</html>
