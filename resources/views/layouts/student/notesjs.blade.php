<script>
    $(document).ready(function() {
        $('#aboutButton, #notesButton').click(function(event) {
            event.preventDefault();
        });

        // Puanlar butonu sadece yetkisi olan kullanıcılar için
        @if(Auth::user()->hasPermission('aday-puanlarini-goruntule'))
        $('#pointsButton').click(function(event) {
            event.preventDefault();
        });
        @endif

        $('#aboutButton').click(function() {
            $('#aboutContent').show();
            $('#notesContent').hide();
            @if(Auth::user()->hasPermission('aday-puanlarini-goruntule'))
            $('#pointsContent').hide();
            @endif
            $(this).addClass('active');
            $('#notesButton').removeClass('active');
            @if(Auth::user()->hasPermission('aday-puanlarini-goruntule'))
            $('#pointsButton').removeClass('active');
            @endif
        });

        $('#notesButton').click(function() {
            $('#notesContent').show();
            $('#aboutContent').hide();
            @if(Auth::user()->hasPermission('aday-puanlarini-goruntule'))
            $('#pointsContent').hide();
            @endif
            $(this).addClass('active');
            $('#aboutButton').removeClass('active');
            @if(Auth::user()->hasPermission('aday-puanlarini-goruntule'))
            $('#pointsButton').removeClass('active');
            @endif
        });
        @if(Auth::user()->hasPermission('aday-puanlarini-goruntule'))
        $('#pointsButton').click(function() {
            $('#pointsContent').show();
            $('#aboutContent').hide();
            $('#notesContent').hide();
            $(this).addClass('active');
            $('#aboutButton').removeClass('active');
            $('#notesButton').removeClass('active');
        });
        @endif

        $('#addNoteButton').click(function(event) {
            event.preventDefault();
            $('#noteTcNo').val($('input[name="tc_no"]').val());
            $('#addNoteModal').modal('show');
        });

        $('#saveNoteBtn').click(function() {
            let title = $('#noteTitle').val();
            let text = $('#noteContent').val();
            let tc_no = $('#tc_no').val();

            $.ajax({
                url: '{{ route("add.scholar.note") }}',
                method: 'POST',
                data: {
                    title: title,
                    text: text,
                    tc_no: tc_no,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        addNoteToList(response.note);
                        $('#addNoteModal').modal('hide');
                        $('#noteTitle').val('');
                        $('#noteContent').val('');
                    } else {
                        alert('Not eklenirken bir hata oluştu.');
                    }
                },
                error: function() {
                    alert('Not eklenirken bir hata oluştu.');
                }
            });
        });

        function addNoteToList(note) {
            let noteHtml = `
                <div class="note d-flex flex-column timeline-content-note">
                    <div class="d-flex justify-content-between flex-row">
                        <h5 class='text-capitalize font-weight-bold'>${note.title}</h5>
                        <p class='text-muted'>${new Date(note.created_at).toLocaleDateString('tr-TR', {day: '2-digit', month: '2-digit', year: 'numeric'}).split('.').join('.')}</p>
                    </div>
                    <p>${note.text}</p>
                    <div class="d-flex justify-content-end">
                        <div class="btn btn-danger btn-sm" onclick="location.href='/panel/delete-note/${note.id}'">Sil</div>
                    </div>
                </div>
            `;
            $('#notesList').prepend(noteHtml);
        }

        function loadNotes() {
            let tc_no = $('input[name="tc_no"]').val();
            $.ajax({
                url: '{{ route("get.scholar.notes") }}',
                method: 'GET',
                data: { tc_no: tc_no },
                success: function(response) {
                    if (response.success) {
                        response.notes.forEach(function(note) {
                            addNoteToList(note);
                        });
                    }
                }
            });
        }

        loadNotes();
    });
</script>
