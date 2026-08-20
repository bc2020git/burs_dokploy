<div class="tab-pane fade" id="document-info" role="tabpanel" aria-labelledby="document-info-tab" data-content="14">
    <div class="tab-section">
        <div class="container">
            @if(isset($periods) && count($periods) > 0)
            @php
                $uniquePeriods = collect($periods)->unique('title');
            @endphp
            <div class="row  mb-4">
                <div class="col-md-6 term-select ">
                    <label for="termSelect" class="form-label">Dönem Seçiniz</label>
                    <div class="form-group d-flex align-items-center">
                        <select class="form-select me-2" id="termSelect">
                            @foreach ($uniquePeriods as $period)
                                <option value="{{ $period->id }}">{{ $period->title }}</option>
                            @endforeach
                        </select>
                        <a class="btn btn-primary" onclick="showDocuments()">Göster</a>
                    </div>
                </div>
                <div class="col-md-6 term-control-select">
                    <label for="termControlSelect" class="form-label">Belge Kontrol</label>
                    <div class="form-group d-flex align-items-center">
                        <select class="form-select me-2" id="termControlSelect">
                            @foreach ($periods as $period)
                                <option value="{{ $period->id }}">{{ $period->title }}</option>
                            @endforeach
                        </select>
                        <a class="btn btn-primary" onclick="showDocumentControl()">Göster</a>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-info">
                Bu öğrenci için kayıtlı dönem bulunamadı.
            </div>
            @endif


            <!-- Belge Görüntüle -->
            <div id="documents" class="row d-none">
                <div class="row mt-3" id="documentCardsContainer">
                    <!-- Belgeler AJAX ile yüklenecek -->
                </div>
            </div>

            <!-- Belge Kontrol -->
            <div id="documentControl" class="row d-none">
                <div class="col-md-12">
                    <div class="table table-striped">
                        <div class="button-container-doc d-flex mb-3">
                            <span class="btn btn-outline-success" onclick="approveSelected()">Toplu Belge Onayla</span>
                            <span class="btn btn-outline-danger ml-2" onclick="rejectSelected()">Toplu Belge
                                Reddet</span>
                            <a class="btn btn-outline-primary ml-2" onclick="islemIcinDiziGonderActive(3);"
                                id="adayTopluIndirBtn">Seçilileri İndir</a>
                        </div>
                        <table id="documentControlTable">
                            <thead>

                                <tr>
                                    <th><input type="checkbox" class="checkbox" id="masterCheckbox"></th>
                                    <th>Belge Adı</th>
                                    <th>Belge Durumu</th>
                                    <th>Onayla</th>
                                    <th>Reddet</th>
                                </tr>
                            </thead>
                            <tbody id="documentList">
                                <!-- Belgeler AJAX ile yüklenecek -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
