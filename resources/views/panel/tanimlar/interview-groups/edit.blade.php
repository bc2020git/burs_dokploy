@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Mülakat Grubu Düzenle: {{ $group->name }}
@endsection

@section('local-css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    .select2-container {
        width: 100% !important;
    }
    .select2-selection {
        min-height: 38px !important;
    }
    .input-group .select2-container {
        flex: 1 1 auto;
        width: 1% !important;
    }
    .input-group .select2-container .select2-selection {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .member-list {
        min-height: 160px;
        max-height: 320px;
        overflow-y: auto;
    }
    .member-row {
        gap: 0.75rem;
    }
</style>
@endsection
<body data-sidebar="colored">

@section('content')
<main class="main-content px-3 py-4">
    <div class="mt-1">
        <form action="{{ route('mulakat-grup.update', $group) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <a href="{{ route('mulakat-grup.index') }}" class="btn btn-danger me-3">Vazgeç</a>
                <button type="submit" class="btn btn-primary">Kaydet</button>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="col-md-6 form-group">
                        <label class="custom-label">Grup Adı</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $group->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @php
                        $selectedMemberIds = collect(old('members', $group->members ?? []))->map(fn ($id) => (string) $id)->values();
                    @endphp
                    <div class="mb-3">
                        <label class="form-label">Grup üyeleri</label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <div class="fw-semibold mb-2">Mevcut grup üyeleri</div>
                                    <div id="selected-members" class="member-list">
                                        @foreach($users as $user)
                                            @if($selectedMemberIds->contains((string) $user->id))
                                                <div class="member-row d-flex align-items-center justify-content-between border rounded px-3 py-2 mb-2"
                                                     data-member-id="{{ $user->id }}"
                                                     data-member-name="{{ $user->name }} {{ $user->surname }}">
                                                    <span>{{ $user->name }} {{ $user->surname }}</span>
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-member" title="Üyeyi çıkar">-</button>
                                                    <input type="hidden" name="members[]" value="{{ $user->id }}">
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div id="empty-members-message" class="text-muted small {{ $selectedMemberIds->isNotEmpty() ? 'd-none' : '' }}">
                                        Henüz üye eklenmedi.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <label for="member-selector" class="fw-semibold mb-2">Üye ekle</label>
                                    <div class="input-group">
                                        <select class="form-select @error('members') is-invalid @enderror"
                                                id="member-selector">
                                            <option value="">Üye seçiniz</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}"
                                                        data-member-name="{{ $user->name }} {{ $user->surname }}"
                                                        {{ $selectedMemberIds->contains((string) $user->id) ? 'disabled' : '' }}>
                                                    {{ $user->name }} {{ $user->surname }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" id="add-member" class="btn btn-outline-primary">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('members')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>


        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        const $memberSelector = $('#member-selector');
        const $selectedMembers = $('#selected-members');
        const $emptyMembersMessage = $('#empty-members-message');

        $memberSelector.select2({
            theme: 'bootstrap-5',
            placeholder: 'Üye seçiniz',
            allowClear: true
        });

        function refreshEmptyMessage() {
            $emptyMembersMessage.toggleClass('d-none', $selectedMembers.children('.member-row').length > 0);
        }

        function resetMemberSelector() {
            $memberSelector.val('').trigger('change');
        }

        $('#add-member').on('click', function() {
            const memberId = $memberSelector.val();

            if (!memberId) {
                return;
            }

            const selectedOption = $memberSelector.find('option:selected');
            const memberName = selectedOption.data('member-name') || selectedOption.text().trim();

            const memberRow = $('<div>', {
                class: 'member-row d-flex align-items-center justify-content-between border rounded px-3 py-2 mb-2',
                'data-member-id': memberId,
                'data-member-name': memberName
            });

            $('<span>').text(memberName).appendTo(memberRow);
            $('<button>', {
                type: 'button',
                class: 'btn btn-sm btn-outline-danger remove-member',
                title: 'Üyeyi çıkar',
                text: '-'
            }).appendTo(memberRow);
            $('<input>', {
                type: 'hidden',
                name: 'members[]',
                value: memberId
            }).appendTo(memberRow);

            $selectedMembers.append(memberRow);
            selectedOption.prop('disabled', true);
            resetMemberSelector();
            refreshEmptyMessage();
        });

        $selectedMembers.on('click', '.remove-member', function() {
            const memberRow = $(this).closest('.member-row');
            const memberId = memberRow.data('member-id');

            $memberSelector.find(`option[value="${memberId}"]`).prop('disabled', false);
            memberRow.remove();
            resetMemberSelector();
            refreshEmptyMessage();
        });
    });
</script>
@endsection
