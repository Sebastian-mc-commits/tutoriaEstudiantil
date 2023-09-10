import {
  modal
} from "./index.js"
import {
  domUtilities,
  multipleFetch,
  navigation,
  useFetch,
  utilities,
} from "../../../helpers/index.js"

const {
  getFile
} = navigation
const {
  useLoader,
  disableLoader,
  setHTML
} = domUtilities

const {lowerCase} = utilities
export const handleUpdateSchedule = async ({
  target,
  getContextId,
  context: {contextMethods},
  getFormData
}) => {

  useLoader(target)

  const [{
    error,
    result
  }, {
    error: htmlError,
    extraDataReturn: componentHTML
  }] = await multipleFetch({
    url: `../controllers/ScheduleController.php?type=getScheduleByIdJson&id=${getContextId(false, "[data-date-id]")}`
  }, {
    url: getFile("html/schedule", "html",
      import.meta.url),
    getJson: false,
    afterRequest: request => request.text()
  })
  
  disableLoader(target)

  if (error || htmlError || !result) return

  const {schedule} = result
  const { element } = setHTML({
    html: componentHTML,
    iterator: (child, datasetValue) => child.textContent = schedule[datasetValue]
  })

  modal.toggleModal({
    modalBody: (target) => target.innerHTML = element.outerHTML,
    modalHeader: (target) => target.firstElementChild.textContent = "Llena solo los campos que desas actualizar"
  })

  contextMethods.current = {
    ...contextMethods.current,
    onHandlerSuccessModal: () =>
      updateSchedule(getFormData, getContextId(false, "[data-date-id]"), target, schedule)
  };

  contextMethods.current.unsetModalViews()
}

const updateSchedule = async (getFormData, id, target, scheduleData) => {

  useLoader(target)
  const onAddSchedule = document.querySelector("#onAddSchedule")

  const {data} = getFormData(onAddSchedule)

  for (const key in data) {
    const isNull = data[key].length === 0
    
    if (isNull) {
      data[key] = scheduleData[lowerCase(key)]
    }
  }

  const {error, result: {isUpdated}} = await useFetch({
    url: "../controllers/ScheduleController.php?type=updateScheduleJson",
    fetchObject: {
      headers: {
        "Content-Type": "application/json"
      },
      method: "PUT",
      body: JSON.stringify({
        id,
        ...data
      })
    }
  })

  disableLoader(target)
  if (error || !isUpdated) return

  //Something
}