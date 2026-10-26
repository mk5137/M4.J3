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
        const remaining = maxLen - currentLen;
        charCountSpan.textContent = remaining;
    });

    
    form.addEventListener("submit", function (e) {
        let hasError = false;

        
        document.querySelectorAll(".error-msg").forEach(el => el.textContent = "");

        
        const imieVal = inputImie.value.trim();
        if (imieVal === "") {
            document.getElementById("error-imie").textContent = "Pole imię nie może być puste.";
            hasError = true;
        } else if (imieVal.length < 2) {
            document.getElementById("error-imie").textContent = "Imię musi mieć co najmniej 2 znaki.";
            hasError = true;
        }

        
        if (!inputEmail.checkValidity() || inputEmail.value.trim() === "") {
            document.getElementById("error-email").textContent = "Wprowadź poprawny adres e-mail.";
            hasError = true;
        }

        
        if (selectTemat.value === "") {
            document.getElementById("error-temat").textContent = "Wybierz temat wiadomości.";
            hasError = true;
        }

        
        if (inputWiadomosc.value.trim() === "") {
            document.getElementById("error-wiadomosc").textContent = "Wpisz treść wiadomości.";
            hasError = true;
        }

        
        if (!inputZgoda.checked) {
            document.getElementById("error-zgoda").textContent = "Musisz zaakceptować regulamin.";
            hasError = true;
        }

        
        if (hasError) {
            e.preventDefault(); 
        }
    });
});