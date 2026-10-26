<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz Kontaktowy Fetch</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h1>Kontakt</h1>
        
        <div id="globalMessage" class="status-msg"></div>

        <form id="fetchForm" novalidate>
            <div class="form-group">
                <label for="imie">Imię:</label>
                <input type="text" id="imie" name="imie" required>
                <div class="error-msg" id="error-imie"></div>
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
                <div class="error-msg" id="error-email"></div>
            </div>

            <div class="form-group">
                <label for="wiadomosc">Wiadomość:</label>
                <textarea id="wiadomosc" name="wiadomosc" rows="4" required></textarea>
                <div class="error-msg" id="error-wiadomosc"></div>
            </div>

            <button type="submit" id="btnSubmit">Wyślij wiadomość</button>
        </form>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("contactForm") || document.getElementById("fetchForm");
        const inputImie = document.getElementById("imie");
        const inputEmail = document.getElementById("email");
        const inputWiadomosc = document.getElementById("wiadomosc");
        const globalMessage = document.getElementById("globalMessage");

        form.addEventListener("submit", function (e) {
            e.preventDefault();

            let hasError = false;
            document.querySelectorAll(".error-msg").forEach(el => el.textContent = "");
            document.querySelectorAll(".input-error").forEach(el => el.classList.remove("input-error"));
            globalMessage.className = "status-msg";
            globalMessage.textContent = "";

            if (inputImie.value.trim().length < 2) {
                showError(inputImie, "error-imie", "Imię musi mieć min. 2 znaki.");
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
            .then(response => response.json())
            .then(data => {
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
    </script>
</body>
</html>