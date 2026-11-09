<?php
$errors = [];
$showCard = false;

$imie = '';
$klasa = '';
$sila = '';
$zrecznosc = '';
$inteligencja = '';
$hp = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imie = trim($_POST['imie'] ?? '');
    $klasa = trim($_POST['klasa'] ?? '');
    $sila = filter_var($_POST['sila'] ?? null, FILTER_VALIDATE_INT);
    $zrecznosc = filter_var($_POST['zrecznosc'] ?? null, FILTER_VALIDATE_INT);
    $inteligencja = filter_var($_POST['inteligencja'] ?? null, FILTER_VALIDATE_INT);

    if (empty($imie)) {
        $errors[] = "Imię postaci jest wymagane.";
    }

    $dozwoloneKlasy = ['Wojownik', 'Mag', 'Łotrzyk'];
    if (!in_array($klasa, $dozwoloneKlasy)) {
        $errors[] = "Wybierz poprawną klasę postaci.";
    }

    if ($sila === false || $sila < 1 || $sila > 20) {
        $errors[] = "Siła musi być liczbą z zakresu 1–20.";
    }

    if ($zrecznosc === false || $zrecznosc < 1 || $zrecznosc > 20) {
        $errors[] = "Zręczność musi być liczbą z zakresu 1–20.";
    }

    if ($inteligencja === false || $inteligencja < 1 || $inteligencja > 20) {
        $errors[] = "Inteligencja musi być liczbą z zakresu 1–20.";
    }

    if (empty($errors)) {
        $hp = ($sila * 10) + ($zrecznosc * 2);
        $showCard = true;
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kreator Postaci RPG</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background-color: #121214;
            color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
            max-width: 450px;
        }

        .rpg-box {
            background-color: #1c1c24;
            border: 3px solid #444454;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.7);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #d4af37;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 6px;
            font-size: 0.95rem;
            color: #aaaaaa;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            background-color: #2a2a36;
            border: 1px solid #444454;
            border-radius: 6px;
            color: #ffffff;
            font-size: 1rem;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #d4af37;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #d4af37;
            color: #121214;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            transition: background-color 0.2s;
            margin-top: 10px;
        }

        button:hover {
            background-color: #b3922e;
        }

        .error-box {
            background-color: #4a1515;
            border: 1px solid #8b0000;
            color: #ff9999;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .error-box ul {
            list-style-position: inside;
        }

        /* Stylizacja karty postaci */
        .card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 10px;
        }

        .card-header {
            grid-column: span 2;
            text-align: center;
            border-bottom: 2px solid #333344;
            padding-bottom: 10px;
            margin-bottom: 5px;
        }

        .card-header h3 {
            font-size: 1.6rem;
            color: #ffffff;
        }

        .card-header .class-badge {
            font-style: italic;
            color: #d4af37;
        }

        .stat-box {
            background-color: #262634;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #38384d;
        }

        .stat-box.full-width {
            grid-column: span 2;
            background-color: #2d1f2d;
            border-color: #662244;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #8888a0;
            text-transform: uppercase;
            display: block;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 1.3rem;
            font-weight: bold;
            color: #ffffff;
        }

        .stat-box.full-width .stat-value {
            color: #ff4d4d;
            font-size: 1.5rem;
        }

        /* Kolory obramowań klas */
        .border-wojownik {
            border-color: #e63946 !important;
            box-shadow: 0 0 15px rgba(230, 57, 70, 0.3) !important;
        }

        .border-mag {
            border-color: #457b9d !important;
            box-shadow: 0 0 15px rgba(69, 123, 157, 0.3) !important;
        }

        .border-lotrzyk {
            border-color: #2a9d8f !important;
            box-shadow: 0 0 15px rgba(42, 157, 143, 0.3) !important;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="rpg-box" id="formBox">
        <h2>Stwórz Bohatera</h2>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="imie">Imię postaci:</label>
                <input type="text" id="imie" name="imie" required value="<?php echo htmlspecialchars($imie); ?>">
            </div>

            <div class="form-group">
                <label for="klasa">Klasa:</label>
                <select id="klasa" name="klasa" required>
                    <option value="">-- Wybierz klasę --</option>
                    <option value="Wojownik" <?php echo $klasa === 'Wojownik' ? 'selected' : ''; ?>>Wojownik</option>
                    <option value="Mag" <?php echo $klasa === 'Mag' ? 'selected' : ''; ?>>Mag</option>
                    <option value="Łotrzyk" <?php echo $klasa === 'Łotrzyk' ? 'selected' : ''; ?>>Łotrzyk</option>
                </select>
            </div>

            <div class="form-group">
                <label for="sila">Siła (1-20):</label>
                <input type="number" id="sila" name="sila" min="1" max="20" required value="<?php echo htmlspecialchars($sila); ?>">
            </div>

            <div class="form-group">
                <label for="zrecznosc">Zręczność (1-20):</label>
                <input type="number" id="zrecznosc" name="zrecznosc" min="1" max="20" required value="<?php echo htmlspecialchars($zrecznosc); ?>">
            </div>

            <div class="form-group">
                <label for="inteligencja">Inteligencja (1-20):</label>
                <input type="number" id="inteligencja" name="inteligencja" min="1" max="20" required value="<?php echo htmlspecialchars($inteligencja); ?>">
            </div>

            <button type="submit">Generuj Kartę</button>
        </form>
    </div>

    <?php if ($showCard): ?>
        <div class="rpg-box" id="cardBox">
            <h2>Karta Postaci</h2>
            <div class="card">
                <div class="card-header">
                    <h3><?php echo htmlspecialchars($imie); ?></h3>
                    <span class="class-badge"><?php echo htmlspecialchars($klasa); ?></span>
                </div>

                <div class="stat-box full-width">
                    <span class="stat-label">Punkty Życia (HP)</span>
                    <span class="stat-value"><?php echo $hp; ?></span>
                </div>

                <div class="stat-box">
                    <span class="stat-label">Siła</span>
                    <span class="stat-value"><?php echo $sila; ?></span>
                </div>

                <div class="stat-box">
                    <span class="stat-label">Zręczność</span>
                    <span class="stat-value"><?php echo $zrecznosc; ?></span>
                </div>

                <div class="stat-box full-width">
                    <span class="stat-label">Inteligencja</span>
                    <span class="stat-value"><?php echo $inteligencja; ?></span>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const klasaSelect = document.getElementById('klasa');
        const formBox = document.getElementById('formBox');
        const cardBox = document.getElementById('cardBox');

        function updateBorderColor(selectedClass) {
            const boxes = [formBox];
            if (cardBox) boxes.push(cardBox);

            boxes.forEach(box => {
                box.classList.remove('border-wojownik', 'border-mag', 'border-lotrzyk');
                if (selectedClass === 'Wojownik') {
                    box.classList.add('border-wojownik');
                } else if (selectedClass === 'Mag') {
                    box.classList.add('border-mag');
                } else if (selectedClass === 'Łotrzyk') {
                    box.classList.add('border-lotrzyk');
                }
            });
        }

        klasaSelect.addEventListener('change', (e) => {
            updateBorderColor(e.target.value);
        });

        updateBorderColor(klasaSelect.value);
    });
</script>

</body>
</html>