document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("fetchForm");
    const inputImie = document.getElementById("imie");
    const inputEmail = document.getElementById("email");
    const inputWiadomosc = document.getElementById("wiadomosc");
    const globalMessage = document.getElementById("globalMessage");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        let hasError = false;

        document.querySelectorAll(".error-msg").forEach(el => el.textContent = "");
        document.querySelectorAll(".input-error").forEach(el => el.classList.remove("input-error"));
        
        if (globalMessage) {
            globalMessage.className = "status-msg";
            globalMessage.textContent = "";
            globalMessage.style.display = "none";
        }

        if (inputImie.value.trim().length < 2) {
            showError(inputImie, "error-imie", "Imię musi mieć co najmniej 2 znaki.");
            hasError = true;
        }

        if (!inputEmail.checkValidity() || inputEmail.value.trim() === "") {
            showError(inputEmail, "error-email", "Wprowadź poprawny adres e-mail.");
            hasError = true;
        }

        if (inputWiadomosc.value.trim() === "") {
            showError(inputWiadomosc, "error-wiadomosc", "Wpisz treść wiadomości.");
            hasError = true;
        }

        if (hasError) return;

        const formData = new FormData(form);

        fetch("odbierz.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);

                if (globalMessage) {
                    globalMessage.style.display = "block";
                    if (data.status === "success") {
                        globalMessage.className = "status-msg success";
                        globalMessage.textContent = data.message;
                        form.reset();
                    } else {
                        globalMessage.className = "status-msg error";
                        globalMessage.textContent = data.message;

                        if (data.errors) {
                            if (data.errors.imie) showError(inputImie, "error-imie", data.errors.imie);
                            if (data.errors.email) showError(inputEmail, "error-email", data.errors.email);
                            if (data.errors.wiadomosc) showError(inputWiadomosc, "error-wiadomosc", data.errors.wiadomosc);
                        }
                    }
                }
            } catch (err) {
                console.error("Odpowiedź z serwera nie jest poprawnym obiektem JSON:", text);
                if (globalMessage) {
                    globalMessage.style.display = "block";
                    globalMessage.className = "status-msg error";
                    globalMessage.textContent = "Błąd odpowiedzi serwera (sprawdź konsolę F12).";
                }
            }
        })
        .catch(error => {
            console.error("Błąd sieci/fetch:", error);
            if (globalMessage) {
                globalMessage.style.display = "block";
                globalMessage.className = "status-msg error";
                globalMessage.textContent = "Wystąpił błąd podczas połączenia z serwerem.";
            }
        });
    });

    function showError(input, errorId, msg) {
        const errorEl = document.getElementById(errorId);
        if (errorEl) {
            errorEl.textContent = msg;
        }
        input.classList.add("input-error");
    }
});