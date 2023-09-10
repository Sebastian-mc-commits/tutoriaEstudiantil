import * as barMethods from "./barMethods.js"
import * as ops from "./ops.js"
import * as classMethods from "./classMethods.js"
import * as onAddSchedule from "./onAddSchedule.js"
import * as onUpdateSchedule from "./onUpdateSchedule.js"
import * as onDeleteSchedule from "./onDeleteSchedule.js"
import {
    Modal
} from "../../../components/index.js"

export const modal = new Modal({
    modalHeader: (insert) => insert("<h3></h3>")
})
modal.onClose.onHandlerChangeValue = ({
    toggleModal,
    type
}) => {
    
    toggleModal({})
    if (type === "done") {
        ops.contextMethods.current.onHandlerSuccessModal()
    }
    else {
        ops.contextMethods.current.onHandlerCloseModal()
    }

    ops.contextMethods.current.displayAlwaysOnModal()

}

modal.onContentClick = ops.onModalContentClick
export default function () {

    return {
        ...barMethods,
        ...ops,
        ...classMethods,
        ...onAddSchedule,
        ...onUpdateSchedule,
        ...onDeleteSchedule
    }
}