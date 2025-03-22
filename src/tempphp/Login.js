document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
        let isValid = true;

        const username = form.Username.value.trim();
        const password = form.Password.value.trim();

        if (username === "") {
            alert("Username cannot be empty.");
            isValid = false;
        }

        if (password.length < 6) {
            alert("Password is not correct.");
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
});
