
export const setRandomColorBetween = (colors = [], elementQueryId = '#randomColorElement') => {
    const elements = document.querySelectorAll(elementQueryId)
    const randomNumber = () => Math.floor(Math.random() * colors.length)
    const randomColor = () => colors[randomNumber()]

    Array.from(elements).forEach(child => {
        child.style.backgroundColor = randomColor()
    })
}

export const mutateDOM = (element, {
    errorCase,
    successCase = () => { },
    displayAlways = () => { }
}, timeOut = 200) => {

    if (!!element) {
        displayAlways()
    }
    else {
        errorCase()
        displayAlways()
    }


    setTimeout(successCase, timeOut)
}

export const setHTML = ({html, element = "div", iterator}) => {
    const parent = document.createElement(element)
    parent.innerHTML = html

    const parentChildren = parent.querySelectorAll("[data-html]")

    Array.from(parentChildren).forEach(child => {
        iterator(child, child.dataset.html)
    })

    return {
        parent,
        element: parent.firstElementChild
    }
}

export const useLoader = (target) => {
    const loaderElement = `
    <div class="loader" id='loader'>
    <div>
        <div>
        <div>
            <div>
            <div>
                <div>
                <div>
                    <div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
    `
    target.disabled = true
    target.insertAdjacentHTML("beforeend", loaderElement)
}

export const disableLoader = (target) => {
    const loader = target.querySelector("#loader")
    target.disabled = false
    if (!loader) return

    loader.remove()
}

export const scrollViewNavigate = (container, backgroundColor = "var(--ISlateCharcoal)") => {
    
    container.hidden = false
    
    container.scrollIntoView({
        behavior: "smooth"
    })
    
    document.body.style.backgroundColor = backgroundColor
}

export const scrollBy = (container, { x, y }) => {

    container.style.transform = `translate(${x}, ${y})`
}

export const convertToDataset = (string = "") => string.replace(/[\[\]]/g, '').split("-").slice(1).map((st, index) =>
index === 0 ? st : st[0].toUpperCase() + st.substring(1, st.length)).join("")