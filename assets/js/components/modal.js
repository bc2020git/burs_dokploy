const confirmbtn = document.getElementById('confirmbtn');
if (confirmbtn) {
    confirmbtn.addEventListener('click', function() {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.hide();

        var approvedModal = new bootstrap.Modal(document.getElementById('approvedModal'));
        approvedModal.show();
    });
}

const deniedbtn = document.getElementById('deniedbtn');
if (deniedbtn) {
    deniedbtn.addEventListener('click', function() {
        var rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
        rejectModal.hide();

        var deniedbtnModal = new bootstrap.Modal(document.getElementById('deniedbtnModal'));
        deniedbtnModal.show();
    });
}

const toReturnbtn = document.getElementById('toReturnbtn');
if (toReturnbtn) {
    toReturnbtn.addEventListener('click', function() {
    var missingDocumentModal = new bootstrap.Modal(document.getElementById('missingDocumentModal'));
    missingDocumentModal.hide();

    var toReturnbtnModal = new bootstrap.Modal(document.getElementById('toReturnbtnModal'));
    toReturnbtnModal.show();
});
}

const saveClose = document.getElementById('save-close');
if (saveClose) {
    saveClose.addEventListener('click', function() {
        var createInterviewModal = new bootstrap.Modal(document.getElementById('createInterviewModal'));
        createInterviewModal.hide();

        var saveInterviewModal = new bootstrap.Modal(document.getElementById('saveInterviewModal'));
        saveInterviewModal.show();
    });
}

