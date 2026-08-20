document.addEventListener('DOMContentLoaded', function() {
    var saveCloseButton = document.getElementById('save-close');
    var recordStartButton = document.getElementById('recordStart');
    var recordStopButton = document.getElementById('recordStop');

    if (saveCloseButton) {
        saveCloseButton.addEventListener('click', function () {
            window.location.href = '/admin/registration-renewal.html?showModal=applicationPeriodModal&recordStarted=true';
        });
    }

    if (recordStartButton) {
        recordStartButton.addEventListener('click', function () {
            this.innerHTML = 'Kayıt Yenileme Dönemini Durdur <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M7 0C3.12667 0 0 3.12667 0 7C0 10.8733 3.12667 14 7 14C10.8733 14 14 10.8733 14 7C14 3.12667 10.8733 0 7 0Z" fill="white"/></svg>';
            this.classList.remove('btn-primary');
            this.classList.add('btn-danger');
            this.id = 'recordStop';
        });
    }

    var urlParams = new URLSearchParams(window.location.search);
    if (!urlParams.has('showModal')) {
        $('#applicationModal').modal('show');
    } else {
        var modalToShow = urlParams.get('showModal');
        if (modalToShow === 'applicationPeriodModal') {
            $('#applicationPeriodModal').modal('show');
        }
    }

    if (urlParams.has('recordStarted')) {
        recordStartButton.classList.add('d-none');
        recordStopButton.classList.remove('d-none');
    }

    var recordStartButton = document.getElementById('recordStart');
    if (recordStartButton) {
        recordStartButton.addEventListener('click', function () {
            window.location.href = '/admin/document-update.html';
        });
    }

    if (urlParams.has('recordStarted')) {
        document.getElementById('recordStart').classList.add('d-none');
        document.getElementById('recordStop').classList.remove('d-none');
    }
//table verileri

});
