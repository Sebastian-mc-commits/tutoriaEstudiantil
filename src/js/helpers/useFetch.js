
export const useFetch = async ({url, fetchObject = {}, getJson = true, afterRequest = () => { }}) => {

    let request = null
    let result = null
    let error = false
    let extraDataReturn = null
    try {
        request = await fetch(url, fetchObject)
        
        if (!request.ok) {
            error = true
        }
        else if (getJson) {
            result = await request.json()
        }

        if (typeof afterRequest !== "null") {
            extraDataReturn = await afterRequest(request)
        }
    }
    catch {
        error = true
    }

    return {
        request,
        result,
        error,
        extraDataReturn
    }
}

export default async function multipleFetch (...dataToFetch) {
    const data = []

    for await (const fetchData of dataToFetch) {
        const getData = await useFetch(fetchData)
        data.push(getData)
    }
    return data
}
