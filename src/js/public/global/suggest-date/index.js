import {
    Modal
} from "../../../components/index.js"
import {
    navigation
} from "../../../helpers/index.js"
import * as cases from "./cases.js"

const {
    getFile
} = navigation

const modalConfig = {
    componentBodyHTML: async (insert) => {
        const request = await fetch(getFile("html/scheduleWithOutLink", "html", import.meta.url))
        const HTML = await request.text()
        insert(HTML)
    },
    modalHeader: (insert) => insert("<h2>Agregar horario</h2>"),
    doneButtonTextContent: "Estoy seguro de sugerir esta fecha"
}

export const modal = new Modal(modalConfig)

modal.onClose.onHandlerChangeValue = ({
    toggleModal,
    type,
    modalBody
}) => {
    toggleModal()
    if (type === "done") {
        cases.onScheduleReady(modalBody.querySelector("form"))
    }
}

export default function () {

    return {
        ...cases
    }
}