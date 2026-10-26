document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("contactForm");
    const inputImie = document.getElementById("imie");
    const inputEmail = document.getElementById("email");
    const inputTelefon = document.getElementById("telefon");
    const inputData = document.getElementById("data_kontaktu");
    const inputHaslo = document.getElementById("haslo");
    const togglePasswordBtn = document.getElementById("togglePassword");
    const inputWiadomosc = document.getElementById("wiadomosc");
    const inputZgoda = document.getElementById("zgoda");
    const selectTemat = document.getElementById("temat");
    
    const btnTest = document.getElementById("btnTest");
    const greetingDiv = document.getElementById("greeting");
    const charCountSpan = document.getElementById("charCount");

    let successCount = parseInt(localStorage.getItem("formSuccessCount") || "0");
    let errorCount = parseInt(localStorage.getItem("formErrorCount") || "0");
    updateStatsDisplay();

    function updateStatsDisplay() {
        document.getElementById("statSuccess").textContent = successCount;
        document.getElementById("statError").textContent = errorCount;
    }

    togglePasswordBtn.addEventListener("click", function () {
        if (inputHaslo.type === "password") {
            inputHaslo.type = "text";
            togglePasswordBtn.textContent = "Ukryj";
        } else {
            inputHaslo.type = "password";
            togglePasswordBtn.textContent = "Pokaż";
        }
    });

    btnTest.addEventListener("click", function () {
        const valImie = inputImie.value.trim();
        if (valImie !== "") {
            greetingDiv.textContent = "Witaj, " + valImie + "!";
            greetingDiv.style.display = "block";
        } else {
            greetingDiv.textContent = "Wprowadź najpierw imię!";
            greetingDiv.style.display = "block";
        }
    });

    const maxLen = 200;
    inputWiadomosc.addEventListener("input", function () {
        const currentLen = inputWiadomosc.value.length;
        charCountSpan.textContent = maxLen - currentLen;
    });

    form.addEventListener("reset", function () {
        setTimeout(() => {
            document.querySelectorAll(".error-msg").forEach(el => el.textContent = "");
            document.querySelectorAll(".input-error").forEach(el => el.classList.remove("input-error"));
            greetingDiv.style.display = "none";
            charCountSpan.textContent = maxLen;
        }, 10);
    });

    function setError(inputElement, errorElementId, message) {
        document.getElementById(errorElementId).textContent = message;
        inputElement.classList.add("input-error");
    }

    form.addEventListener("submit", function (e) {
        let hasError = false;

        document.querySelectorAll(".error-msg").forEach(el => el.textContent = "");
        document.querySelectorAll(".input-error").forEach(el => el.classList.remove("input-error"));

        const imieVal = inputImie.value.trim();
        if (imieVal === "") {
            setError(inputImie, "error-imie", "Pole imię nie może być puste.");
            hasError = true;
        } else if (imieVal.length < 2) {
            setError(inputImie, "error-imie", "Imię musi mieć co najmniej 2 znaki.");
            hasError = true;
        }

        if (!inputEmail.checkValidity() || inputEmail.value.trim() === "") {
            setError(inputEmail, "error-email", "Wprowadź poprawny adres e-mail.");
            hasError = true;
        }

        const telVal = inputTelefon.value.trim();
        const telRegex = /^[0-9+\s-]{9,15}$/;
        if (telVal === "") {
            setError(inputTelefon, "error-telefon", "Podaj numer telefonu.");
            hasError = true;
        } else if (!telRegex.test(telVal)) {
            setError(inputTelefon, "error-telefon", "Niepoprawny numer telefonu (wymagane 9-15 cyfr).");
            hasError = true;
        }

        if (inputData.value === "") {
            setError(inputData, "error-data_kontaktu", "Wybierz datę kontaktu.");
            hasError = true;
        }

        if (inputHaslo.value.length < 4) {
            setError(inputHaslo, "error-haslo", "Hasło musi mieć co najmniej 4 znaki.");
            hasError = true;
        }

        if (selectTemat.value === "") {
            setError(selectTemat, "error-temat", "Wybierz temat wiadomości.");
            hasError = true;
        }

        if (inputWiadomosc.value.trim() === "") {
            setError(inputWiadomosc, "error-wiadomosc", "Wpisz treść wiadomości.");
            hasError = true;
        }

        if (!inputZgoda.checked) {
            setError(inputZgoda, "error-zgoda", "Musisz zaakceptować regulamin.");
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
            errorCount++;
            localStorage.setItem("formErrorCount", errorCount);
            updateStatsDisplay();
        } else {
            successCount++;
            localStorage.setItem("formSuccessCount", successCount);
        }
    });
});