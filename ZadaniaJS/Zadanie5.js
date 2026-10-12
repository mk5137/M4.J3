function deepClone(obj, hash = new WeakMap()) {
  if (Object(obj) !== obj) return obj;

  if (obj instanceof Date) return new Date(obj);
  if (obj instanceof RegExp) return new RegExp(obj.source, obj.flags);

  if (hash.has(obj)) return hash.get(obj);

  const clone = Array.isArray(obj) ? [] : Object.create(Object.getPrototypeOf(obj));
  hash.set(obj, clone);

  const keys = [...Object.keys(obj), ...Object.getOwnPropertySymbols(obj)];

  for (const key of keys) {
    clone[key] = deepClone(obj[key], hash);
  }

  return clone;
}