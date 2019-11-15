const each = (collection, handler) => {
  return collection && (Array.isArray(collection) ? collection.forEach(handler) : Object.keys(collection).forEach(function(key) {
    return handler(collection[key], key)
  }))
}
const deepClone = obj => {
  let temp = null
  if (obj && obj instanceof Array) {
    temp = []
    temp = obj.map(function(item) {
      return deepClone(item)
    })
  } else if (obj && typeof obj === 'object') { // typeof null 的值是 object
    temp = {}
    for (const item in obj) {
      temp[item] = deepClone(obj[item])
    }
  } else {
    temp = obj
  }
  return temp
}
const object2Array = obj => {
  const arr = []
  for (const i in obj) {
    // const o = {}
    // o[i] = obj[i]
    // arr.push(o)
    arr[i] = obj[i]
  }
  return arr
}

module.exports = {
  object2Array,
  deepClone,
  each
}
