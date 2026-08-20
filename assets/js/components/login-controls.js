
document.addEventListener("DOMContentLoaded", function() {
    const otpInputs = document.querySelectorAll(".otp-input");

    otpInputs.forEach((input, index) => {
        input.addEventListener("input", (event) => {
            const value = event.target.value;
            if (value.length === 1 && /^[0-9]$/.test(value)) {
                if (index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            } else {
                event.target.value = "";
            }
        });

        input.addEventListener("keydown", (event) => {
            if (event.key === "Backspace" && !event.target.value && index > 0) {
                otpInputs[index - 1].focus();
            }
        });
    });

});
