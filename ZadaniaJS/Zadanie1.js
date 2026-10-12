async function fetchWithCache(url, ttlMs) {
  const cacheKey = `cache_${url}`;
  const now = Date.now();
  
  const cachedRaw = localStorage.getItem(cacheKey);
  let cachedData = null;

  if (cachedRaw) {
    try {
      cachedData = JSON.parse(cachedRaw);
    } catch (e) {}
  }

  if (cachedData && (now - cachedData.timestamp < ttlMs)) {
    return cachedData.payload;
  }

  try {
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error(`Błąd HTTP: ${response.status}`);
    }
    
    const payload = await response.json();
    localStorage.setItem(cacheKey, JSON.stringify({ timestamp: now, payload }));

    return payload;
  } catch (error) {
    if (cachedData) {
      console.warn("Brak połączenia lub błąd zapytania. Zwracanie przestarzałego cache:", error);
      return cachedData.payload;
    }
    
    throw error;
  }
}