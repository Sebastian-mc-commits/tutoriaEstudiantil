import {
  utilities,
  domUtilities
} from "../../helpers/index.js"
import reducer from "./reducer.js"

const {
  getId
} = utilities

const {
  convertToDataset
} = domUtilities
export default class {

  #dataset
  #datasetType
  #datasetsContext
  constructor({
    dataset,
    datasetType,
    datasetsContext,
  }) {
    this.#dataset = dataset
    this.#datasetType = datasetType
    this.#datasetsContext = datasetsContext

  }
  #getContext = (dataset) => Array.from(document.querySelectorAll(dataset))

  #getElementContext = (type, dataset, datasetType) => this.#getContext(dataset).find(el => el.dataset[datasetType] === type)

  #getContextIds = () => Array.from(document.querySelectorAll("[data-global-id]"))

  #getContextId = (target, dataset, getElement, parent) => {
    let element = parent ? target.closest(parent) : target

    if (!element?.dataset.globalId) {
      element = parent ? element?.querySelector(dataset) : element?.closest(dataset)
    }

    return getElement ? element : getId(element.dataset[convertToDataset(dataset)])
  }

  #getFormData = (target) => {
    const form = target.tagName === "FORM" ? target : target.closest("form")

    const formData = new FormData(form)
    const data = Object.fromEntries(formData)

    return {
      data,
      formData
    }
  }

  setReducer = ({
    event,
    ...props
  }) => {

    const {
      target
    } = event
    const {
      dataset: t_dataset
    } = target

    const type = t_dataset[this.#datasetType] || target.closest(this.#dataset)?.dataset[this.#datasetType]
    const parentTarget = t_dataset[this.#datasetType] ? target : target.closest(this.#dataset)

    const {
      render,
      onclick
    } = this.#datasetsContext

    if (!type) return
    reducer({
      type,
      target,
      parentTarget,
      datasetType: this.#datasetType,
      dataset: t_dataset,
      parentDataset: parentTarget?.dataset,
      event,
      getContext: () => this.#getContext(onclick.dataset),
      getElementContext: (type) => this.#getElementContext(type, onclick.dataset, onclick.datasetType),
      getRenderContext: () => this.#getContext(render.dataset),
      getRenderElementContext: (type) => this.#getElementContext(type, render.dataset, render.datasetType),
      getContextIds: this.#getContextIds,
      getContextId: (getElement, dataset = "[data-global-id]", parent, tr = target) => this.#getContextId(tr, dataset, getElement, parent),
      getFormData: this.#getFormData,
      ...props
    })
  }
}