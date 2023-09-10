import { navigation, domUtilities, multipleFetch } from "../../../helpers/index.js"

const { getFile } = navigation
const { setHTML, useLoader, disableLoader, scrollBy, scrollViewNavigate } = domUtilities

export const navigateToCreatedClasses = async ({ target }) => {
    const createdClassesContainer = document.querySelector("#createdClasses")

    useLoader(target)
    const [{ error: dataError, result: { data } }, { error: htmlError, extraDataReturn: componentHTML }] = await multipleFetch(
        {
            url: "../controllers/ClassController.php?type=getClassesJson"
        },
        {
            url: getFile("html/classElement", "html", import.meta.url),
            getJson: false,
            afterRequest: (request) => request.text()
        }
    )
    if (dataError || htmlError) {
        return
    }

    let HTML = ""
    for (const {id, ...ops} of data) {
        const { element } = setHTML({
            html: componentHTML,
            iterator: (child, datasetValue) => {
                if (datasetValue === "id") {
                    child.dataset.globalId = id
                    return
                }
                child.textContent = ops[datasetValue]
            },
        })
        
        HTML += element.outerHTML
    }
    const createdClassesNav = createdClassesContainer.querySelector("nav")
    createdClassesNav.innerHTML = HTML
    
    createdClassesContainer.hidden = false
    setTimeout(() => {
        scrollBy(createdClassesContainer, {
            x: "100%",
            y: 0
        })
        disableLoader(target)
        document.body.style.backgroundColor = "var(--C_greenishBlue)"
    }, 500)

}

export const navigateToTodaysClasses = async ({ target }) => {
    const todaysClassesContainer = document.querySelector("#todaysClasses")
    useLoader(target)

    const [{ error: dataError, result: { data } }, { error: htmlError, extraDataReturn: componentHTML }] = await multipleFetch(
        {
            url: "../controllers/ClassController.php?type=tutorTodaysClasses",
        },
        {
            url: getFile("html/todaysClasses", "html", import.meta.url),
            getJson: false,
            afterRequest: (request) => request.text()
        }
    )

    disableLoader(target)
    if (dataError || htmlError) {
        return
    }

    let HTML = ""
    for (const { isAccepted, accessLink, ...ops } of data) {
        const { element } = setHTML({
            html: componentHTML,
            iterator: (child, datasetValue) => {
                if (datasetValue === "isAccepted") {
                    child.classList.add(isAccepted === 0 ? "isNotAccepted" : "isAccepted")
                }
                else if (datasetValue === "accessLink") {
                    child.href = accessLink
                }
                else {
                    child.textContent = ops[datasetValue]
                }
            },
        })
        
        HTML += element.outerHTML
    }
    
    scrollViewNavigate(todaysClassesContainer)
    todaysClassesContainer.querySelector("nav").innerHTML = HTML

}

export const moveCreatedClassesContainer = () => {
    const createdClassesContainer = document.querySelector("#createdClasses")
    scrollBy(createdClassesContainer, {
        x: "-100%",
        y: 0
    })

    document.body.style.backgroundColor = "var(--white)"

    setTimeout(() => {
        createdClassesContainer.hidden = true
    }, 500)

}