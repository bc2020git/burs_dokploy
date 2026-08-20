                                @foreach ($belgeler as $belge)
                                    <tr>
                                        <td><input data-docname="{{ $belge->db_key }}" name="doccheckbox" type="checkbox"
                                                class="checkbox" id="masterCheckbox"></td>
                                        <td>{{ $belge->title }}</td>


                                        @php
                                            $verification = $aday->scholar->docverify
                                                ->where('doc_name', $belge->db_key)
                                                ->where('period_id', $aday->period->id)
                                                ->sortByDesc('created_at')
                                                ->first();
                                        @endphp

                                        @if ($verification)
                                            @if ($verification->status == 1)
                                                <td class="status checked">Onaylandı<span class="checkmark">✅</span>
                                                </td>
                                                <td><button data-docname="{{ $belge->db_key }}"
                                                        class="btn btn-outline-success" onclick="approveDocument(this)"
                                                        disabled="">Belge
                                                        Onayla</button></td>
                                                <td><button data-docname="{{ $belge->db_key }}"
                                                        class="btn btn-outline-danger"
                                                        onclick="rejectDocument(this)">Belge Reddet</button></td>
                                            @elseif($verification->status == 2)
                                                <td class="status reject">Reddedildi <span class="crossmark">❌</span>
                                                </td>
                                                <td><button data-docname="{{ $belge->db_key }}"
                                                        class="btn btn-outline-success"
                                                        onclick="approveDocument(this)">Belge Onayla</button></td>
                                                <td><button data-docname="{{ $belge->db_key }}"
                                                        class="btn btn-outline-danger" onclick="rejectDocument(this)"
                                                        disabled="">Belge Reddet</button></td>
                                            @else
                                                <td class="status">Onay Bekliyor</td>
                                                <td><button data-docname="{{ $belge->db_key }}"
                                                        class="btn btn-outline-success"
                                                        onclick="approveDocument(this)">Belge Onayla</button></td>
                                                <td><button data-docname="{{ $belge->db_key }}"
                                                        class="btn btn-outline-danger"
                                                        onclick="rejectDocument(this)">Belge Reddet</button></td>
                                            @endif
                                        @else
                                            <td class="status">Onay Bekliyor</td>
                                            <td><button data-docname="{{ $belge->db_key }}"
                                                    class="btn btn-outline-success"
                                                    onclick="approveDocument(this)">Belge Onayla</button></td>
                                            <td><button data-docname="{{ $belge->db_key }}"
                                                    class="btn btn-outline-danger" onclick="rejectDocument(this)">Belge
                                                    Reddet</button></td>
                                        @endif
                                    </tr>
                                @endforeach
