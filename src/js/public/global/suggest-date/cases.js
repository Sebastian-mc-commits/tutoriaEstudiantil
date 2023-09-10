import { contextApp } from "../reducer.js"
import { modal } from "./index.js"

export const suggestSchedule = ({ getContextId, target }) => {

    if (!modal.isModalBuild) return
    modal.toggleModal({})
    contextApp.current = {
        ...contextApp.current,
        mentoringId: getContextId(false),
        buttonTarget: target
    }
}

export const onScheduleReady = async (form) => {
    const formData = new FormData(form)
    const data = Object.fromEntries(formData)

    const { mentoringId, buttonTarget } = contextApp.current
    const mergeData = {
        ...data,
        MENTORING_ID: mentoringId
    }

    buttonTarget.disabled = true
    const request = await fetch("../controllers/ScheduleController.php?type=suggestSchedule", {
        headers: {
            "Content-Type": "application/json"
        },
        method: "POST",
        body: JSON.stringify(mergeData)
    })

    buttonTarget.disabled = true
    const result = await request?.json()

    if (request.ok && "status" in result && result.status) {
        buttonTarget.textContent = "Horario sugerido"
        return
    }

    buttonTarget.disabled = false
    console.log(data)
}