import {
  overlayMethods
} from "../../../components/index.js"
import {
  domUtilities,
  useFetch
} from "../../../helpers/index.js"

const {
  toggleOverlay
} = overlayMethods
const {
  useLoader,
  disableLoader
} = domUtilities
export const handleUpdateClass = async ({
  context: {
    constants
  },
  getFormData,
  target,
  getContextId
}) => {

  toggleOverlay(constants().overlayId)
  useLoader(target)
  const classForm = document.querySelector("#classForm")
  const {
    data
  } = getFormData(classForm)

  const {
    error,
    result: {
      isUpdated
    }
  } = await useFetch({
    url: "../controllers/ClassController.php?type=updateClassJson",
    fetchObject: {
      method: "PUT",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        id: getContextId(false),
        ...data
      })
    }
  })

  toggleOverlay(constants().overlayId)
  disableLoader(target)
  if (error) return

  if (isUpdated) {
    //
  }
}

export const handleDeleteClass = async ({
  target,
  getContextId
}) => {
  useLoader(target)

  const {
    error,
    result: {
      isDeleted
    }
  } = await useFetch({
    url: "../controllers/ClassController.php?type=deleteClassJson",
    fetchObject: {
      method: "PUT",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        id: getContextId(false),
      })
    }
  })

  disableLoader(target)
  if (error) return

  if (isDeleted) {
    location.href = "index.php?page=user-detail&tree=user"
  }
}