document.getElementById('kyConfirmbtn').addEventListener('click', function() {
    var kySuccessModal = new bootstrap.Modal(document.getElementById('kySuccessModal'));
    kySuccessModal.hide();

    var kyapprovedModal = new bootstrap.Modal(document.getElementById('kyapprovedModal'));
    kyapprovedModal.show();
});

document.getElementById('kyDeniedbtn').addEventListener('click', function() {
    var kyRejectModal = new bootstrap.Modal(document.getElementById('kyRejectModal'));
    kyRejectModal.hide();

    var kydeniedbtnModal = new bootstrap.Modal(document.getElementById('kydeniedbtnModal'));
    kydeniedbtnModal.show();
});

document.getElementById('toReturnbtn').addEventListener('click', function() {
    var kyMissingDocumentModal = new bootstrap.Modal(document.getElementById('kyMissingDocumentModal'));
    kyMissingDocumentModal.hide();

    var kytoReturnbtnModal = new bootstrap.Modal(document.getElementById('kytoReturnbtnModal'));
    kytoReturnbtnModal.show();
});

document.getElementById('graduatebtn').addEventListener('click', function() {
    var graduateConfirmModal = new bootstrap.Modal(document.getElementById('graduateConfirmModal'));
    graduateConfirmModal.hide();

    var kygraduatebtnModal = new bootstrap.Modal(document.getElementById('kygraduatebtnModal'));
    kygraduatebtnModal.show();

    var graduatebtnModal = new bootstrap.Modal(document.getElementById('graduatebtnModal'));
    graduatebtnModal.show();
});
