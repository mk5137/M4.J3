<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz kontaktowy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h1>Formularz kontaktowy</h1>
        
        <div class="stats-box">
            Próby wysłania — Sukcesy: <span id="statSuccess">0</span> | Błędy: <span id="statError">0</span>
        </div>

        <form id="contactForm" action="odbierz.php" method="post" novalidate>
            <div class="form-group">
                <label for="imie">Imię:</label>
                <input type="text" id="imie" name="imie" required>
                <div class="error-msg" id="error-imie"></div>
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="jan.kowalski@example.com" required>
                <div class="error-msg" id="error-email"></div>
            </div>

            <div class="form-group">
                <label for="telefon">Numer telefonu:</label>
                <input type="tel" id="telefon" name="telefon" placeholder="123456789" required>
                <div class="error-msg" id="error-telefon"></div>
            </div>

            <div class="form-group">
                <label for="data_kontaktu">Preferowana data kontaktu:</label>
                <input type="date" id="data_kontaktu" name="data_kontaktu" required>
                <div class="error-msg" id="error-data_kontaktu"></div>
            </div>

            <div class="form-group">
                <label for="haslo">Hasło:</label>
                <div class="password-wrapper">
                    <input type="password" id="haslo" name="haslo" required>
                    <button type="button" id="togglePassword">Pokaż</button>
                </div>
                <div class="error-msg" id="error-haslo"></div>
            </div>

            <div class="form-group">
                <label for="temat">Temat wiadomości:</label>
                <select id="temat" name="temat" required>
                    <option value="">-- Wybierz temat --</option>
                    <option value="Zapytanie ogólne">Zapytanie ogólne</option>
                    <option value="Wsparcie techniczne">Wsparcie techniczne</option>
                    <option value="Współpraca">Współpraca</option>
                </select>
                <div class="error-msg" id="error-temat"></div>
            </div>

            <div class="form-group">
                <label for="wiadomosc">Wiadomość:</label>
                <textarea id="wiadomosc" name="wiadomosc" rows="3" maxlength="200" required></textarea>
                <div class="char-counter">Pozostało znaków: <span id="charCount">200</span>/200</div>
                <div class="error-msg" id="error-wiadomosc"></div>
            </div>

            <div class="form-group checkbox-group">
                <label for="zgoda">
                    <input type="checkbox" id="zgoda" name="zgoda" value="tak" required>
                    Akceptuję regulamin
                </label>
                <div class="error-msg" id="error-zgoda"></div>
            </div>

            <div class="buttons-group">
                <button type="submit" id="btnSubmit">Wyślij</button>
                <button type="reset" id="btnReset">Wyczyść formularz</button>
            </div>

            <button type="button" id="btnTest">Testuj imię (Podgląd)</button>
        </form>

        <div id="greeting" class="greeting-box"></div>
    </div>

    <script src="script.js"></script>
</body>
</html>