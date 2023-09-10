export const getId = (id) => isNaN(id) ? id : parseInt(id)

export const validateIds = (...ids) => ids.every(id => getId(id) === getId(ids[0]))

export const lowerCase = (string = "") => string.split("_").map((str, index) => 
index === 0 ? str.toLowerCase() : str[0].toUpperCase() + str.slice(1).toLowerCase()).join("")