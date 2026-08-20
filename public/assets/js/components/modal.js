document.addEventListener('DOMContentLoaded', function() {
    var saveCloseButton = document.getElementById('save-close');
    var applicationStartButton = document.getElementById('applicationStart');
    var applicationStopButton = document.getElementById('applicationStop');

    if (saveCloseButton) {
        saveCloseButton.addEventListener('click', function () {
            window.location.href = '/admin/scholarship-applications-list-applications.html?showModal=true&applicationStarted=true';
        });
    }

    if (applicationStartButton) {
        applicationStartButton.addEventListener('click', function () {
            this.innerHTML = 'Burs Başvurularını Durdur <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M7 0C3.12667 0 0 3.12667 0 7C0 10.8733 3.12667 14 7 14C10.8733 14 14 10.8733 14 7C14 3.12667 10.8733 0 7 0Z" fill="white"/></svg>';
            this.classList.remove('btn-primary');
            this.classList.add('btn-danger');
            this.id = 'applicationStop';
        });
    }

    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('showModal')) {
        $('#applicationModal').modal('show');
    }
    if (urlParams.has('applicationStarted')) {
        applicationStartButton.classList.add('d-none');
        applicationStopButton.classList.remove('d-none');
    }

});
