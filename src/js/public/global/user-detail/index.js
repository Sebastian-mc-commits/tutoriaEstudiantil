import * as navigate from "./navigate.js"
import * as navigateAndRender from "./navigateAndRender.js"
import * as ops from "./ops.js"

export default function () {

    return {
        ...navigate,
        ...ops,
        ...navigateAndRender
    }
}