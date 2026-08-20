@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Mülakat Grupları
@endsection

@section('content')
    <main class="main-content px-3 py-4">
        <div class="mt-1">
            <div class="navbar-button-container">
                <a href="{{ route('mulakat-grup.create') }}">
                    <div class="d-flex flex-wrap">
                        <button type="button" class="btn me-3 text-white" id="newAdd">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="white" />
                            </svg>
                            Yeni
                        </button>
                    </div>
                </a>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-hover" id="interviewGroupsTable">
                    <thead>
                        <tr>
                            <th>Grup Adı</th>
                            <th>Üye Sayısı</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groups as $group)
                            <tr>
                                <td>{{ $group->name }}</td>
                                <td>{{ count($group->members ?? []) }}</td>
                                <td>
                                    <a href="{{ route('mulakat-grup.edit', $group) }}" class="btn edit-candidate-info-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                            <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('mulakat-grup.destroy', $group) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn me-3" onclick="return confirm('Emin misiniz?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path style='fill: red;' d="M14.1641 5.00033H18.3307V6.66699H16.6641V17.5003C16.6641 17.9606 16.291 18.3337 15.8307 18.3337H4.16406C3.70383 18.3337 3.33073 17.9606 3.33073 17.5003V6.66699H1.66406V5.00033H5.83073V2.50033C5.83073 2.04009 6.20383 1.66699 6.66406 1.66699H13.3307C13.791 1.66699 14.1641 2.04009 14.1641 2.50033V5.00033ZM14.9974 6.66699H4.9974V16.667H14.9974V6.66699ZM7.4974 9.16699H9.16406V14.167H7.4974V9.16699ZM10.8307 9.16699H12.4974V14.167H10.8307V9.16699ZM7.4974 3.33366V5.00033H12.4974V3.33366H7.4974Z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://datatables-cdn.com/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://datatables-cdn.com/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#interviewGroupsTable').DataTable({
                stateSave: true,
                ordering: false,
                pageLength: 25,
                language: {
                    url: '{{ url('') }}/public/build/js/dataTables/tr.json',
                    paginate: {
                        previous: '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none"><path d="M14.4142 12L19.2071 7.20712L17.7929 5.79291L11.5858 12L17.7929 18.2071L19.2071 16.7929L14.4142 12ZM7.5 18V6.00001H9.5V18H7.5Z" fill="#636363"></path></svg>',
                        next: '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none"><path d="M10.5858 12L5.79291 16.7929L7.20712 18.2071L13.4142 12L7.20712 5.79291L5.79291 7.20712L10.5858 12ZM17.5 6.00002V18H15.5V6.00002H17.5Z" fill="#636363"></path></svg>'
                    }
                }
            });
        });
    </script>
@endsection
