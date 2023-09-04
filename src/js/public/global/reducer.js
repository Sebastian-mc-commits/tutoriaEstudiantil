import views from "./views.js";
import {
  navigation,
  useSignalJs
} from "../../helpers/index.js";

const currentFile = views[navigation.getUrlParams()?.page]
export const importedData = useSignalJs({})
export const contextApp = useSignalJs(null)

if (currentFile) {
  import(`./${currentFile}/index.js`).then(data => {
    importedData.current = data?.default()
  })
}

export default function reducer({
  type,
  ...props
}) {

  const exec = importedData.current[type];

  if (!exec || typeof exec !== "function") return

  exec({
    ...props,
    context: importedData.current
  })

};