import {
  onSubmitData
} from "../../create-class/index.js"
import {
  contextApp
} from "../reducer.js"
import {
  modal
} from "./index.js"

export const addSchedule = ({
  target
}) => {
  modal.toggleModal({})
  contextApp.__current__ = {
    ...contextApp.current,
    scheduleTarget: target
  }
}

export const onDoneSelected = async () => {
  const form = modal.modalBodyInserted()
  const formData = new FormData(form)
  const data = Object.fromEntries(formData)
  const newElement = document.createElement("div")

  newElement.innerHTML = scheduleCreatedElement(data)

  contextApp.current.scheduleTarget.replaceWith(newElement)

  newElement.insertAdjacentHTML("afterend", addScheduleHtml())

  onSubmitData.current = {
    ...onSubmitData.current,
    schedules: [...onSubmitData.current.schedules, Object.values(data)]
  }

}

const scheduleCreatedElement = ({
  DATE,
  ENDS_IN,
  ACCESS_LINK,
  CLASS_COMMENT
}) => `
  <div class="card schedule-created">
  <h2>${DATE}</h2>
  <p class="textOpacity opacityHover">${ENDS_IN}</p>
  <p class="textOpacity">${CLASS_COMMENT}</p>
  <p class="borderCard access-link">${ACCESS_LINK}</p>
  </div>
`

const addScheduleHtml = () => `
  <p class="card textOpacity opacityHover" data-global-type="addSchedule">
    Agregar Horario
  </p>
`

export const createClass = async ({
  event,
  target
}) => {
  event.preventDefault()

  target.disabled = true
  const request = await fetch("../controllers/ClassController.php?type=createClass", {
    headers: {
      "Content-Type": "application/json"
    },
    method: "POST",
    body: JSON.stringify(onSubmitData.current)
  })
  
  target.disabled = false
  const result = await request?.json()

  if (request.ok && "status" in result && result.status) {
    location.reload()
    return
  }

}