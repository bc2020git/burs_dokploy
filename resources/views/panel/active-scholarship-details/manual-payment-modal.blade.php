{{-- Aktif bursiyer detayında manuel burs ödeme / taksit satırları oluşturma --}}
<div class="modal fade" id="manualBursPaymentModal" tabindex="-1" aria-labelledby="manualBursPaymentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manualBursPaymentModalLabel">Burs Ödemesi Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small mb-3">
                    Seçilen burs tipine göre, girdiğiniz taksit sayısı kadar ödeme satırı oluşturulur. Her taksit tutarı
                    aynıdır; ödeme tarihleri başlangıç tarihinden itibaren aylık ilerler.
                </p>
                <form id="manualBursPaymentForm" onsubmit="return false;">
                    <input type="hidden" id="manual_payment_form_id" name="form_id" value="{{ $aday->id }}">
                    <input type="hidden" id="manual_payment_tc" name="tc_kimlik_no" value="{{ $aday->infos->tc_no ?? '' }}">

                    <div class="mb-3">
                        <label for="manual_burs_tipi_id" class="form-label">Burs Tipi</label>
                        <select name="burs_tipi_id" id="manual_burs_tipi_id" class="form-select" required>
                            <option value="">Seçiniz</option>
                            @foreach (($bursTipleri ?? []) as $tip)
                                <option value="{{ $tip->id }}">{{ $tip->burs_tipi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="manual_donem" class="form-label">Dönem</label>
                        <select name="donem" id="manual_donem" class="form-select" required>
                            <option value="">Seçiniz</option>
                            @foreach (($manualPaymentDonemOptions ?? []) as $opt)
                                <option value="{{ $opt['value'] }}">{{ $opt['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="manual_taksit_sayisi" class="form-label">Taksit Sayısı</label>
                        <input type="number" name="taksit_sayisi" id="manual_taksit_sayisi" class="form-control" min="1"
                            max="120" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="manual_odeme_tutari" class="form-label">Ödeme Tutarı (₺)</label>
                        <input type="number" name="odeme_tutari" id="manual_odeme_tutari" class="form-control" min="0"
                            step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="manual_baslangic_tarihi" class="form-label">Başlangıç Tarihi</label>
                        <input type="text" name="baslangic_tarihi" id="manual_baslangic_tarihi" class="form-control"
                            placeholder="GG.AA.YYYY" autocomplete="off" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                <button type="button" class="btn btn-primary" id="manualBursPaymentSubmit">Oluştur</button>
            </div>
        </div>
    </div>
</div>
