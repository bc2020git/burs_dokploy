@extends('layouts.master')
@section('title')
    Yönetici Paneli - Bildirimlerim
@endsection
@section('page-title')
    Bildirimlerim
@endsection

@section('local-css')
    <style>
        .notification-item {
            cursor: pointer;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }
        .notification-item:hover {
            background-color: #f8f9fa;
        }
        .notification-unread {
            background-color: #f0f7ff;
            border-left-color: #0065FF;
        }
        .notification-unread .fw-bold {
            color: #0065FF;
        }
    </style>
@endsection

@section('body')
    <body data-sidebar="colored">
    @endsection

    @section('content')
        <main class="main-content px-3 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h4 class="mb-0">Bildirimlerim</h4>
            </div>

            <div class="container mt-3">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">Tüm Bildirimler</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($notifications as $n)
                                <div class="list-group-item notification-item {{ $n->is_checked == '0' ? 'notification-unread' : '' }}" 
                                     onclick="markAsRead({{ $n->id }}, this)">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <h6 class="mb-1 {{ $n->is_checked == '0' ? 'fw-bold' : '' }}">{{ $n->notification->title }}</h6>
                                        <div class="d-flex align-items-center">
                                            <small class="text-muted me-3">{{ \Carbon\Carbon::parse($n->created_at)->locale('tr')->diffForHumans() }}</small>
                                            <button type="button" class="btn btn-sm btn-outline-danger border-0" 
                                                    onclick="deleteNotification({{ $n->id }}, this, event)" title="Sil">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="mb-1 text-secondary pe-5">{{ $n->notification->text }}</p>
                                    @if($n->is_checked == '0')
                                        <span class="badge bg-primary rounded-pill">Yeni</span>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <img src="{{ url('/assets/images/no-notifications.svg') }}" alt="No notifications" style="width: 150px; opacity: 0.5;">
                                    <p class="mt-3 text-muted">Henüz bir bildiriminiz bulunmuyor.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    @if($notifications->hasPages())
                        <div class="card-footer bg-white py-3">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
        @include('includes.js.toastr')
    @endsection

    @section('scripts')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <script>
            function markAsRead(id, element) {
                if ($(element).hasClass('notification-unread')) {
                    $.ajax({
                        url: "{{ url('/notifications') }}/" + id + "/mark-as-read",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                $(element).removeClass('notification-unread');
                                $(element).find('.fw-bold').removeClass('fw-bold');
                                $(element).find('.badge.bg-primary').remove();
                                
                                // Topbar badge'ini güncelle
                                updateBadgeCount(-1);
                            }
                        }
                    });
                }
            }

            function deleteNotification(id, button, event) {
                event.stopPropagation(); // Parent'ın onclick (markAsRead) tetiklenmesini engelle
                
                Swal.fire({
                    title: 'Emin misiniz?',
                    text: "Bu bildirimi silmek istediğinize emin misiniz?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Evet, sil!',
                    cancelButtonText: 'İptal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        let element = $(button).closest('.notification-item');
                        let isUnread = element.hasClass('notification-unread');
                        
                        $.ajax({
                            url: "{{ url('/notifications') }}/" + id,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.success) {
                                    element.fadeOut(300, function() {
                                        $(this).remove();
                                        
                                        // Eğer liste boş kaldıysa "bildirim yok" mesajını göster
                                        if ($('.notification-item').length === 0) {
                                            $('.list-group').html(`
                                                <div class="text-center py-5">
                                                    <img src="{{ url('/assets/images/no-notifications.svg') }}" alt="No notifications" style="width: 150px; opacity: 0.5;">
                                                    <p class="mt-3 text-muted">Henüz bir bildiriminiz bulunmuyor.</p>
                                                </div>
                                            `);
                                        }
                                    });
                                    
                                    // Eğer okunmamış bir bildirim silindiyse badge'i güncelle
                                    if (isUnread) {
                                        updateBadgeCount(-1);
                                    }
                                    
                                    Swal.fire(
                                        'Silindi!',
                                        'Bildirim başarıyla silindi.',
                                        'success'
                                    );
                                }
                            },
                            error: function() {
                                Swal.fire(
                                    'Hata!',
                                    'Bildirim silinirken bir sorun oluştu.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            }

            function updateBadgeCount(diff) {
                let badge = $('.badge.rounded-pill.bg-danger');
                if (badge.length) {
                    let count = parseInt(badge.text().trim()) + diff;
                    if (count <= 0) {
                        badge.remove();
                    } else {
                        badge.text(count);
                    }
                }
            }
        </script>
        @include('includes.js.sidebar')
    @endsection
