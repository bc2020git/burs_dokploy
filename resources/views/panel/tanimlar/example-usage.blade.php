{{--
    Örnek Kullanım: Tanimlar tablolarında export butonları

    Herhangi bir tanimlar tablosunda export butonlarını eklemek için:

    1. Table ID'sini ve Model adını belirleyin
    2. Component'i dahil edin
    3. Tablodan seçili kayıtları export edebilirsiniz
--}}

{{-- Örnek 1: Bankalar Tablosu --}}
<x-export-buttons table-id="banksTable" model="bank" />

{{-- Örnek 2: Üniversiteler Tablosu --}}
<x-export-buttons table-id="universitiesTable" model="university" />

{{-- Örnek 3: Fakülteler Tablosu --}}
<x-export-buttons table-id="facultiesTable" model="faculty" />

{{-- Örnek 4: Bölümler Tablosu --}}
<x-export-buttons table-id="departmentsTable" model="department" />

{{-- Örnek 5: Sorular Tablosu --}}
<x-export-buttons table-id="questionsTable" model="question" />

{{-- Örnek 6: Soru Kategorileri Tablosu --}}
<x-export-buttons table-id="questionCategoriesTable" model="questioncategory" />

{{-- Örnek 7: Mesaj Şablonları Tablosu --}}
<x-export-buttons table-id="messageTemplatesTable" model="messagetemplate" />

{{-- Örnek 8: Sebepler Tablosu --}}
<x-export-buttons table-id="reasonsTable" model="sebep" />

{{-- Örnek 9: Burs Tipleri Tablosu --}}
<x-export-buttons table-id="bursTipiTable" model="burstipi" />

{{--
    Desteklenen Export Formatları:
    - Excel (.xlsx)
    - CSV (.csv)
    - PDF (.pdf)

    Özellikler:
    - ✅ Seçili kayıtları export eder
    - ✅ Türkçe başlıklar
    - ✅ UTF-8 karakter desteği
    - ✅ Otomatik dosya isimlendirme
    - ✅ Loading göstergesi
    - ✅ Hata yönetimi
    - ✅ DataTables butonları ile uyumlu
    - ✅ Sunucu tarafı fallback

    Gereksinimler:
    - Table'da .user-checkbox class'ına sahip checkboxlar
    - data-id attribute'u ile kayıt ID'leri
    - CSRF token
    - Authentication

    Troubleshooting:
    - Table ID'sinin doğru olduğundan emin olun
    - Model adının ExportController'da tanımlı olduğunu kontrol edin
    - Checkbox'ların seçili olduğunu kontrol edin
    - Browser console'da hata mesajlarını inceleyin
--}}
























