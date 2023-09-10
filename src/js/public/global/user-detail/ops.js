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
