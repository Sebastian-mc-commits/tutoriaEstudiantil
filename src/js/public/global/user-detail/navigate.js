
export const navigateToSuggestedSchedules = ({context: {scrollViewNavigate}}) => {
    const suggestedSchedulesContainer = document.querySelector("#suggestedSchedules")

    scrollViewNavigate(suggestedSchedulesContainer)
}

export const selectedClassInformation = ({getContextId}) => {
    const id = getContextId(false)

    location.href = `index.php?page=render-created-class&tree=mentor&id=${id}`
}