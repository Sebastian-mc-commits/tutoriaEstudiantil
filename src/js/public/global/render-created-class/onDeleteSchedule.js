import { domUtilities, useFetch } from "../../../helpers/index.js"

const {useLoader, disableLoader} = domUtilities
export const handleDeleteSchedule = async ({target, getContextId}) => {

  useLoader(target)
  const {error, result: {isDeleted}} = await useFetch({
    url: "../controllers/ScheduleController.php?type=deleteScheduleJson",
    fetchObject: {
      headers: {
        "Content-Type": "application/json"
      },
      method: "DELETE",
      body: JSON.stringify({
        id: getContextId(false, "[data-date-id]")
      })
    }
  })

  disableLoader(target)
  if (error || !isDeleted) return

  target.parentElement.parentElement.remove()
}