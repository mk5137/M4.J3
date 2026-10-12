function debounce(fn, delay) {
  let timeoutId;
  return function (...args) {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => {
      fn.apply(this, args);
    }, delay);
  };
}

class ProductSearch {
  constructor(inputElement, resultsElement) {
    this.inputElement = inputElement;
    this.resultsElement = resultsElement;
    this.currentController = null;

    this.inputElement.addEventListener(
      'input',
      debounce(this.handleSearch.bind(this), 400)
    );
  }

  async handleSearch(event) {
    const query = event.target.value.trim();
    if (!query) {
      this.resultsElement.innerHTML = '';
      return;
    }

    if (this.currentController) {
      this.currentController.abort();
    }

    this.currentController = new AbortController();
    const { signal } = this.currentController;

    try {
      const response = await fetch(`/api/products?search=${encodeURIComponent(query)}`, { signal });
      if (!response.ok) throw new Error("Błąd sieci");

      const products = await response.json();
      this.renderProducts(products);
    } catch (error) {
      if (error.name !== 'AbortError') {
        console.error('Błąd pobierania produktów:', error);
      }
    }
  }

  renderProducts(products) {
    this.resultsElement.innerHTML = '';
    const fragment = document.createDocumentFragment();

    products.forEach((product) => {
      const li = document.createElement('li');
      li.textContent = `${product.name} - ${product.price} zł`;
      fragment.appendChild(li);
    });

    this.resultsElement.appendChild(fragment);
  }
}