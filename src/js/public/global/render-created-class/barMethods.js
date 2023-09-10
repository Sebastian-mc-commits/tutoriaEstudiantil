import { multipleFetch, domUtilities, navigation } from "../../../helpers/index.js"
import {overlayMethods} from "../../../components/index.js"

const {toggleOverlay} = overlayMethods
const {getFile} = navigation

const {disableLoader, useLoader} = domUtilities
export const getRegisteredUsers = async ({getContextId, target, context: {constants}}) => {
    const id = getContextId(false)

    useLoader(target)
    const [{error, result}, {error: htmlError, extraDataReturn: componentHTML}] = await multipleFetch(
        {
            url: `../controllers/Rate.php?type=getUsersRegisterdByClassId&classId=${id}`,
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

    let HTML = ""
    for (const userFields of result) {
        const { element } = setHTML({
            html: componentHTML,
            iterator: (child, datasetValue) => child.textContent = userFields[datasetValue],
        })
        
        HTML += element.outerHTML
    }

    toggleOverlay(constants().overlayId)

    

}