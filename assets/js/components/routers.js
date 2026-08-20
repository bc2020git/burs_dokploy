document.addEventListener('DOMContentLoaded', function () {
    const applicationStartButton = document.getElementById('applicationStart');
    if (applicationStartButton) {
        applicationStartButton.addEventListener('click', function () {
            window.location.href = '/admin/application-start.html';
        });
    }
});
