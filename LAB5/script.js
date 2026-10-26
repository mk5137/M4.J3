// 11. Podłączenie skryptu i test w konsoli
console.log("Skrypt działa");

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("contactForm");
    const inputImie = document.getElementById("imie");
    const inputEmail = document.getElementById("email");
    const inputWiadomosc = document.getElementById("wiadomosc");
    const inputZgoda = document.getElementById("zgoda");
    const selectTemat = document.getElementById("temat");
    
    const btnTest = document.getElementById("btnTest");
    const greetingDiv = document.getElementById("greeting");
    const charCountSpan = document.getElementById("charCount");

    // 12. & 13. Pobranie wartości i powitanie po kliknięciu przycisku testowego
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

    // 14. & 15. Licznik znaków i limit wiadomości
    const maxLen = 200;
    inputWiadomosc.addEventListener("input", function () {
        const currentLen = inputWiadomosc.value.length;
        const remaining = maxLen - currentLen;
        charCountSpan.textContent = remaining;
    });

    // 16–20. Walidacja przy wysyłaniu formularza
    form.addEventListener("submit", function (e) {
        let hasError = false;

        // Czyszczenie poprzednich błędów
        document.querySelectorAll(".error-msg").forEach(el => el.textContent = "");

        // 16. & 17. Walidacja imienia (puste / min. 2 znaki)
        const imieVal = inputImie.value.trim();
        if (imieVal === "") {
            document.getElementById("error-imie").textContent = "Pole imię nie może być puste.";
            hasError = true;
        } else if (imieVal.length < 2) {
            document.getElementById("error-imie").textContent = "Imię musi mieć co najmniej 2 znaki.";
            hasError = true;
        }

        // 18. Walidacja e-maila (checkValidity)
        if (!inputEmail.checkValidity() || inputEmail.value.trim() === "") {
            document.getElementById("error-email").textContent = "Wprowadź poprawny adres e-mail.";
            hasError = true;
        }

        // Walidacja tematu
        if (selectTemat.value === "") {
            document.getElementById("error-temat").textContent = "Wybierz temat wiadomości.";
            hasError = true;
        }

        // Walidacja wiadomości
        if (inputWiadomosc.value.trim() === "") {
            document.getElementById("error-wiadomosc").textContent = "Wpisz treść wiadomości.";
            hasError = true;
        }

        // 19. Zgoda użytkownika (checked)
        if (!inputZgoda.checked) {
            document.getElementById("error-zgoda").textContent = "Musisz zaakceptować regulamin.";
            hasError = true;
        }

        // 20. Komunikaty i kontrola wysyłki
        if (hasError) {
            e.preventDefault(); // Blokujemy wysyłanie, gdy są błędy
        }
    });
});