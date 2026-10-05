let wszystkieZadania = [];

async function inwalidujListe() {
  try {
    const res = await fetch("db.php");
    if (!res.ok) throw new Error("Błąd pobierania danych");
    wszystkieZadania = await res.json();
    renderuj(wszystkieZadania);
  } catch (err) {
    console.error(err);
  }
}

function renderuj(zadania) {
  const lista = document.getElementById("lista");
  lista.innerHTML = "";

  zadania.forEach((zadanie) => {
    const li = document.createElement("li");
    li.dataset.id = zadanie.id;
    if (zadanie.wykonane) li.classList.add("wykonane");

    const span = document.createElement("span");
    span.textContent = zadanie.nazwa;

    const btn = document.createElement("button");
    btn.textContent = "Usuń";
    btn.className = "przycisk-usun";

    li.appendChild(span);
    li.appendChild(btn);
    lista.appendChild(li);
  });
}

const listaUI = document.getElementById("lista");

listaUI.addEventListener("click", (e) => {
  const li = e.target.closest("li");
  if (!li) return;

  if (e.target.tagName === "BUTTON") {
    const id = Number(li.dataset.id);
    wszystkieZadania = wszystkieZadania.filter((item) => item.id !== id);
    renderuj(wszystkieZadania);
  } else {
    li.classList.toggle("wykonane");
  }
});

const szukajInput = document.getElementById("szukaj");
szukajInput.addEventListener("input", (e) => {
  const filtr = e.target.value.toLowerCase();
  const przefiltrowane = wszystkieZadania.filter((z) =>
    z.nazwa.toLowerCase().includes(filtr)
  );
  renderuj(przefiltrowane);
});

inwalidujListe();