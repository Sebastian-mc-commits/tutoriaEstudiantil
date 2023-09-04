import { domUtilities, navigation, useEffect } from "../../helpers/index.js"

const { setLinkStyles } = navigation

useEffect(() => {
    setLinkStyles(import.meta.url)
})
export default class {

    #noAfterStringClass
    #buttonElement
    #containerElement
    #inputElement
    #button_outline_html = `<svg 
        xmlns="http://www.w3.org/2000/svg" 
        width="24" 
        height="24" 
        viewBox="0 0 24 24"
        ><path d="M12.015 7c4.751 0 8.063 3.012 9.504 4.636-1.401 1.837-4.713 5.364-9.504 5.364-4.42 0-7.93-3.536-9.478-5.407 1.493-1.647 4.817-4.593 9.478-4.593zm0-2c-7.569 0-12.015 6.551-12.015 6.551s4.835 7.449 12.015 7.449c7.733 0 11.985-7.449 11.985-7.449s-4.291-6.551-11.985-6.551zm-.015 5c1.103 0 2 .897 2 2s-.897 2-2 2-2-.897-2-2 .897-2 2-2zm0-2c-2.209 0-4 1.792-4 4 0 2.209 1.791 4 4 4s4-1.791 4-4c0-2.208-1.791-4-4-4z"
        /></svg>`;
    #button_fill_html = `<svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
              >
                <path
                  d="M14 12c0 1.103-.897 2-2 2s-2-.897-2-2 .897-2 2-2 2 .897 2 2zm10-.449s-4.252 7.449-11.985 7.449c-7.18 0-12.015-7.449-12.015-7.449s4.446-6.551 12.015-6.551c7.694 0 11.985 6.551 11.985 6.551zm-8 .449c0-2.208-1.791-4-4-4-2.208 0-4 1.792-4 4 0 2.209 1.792 4 4 4 2.209 0 4-1.791 4-4z"
                />
              </svg>`;

    #containerButtonStyles = "displayPassword";
    #buttonStyles = "displayPasswordButton";
    inputContainerStyles = "inputContainer"

    constructor({
        buttonElement,
        containerElement,
        inputElement
    }) {
        this.#noAfterStringClass = "no-after"
        this.#buttonElement = buttonElement
        this.#containerElement = containerElement
        this.#inputElement = inputElement
    }



    #isDisplaying = () => this.#containerElement.classList.contains(this.#noAfterStringClass);
    #toggleDisplayPassword = (passwordTarget) => {
        this.#containerElement.classList.toggle(this.#noAfterStringClass);

        if (this.#isDisplaying()) {
            this.#buttonElement.innerHTML = this.#button_fill_html;
        } else {
            this.#buttonElement.innerHTML = this.#button_outline_html;
        }
        passwordTarget.type = this.#isDisplaying() ? "password" : "text";
        passwordTarget.focus();
    };

    init = () => {
        this.#buttonElement.onclick = (e) => {
            e.preventDefault();
            this.#toggleDisplayPassword(this.#inputElement);
        }

        domUtilities.mutateDOM(this.#buttonElement, {
            successCase: () => this.#buttonElement.hidden = false,
            displayAlways: () => {
                this.#containerElement.classList.add(this.#containerButtonStyles, this.#noAfterStringClass)
                this.#buttonElement.classList.add(this.#buttonStyles)
                this.#inputElement.parentNode.classList.add(this.inputContainerStyles)
                this.#buttonElement.innerHTML = this.#button_fill_html
            }
        }, 350)
    }
};
