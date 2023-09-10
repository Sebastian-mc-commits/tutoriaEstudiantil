import {
  domUtilities,
  multipleFetch,
  navigation
} from "../../../helpers/index.js";
import {
  useFetch
} from "../../../helpers/index.js";
import {
  modal
} from "./index.js";

const {
  getFile
} = navigation;
const {
  useLoader,
  disableLoader,
  setHTML
} = domUtilities;

export const handleAddSchedule = async ({
  target,
  context: {
    contextMethods
  },
  getContextId,
  getFormData
}) => {
  contextMethods.current = {
    ...contextMethods.current,
    onHandlerSuccessModal: () =>
      addSchedule(getContextId(false), getFormData, target)
  };

  if (contextMethods.current.viewOfModals.isOnScheduleModalDisplaying) {
    modal.toggleModal({});
    return;
  }

  useLoader(target);
  const {
    error,
    extraDataReturn: html
  } = await useFetch({
    url: getFile("html/schedule", "html",
      import.meta.url),
    afterRequest: (request) => request.text(),
    getJson: false
  });

  if (error) return;

  modal.toggleModal({
    modalBody: (target) => (target.innerHTML = html),
    modalHeader: (target) => target.firstElementChild.textContent = "Agrega una nueva fecha a esta clase"
  });

  contextMethods.current = {
    ...contextMethods.current,
    displayAlwaysOnModal: () => {
      disableLoader(target);
    }
  };
  contextMethods.current.activeModalView("isOnScheduleModalDisplaying");
};

const addSchedule = async (id, getFormData, target) => {
  useLoader(target);
  const onAddSchedule = document.querySelector("#onAddSchedule");

  const {
    data
  } = getFormData(onAddSchedule);

  const [{
      error,
      result: {
        isAdded
      }
    },
    {
      error: scheduleChildError,
      extraDataReturn: scheduleChildHTML
    },
    {
      error: onAddScheduleError,
      extraDataReturn: onAddScheduleHTML
    }
  ] = await multipleFetch({
    url: "../controllers/ScheduleController.php?type=addScheduleJson",
    fetchObject: {
      headers: {
        "Content-Type": "application/json"
      },
      method: "POST",
      body: JSON.stringify({
        MENTORING_ID: id,
        ...data
      })
    }
  }, {
    url: getFile("html/scheduleChild", "html",
      import.meta.url),
    getJson: false,
    afterRequest: (request) => request.text()
  }, {
    url: getFile("html/onAddSchedule", "html",
      import.meta.url),
    getJson: false,
    afterRequest: (request) => request.text()
  });

  disableLoader(target);
  if (error || scheduleChildError || onAddScheduleError || !isAdded) return;

  const {
    element
  } = setHTML({
    html: scheduleChildHTML,
    iterator: (child, datasetValue) => (child.textContent = data[datasetValue])
  });

  target.insertAdjacentHTML("afterend", onAddScheduleHTML);
  target.outerHTML = element.outerHTML;
};