document.getElementById('graduatebtn').addEventListener('click', function() {
    var graduateConfirmModal = new bootstrap.Modal(document.getElementById('graduateConfirmModal'));
    graduateConfirmModal.hide();

    var graduatebtnModal = new bootstrap.Modal(document.getElementById('graduatebtnModal'));
    graduatebtnModal.show();
});
document.getElementById('cancelbtn').addEventListener('click', function() {
    var cancelScholarshipModal = new bootstrap.Modal(document.getElementById('cancelScholarshipModal'));
    cancelScholarshipModal.hide();

    var cancelbtnModal = new bootstrap.Modal(document.getElementById('cancelbtnModal'));
    cancelbtnModal.show();
});