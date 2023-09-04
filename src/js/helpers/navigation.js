export const currentFileName = () => {
  const splitPath = document.location.pathname.split(/\//g)

  const criteria = new RegExp(/(\.php|\.html)/g)
  const viewName = splitPath.find(val => criteria.test(val))
  return viewName.replace(criteria, "")
}

export const getUrlParams = () => {
  const search = window.location.search.substring(1); // Get the query string excluding the "?" character
  const params = {};

  if (search) {
    const paramPairs = search.split('&'); // Split the query string into parameter-value pairs

    for (const paramPair of paramPairs) {
      const [param, value] = paramPair.split('=');
      params[param] = decodeURIComponent(value); // Decoding URI component
    }
  }

  return params;
}

export const setLinkStyles = (url = "", d = document) => {
  const setUrl = url?.replace(/.js$/g, ".css");
  if (
    Array.from(d.querySelectorAll("link[rel='stylesheet']")).some(
      ({
        href
      }) => href === setUrl
    )
  ) {
    return;
  }
  const link = d.createElement("link");

  link.rel = "stylesheet";
  link.href = setUrl;

  d.head.appendChild(link);
};

export const getPath = (extname, url = "") => {
  return url?.replace(/.js$/g, extname);
}

export const getFile = (fileName, extname, url = "") => {
  const folderPath = url.split("/").slice(0, -1).join("/")
  const filePath = `${folderPath}/${fileName}.${extname}`
  return filePath
}