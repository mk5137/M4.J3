async function pobierzDane() {
  try {
    const response = await fetch("pobierz_zadania.php");

    if (!response.ok) {
      throw new Error(`Błąd HTTP: ${response.status}`);
    }

    const dane = await response.json();
    const lista = document.getElementById("lista");
    lista.innerHTML = "";

    dane.forEach((item) => {
      const li = document.createElement("li");
      li.textContent = item.nazwa;
      lista.appendChild(li);
    });
  } catch (error) {
    console.error("Wystąpił błąd podczas pobierania danych:", error);
  }
}

pobierzDane();