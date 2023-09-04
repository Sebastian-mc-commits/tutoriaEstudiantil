import { DisplayPassword } from "../../components/index.js";


const inputElement = document.querySelector("#password");
const displayPasswordOps = {
    buttonElement: document.querySelector("#displayPassword"),
    containerElement: document.querySelector("#displayPasswordAfter"),
    inputElement,
};
const displayPasswordComponent = new DisplayPassword(displayPasswordOps);

displayPasswordComponent.init();