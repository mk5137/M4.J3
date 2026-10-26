document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("fetchForm");
    const inputImie = document.getElementById("imie");
    const inputEmail = document.getElementById("email");
    const inputWiadomosc = document.getElementById("wiadomosc");
    const globalMessage = document.getElementById("globalMessage");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        let hasError = false;

        // Czyszczenie poprzednich błędów i komunikatów
        document.querySelectorAll(".error-msg").forEach(el => el.textContent = "");
        document.querySelectorAll(".input-error").forEach(el => el.classList.remove("input-error"));
        globalMessage.className = "status-msg";
        globalMessage.textContent = "";

        // 3. Walidacja w JavaScript
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

        // Jeśli są błędy w walidacji JS, zatrzymaj działanie
        if (hasError) return;

        // Przygotowanie danych z formularza
        const formData = new FormData(form);

        // 4. Wysyłanie danych przez fetch() do odbierz.php
        fetch("odbierz.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Obsługa odpowiedzi JSON z PHP
            if (data.status === "success") {
                globalMessage.className = "status-msg success";
                globalMessage.textContent = data.message;
                form.reset();
            } else {
                globalMessage.className = "status-msg error";
                globalMessage.textContent = data.message;

                // Wyświetlanie błędów zwróconych z walidacji serwerowej PHP
                if (data.errors) {
                    if (data.errors.imie) showError(inputImie, "error-imie", data.errors.imie);
                    if (data.errors.email) showError(inputEmail, "error-email", data.errors.email);
                    if (data.errors.wiadomosc) showError(inputWiadomosc, "error-wiadomosc", data.errors.wiadomosc);
                }
            }
        })
        .catch(() => {
            globalMessage.className = "status-msg error";
            globalMessage.textContent = "Wystąpił błąd podczas połączenia z serwerem.";
        });
    });

    function showError(input, errorId, msg) {
        document.getElementById(errorId).textContent = msg;
        input.classList.add("input-error");
    }
});