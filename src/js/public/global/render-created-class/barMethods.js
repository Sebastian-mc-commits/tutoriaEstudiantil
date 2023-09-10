import { multipleFetch, domUtilities, navigation, useFetch, utilities } from "../../../helpers/index.js"
import { modal } from "./index.js"

const { getFile } = navigation

const { disableLoader, useLoader, setHTML } = domUtilities
const {getId} = utilities
export const getRegisteredUsers = async ({ getContextId, target, context: { contextMethods } }) => {

    if (contextMethods.current.viewOfModals.isOnUsersRegisteredModalDisplaying) {
        modal.toggleModal({})
        return
    }
    const id = getContextId(false)

    useLoader(target)
    const [{ error, result }, { error: htmlError, extraDataReturn: componentHTML }] = await multipleFetch(
        {
            url: `../controllers/ClassController.php?type=getRegisteredUsersByClassIdJson&classId=${id}`,
        },
        {
            url: getFile("html/userDetail", "html", import.meta.url),
            getJson: false,
            afterRequest: (request) => request.text()
        }
    )

    disableLoader(target)

    if (error || htmlError) {
        return
    }

    let HTML = "<h3 class='card'>No hay usuarios registrados a esta clase</h3>"

    const {users = []} = result
    if (users.length) {
        HTML = ""
        for (const { id, ...userFields } of users) {
            const { element } = setHTML({
                html: componentHTML,
                iterator: (child, datasetValue) => {

                    if (datasetValue === "id") {
                        child.dataset.id = id
                    }
                    else {

                        child.textContent = userFields[datasetValue]
                    }
                }
            })

            HTML += element.outerHTML
        }
    }

    modal.toggleModal({
        modalBody: target => target.innerHTML = `
        <nav>
            ${HTML}
        </nav>`,
        modalHeader: target => target.firstElementChild.textContent = "Usuarios registrados",
        useDoneButton: false
    })

    contextMethods.current.onModalContentClick = (params) => {

        const userOptions = {
            onRemoveUser,
            onSelectUser
        }

        const exec = userOptions[params.dataset.type]
        return typeof exec === "function" ? exec(params) : null
    }

    contextMethods.current.activeModalView("isOnUsersRegisteredModalDisplaying")
}

const onSelectUser = () => {}

const onRemoveUser = async ({target}) => {

    useLoader(target)
    const userId = target.closest("[data-id]")
    const {error, result: {isRemoved}} = await useFetch({
        url: "../controllers/ClassController.php?type=removeUserOfClassJson",
        fetchObject: {
            headers: {
                "Content-Type": "application/json"
            },
            method: "DELETE",
            body: JSON.stringify({
                userId: getId(userId.dataset.id)
            })
        }
    })

    disableLoader(target)
    if (error || !isRemoved) return

    userId.remove()
}