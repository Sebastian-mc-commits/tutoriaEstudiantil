import {
    useSignalJs
} from "../../../helpers/index.js"

export const constants = () => ({
    overlayId: "setViewOverlay"
})

export const contextMethods = useSignalJs({
    onHandlerCloseModal: () => {},
    onHandlerSuccessModal: () => {},
    displayAlwaysOnModal: () => {},
    viewOfModals: {
        isOnScheduleModalDisplaying: false,
        isOnUsersRegisteredModalDisplaying: false
    },
    activeModalView: (view) => {

        for (const key in contextMethods.current.viewOfModals) {
            contextMethods.__current__ = {
                ...contextMethods.current,
                viewOfModals: {
                    ...contextMethods.current.viewOfModals,
                    [key]: false
                }
            }
        }

        contextMethods.__current__ = {
            ...contextMethods.current,
            viewOfModals: {
                ...contextMethods.current.viewOfModals,
                [view]: true
            }
        }
    },
    unsetModalViews: () => {
        for (const key in contextMethods.current.viewOfModals) {
            contextMethods.__current__ = {
                ...contextMethods.current,
                viewOfModals: {
                    ...contextMethods.current.viewOfModals,
                    [key]: false
                }
            }
        }
    },

    onModalContentClick: () => null
})

export const onModalContentClick = ({dataset, ...params}) => {
    if (!!dataset.type) {
        contextMethods.current.onModalContentClick({
            dataset,
            ...params
        })
    }
}