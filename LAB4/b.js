/*Zadanie 5*/
function dodajElement(tekst) {
  if (!tekst || tekst.trim() === "") return;

  const li = document.createElement("li");
  li.textContent = tekst;

  const lista = document.getElementById("lista");
  lista.appendChild(li);
}



/*Zadanie 6*/
const lista = document.getElementById("lista");

lista.addEventListener("click", function (e) {
  if (e.target.tagName === "BUTTON") {
    const li = e.target.closest("li");
    if (li) {
      li.remove();
    }
  }
});


/*Zadanie 7*/
const lista = document.getElementById("lista");

lista.addEventListener("click", function (e) {
  if (e.target.tagName === "BUTTON") {
    return;
  }

  const li = e.target.closest("li");
  if (li && lista.contains(li)) {
    li.classList.toggle("wykonane");
  }
});


/*Zadanie 8*/
const szukajInput = document.getElementById("szukaj");
const elementyListy = Array.from(document.querySelectorAll("#lista li"));

szukajInput.addEventListener("input", function (e) {
  const fragment = e.target.value.toLowerCase();

  elementyListy.filter((li) => {
    const tekst = li.textContent.toLowerCase();
    const pasuje = tekst.includes(fragment);
    li.style.display = pasuje ? "" : "none";
    return pasuje;
  });
});


/*Zadanie 9*/
let zadania = [
  { id: 1, nazwa: "Kupić mleko" },
  { id: 2, nazwa: "Zrobić trening" },
  { id: 3, nazwa: "Odrobić lekcje" }
];

function renderujListe(tablica) {
  const lista = document.getElementById("lista");
  lista.innerHTML = "";
  tablica.forEach((zadanie) => {
    const li = document.createElement("li");
    li.textContent = zadanie.nazwa;
    lista.appendChild(li);
  });
}

const przyciskAZ = document.getElementById("sortuj-az");
const przyciskZA = document.getElementById("sortuj-za");

przyciskAZ.addEventListener("click", function () {
  zadania.sort((a, b) => a.nazwa.localeCompare(b.nazwa, "pl"));
  renderujListe(zadania);
});

przyciskZA.addEventListener("click", function () {
  zadania.sort((a, b) => b.nazwa.localeCompare(a.nazwa, "pl"));
  renderujListe(zadania);
});




/*Zadanie 10*/
const KLUCZ_STORAGE = "listaZadan";

function zapiszDoStorage(tablicaZadan) {
  localStorage.setItem(KLUCZ_STORAGE, JSON.stringify(tablicaZadan));
}

function odczytajZStorage() {
  const dane = localStorage.getItem(KLUCZ_STORAGE);
  if (!dane) {
    return [];
  }
  try {
    return JSON.parse(dane);
  } catch (error) {
    return [];
  }
}

let mojeZadania = odczytajZStorage();