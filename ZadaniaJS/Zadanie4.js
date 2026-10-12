class EventEmitter {
  constructor() {
    this.events = new Map();
  }

  on(eventName, listener) {
    if (!this.events.has(eventName)) {
      this.events.set(eventName, []);
    }
    this.events.get(eventName).push(listener);
    return this;
  }

  emit(eventName, ...args) {
    if (!this.events.has(eventName)) return false;
    const listeners = [...this.events.get(eventName)];
    listeners.forEach(listener => listener(...args));
    return true;
  }

  off(eventName, listener) {
    if (!this.events.has(eventName)) return this;

    const listeners = this.events.get(eventName);
    const filtered = listeners.filter(fn => fn !== listener && fn.originalListener !== listener);

    if (filtered.length === 0) {
      this.events.delete(eventName);
    } else {
      this.events.set(eventName, filtered);
    }

    return this;
  }

  once(eventName, listener) {
    const wrapper = (...args) => {
      this.off(eventName, wrapper);
      listener(...args);
    };
    
    wrapper.originalListener = listener;
    return this.on(eventName, wrapper);
  }
}