import OnClickHandler from "./onClickHandler.js";
export const main = document?.querySelector("#mainContainer")

const datasets = {
  render: {
    dataset: "[data-global-render]",
    datasetType: "globalRender"
  },

  onclick: {
    dataset: "[data-global-type]",
    datasetType: "globalType"
  }
}

const init = () => {
  const {
    dataset,
    datasetType
  } = datasets.onclick
  const onClickHandler = new OnClickHandler({
    dataset,
    datasetsContext: datasets,
    datasetType
  })

  main?.addEventListener("click", (event) => {
    onClickHandler.setReducer({
      event
    })
  });

//   const {
//     dataset,
//     datasetType
//   } = datasets.render
//   const render = Array.from(document.querySelectorAll(dataset) || [])
// 
//   if (render.length) {
//     render.forEach(el => {
//       toggleOverlayElement(el.parentNode)
//     })
//   }
//   isReducerReady.onHandlerChangeValue = () => {
// 
//     if (render.length) {
//       render.forEach(target => {
//         callReducer({
//           event: {
//             target
//           },
//           datasetType,
//           dataset,
//           datasetsContext: datasets
//         })
//         toggleOverlayElement(target.parentNode)
//       })
//     }
//   }
}

if (main) {
  init()
}