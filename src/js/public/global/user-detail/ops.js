export const acceptSchedule = async ({ getContextId, target }) => {

    const scheduleId = getContextId(false)
    const request = await fetch("../controllers/ScheduleController.php?type=acceptSchedule", {
        method: "POST",
        headers: {
            "Content-Type": "application/jon"
        },
        body: JSON.stringify({
            scheduleId
        })
    })

    if (!request.ok) {
        return
    }

    const response = await request.json()

    if ("status" in response && response.status) {
        target.parentElement.remove()
    }
}

export const scrollViewNavigate = (container, backgroundColor = "var(--ISlateCharcoal)") => {
    
    container.hidden = false
    
    container.scrollIntoView({
        behavior: "smooth"
    })
    
    document.body.style.backgroundColor = backgroundColor
}

export const goBack = ({target}) => {
    const container = target.parentElement
    
    document.body.style.backgroundColor = "#FFF"
    
    container.hidden = true
}

export const scrollBy = (container, { x, y }) => {

    container.style.transform = `translate(${x}, ${y})`
}