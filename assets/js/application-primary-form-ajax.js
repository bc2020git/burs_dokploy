
function getFormData(step) {
    const formData = {};
    document.querySelectorAll(`#step-${step} input, #step-${step} select`).forEach(input => {
        formData[input.id] = input.value;
    });
    return formData;
}

function sendData(step) {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    const formData = getFormData(step);
    $.ajax({
        type: "GET",
        url: `/save-step-data`,
        data: {
            _token: csrfToken,
            type: 'primary-new',
            step: step,
            data: formData,
        },
        success: function(response) {
            console.log(response);
        }
    });
}
