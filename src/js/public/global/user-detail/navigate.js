import { domUtilities, useFetch } from "../../../helpers/index.js"

const {useLoader, disableLoader, scrollViewNavigate} = domUtilities
export const navigateToSuggestedSchedules = () => {
    const suggestedSchedulesContainer = document.querySelector("#suggestedSchedules")

    scrollViewNavigate(suggestedSchedulesContainer)
}

export const selectedClassInformation = ({getContextId}) => {
    const id = getContextId(false)

    location.href = `index.php?page=render-created-class&tree=mentor&id=${id}`
}

export const onDeleteClass = async ({getContextId, target, context}) => {

    const id = getContextId(false)
    useLoader(target)
    const {error, result: {isDeleted} } = await useFetch({
        url: "../controllers/ClassController.php?type=deleteClassJson",
        fetchObject: {
            headers: {
                "Content-type": "application/json"
            },
            method: "DELETE",
            body: JSON.stringify({id})
        }
    })

    disableLoader(target)
    if (error) {
        const prevText = target.innerText
        target.innerText = "Error al eliminar"
        setTimeout(() => {
            target.innerText = prevText
        }, 1000)
    }
    else if (isDeleted) {
        target.closest("section").remove()
        context.moveCreatedClassesContainer({context})
    }

    target.disable = false
}

export const goBack = ({target}) => {
    const container = target.parentElement
    
    document.body.style.backgroundColor = "#FFF"
    
    container.hidden = true
}