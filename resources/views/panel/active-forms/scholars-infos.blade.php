<div class="tab-pane fade" id="other-info" role="tabpanel" aria-labelledby="other-info-tab"
     data-content="9">
    <div class="tab-section">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Devlet Bursu Almakta mı ya da Başvurdu
                    mu?</label>
                <input id="government" type="text" class="form-control" value="@if(isset($aday->infos->government)){{$aday->infos->government}}@endif">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Özel Burs Almakta ya da Başvurdu mu?</label>
                <input id="special" type="text" class="form-control" value="@if(isset($aday->infos->special)){{$aday->infos->special}}@endif">
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button id="addButton" type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                    data-bs-target="#bursEkleModal"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M9.16797 9.1665V4.1665H10.8346V9.1665H15.8346V10.8332H10.8346V15.8332H9.16797V10.8332H4.16797V9.1665H9.16797Z" fill="#4069E5"/>
                </svg> Burs Ekle</button>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Kurum Adı</th>
                <th>Kurum Türü</th>
                <th> Burs Tutarı</th>
                <th> İşlem</th>

            </tr>
            </thead>
            <tbody>
            @php $toplam = 0; @endphp
            @foreach($aday->infos->otherScholarships as $sc)
                @php $toplam += $sc->count; @endphp
                <tr>
                    <td>{{$sc->company_name}}</td>
                    <td>{{$sc->company_type}}</td>
                    <td>{{$sc->count}} ₺</td>
                    <td>
                        <button data-editid="{{$sc->id}}" data-kurumadi="{{$sc->company_name}}"  data-kurumturu="{{$sc->company_type}}" data-bursmiktari="{{$sc->count}}" class="btn edit-member-info-btn editBursBtn" type="button"
                                class="btn btn-primary mb-3 editBursBtn" data-bs-toggle="modal"
                                data-bs-target="#bursDuzenleModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z" fill="#4069E5"/>
                            </svg></button>
                        <a href="{{route('deleteNewScholarScholarShip',['id'=>$sc->id])}}"><button class="btn" type="button" class="btn btn-primary mb-3"
                                                                                                   data-bs-toggle="modal" data-bs-target="#kardesSilModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM9 11V17H11V11H9ZM13 11V17H15V11H13ZM9 4V6H15V4H9Z" fill="#F03000"/>
                                </svg></button></a>
                    </td>
                </tr>
            @endforeach
            <tfoot>
                <tr>
                    <td colspan="2">Toplam</td>
                    <td><span id="scholar_count">{{$toplam}} ₺</span></td>
                    <td></td>
                </tr>
            </tfoot>
            </tbody>
        </table>
    </div>
</div>
