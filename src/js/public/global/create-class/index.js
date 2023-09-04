import {
  Modal
} from "../../../components/index.js"
import {
  navigation
} from "../../../helpers/index.js"
import * as scheduleCases from "./scheduleCases.js"

const {
  getFile
} = navigation

const modalConfig = {
  componentBodyHTML: async (insert) => {
    const request = await fetch(getFile("html/index", "html", import.meta.url))
    const HTML = await request.text()
    insert(HTML)
  },
  modalHeader: (insert) => insert("<h2>Agregar horario</h2>")
}

export const modal = new Modal(modalConfig)

modal.onClose.onHandlerChangeValue = ({
  toggleModal,
  type
}) => {
  toggleModal()
  if (type === "done") scheduleCases.onDoneSelected()
}

export default function () {

  return {
    ...scheduleCases
  }
}