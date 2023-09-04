import {
  domUtilities,
  navigation,
  useSignalJs
} from "../../helpers/index.js";
import Global from "../Global/index.js";
import {
  toggleOverlay
} from "../overlay/index.js";

const {
  setLinkStyles
} = navigation

setLinkStyles(
  import.meta.url);


export default class Modal extends Global {
  #modalActiveClass;
  #modalFooter;
  #modalHeader;
  #overlayId;
  #useDoneButton;
  #doneButtonTextContent;
  constructor({
    id = Date.now(),
    componentBodyHTML = () => "",
    modalFooter = () => "",
    modalHeader = () => "",
    onModalToggle = () => null,
    overlayId = "overlayModal",
    doneButtonTextContent = "Listo",
    useDoneButton = true
  }) {
    super({
      id,
      componentName: "modal",
      componentBodyChildId: "modalChild",
      componentBodyId: "modalBody",
      componentBodyHTML
    });
    this.isModalBuild = false
    this.#modalActiveClass = "modalActive";
    this.#modalFooter = modalFooter;
    this.#modalHeader = modalHeader;
    this.onClose = useSignalJs(null);
    this.#useDoneButton = useDoneButton;
    this.#doneButtonTextContent = doneButtonTextContent;
    this.#initModal();
    this.#overlayId = overlayId;
    this.onModalToggle = onModalToggle;
  }

  #modalHTML() {
    return `
      <section class="custom-modal" data-modal='${this.id}' data-type-modal='modal'>
      <div class="custom-modal-header" data-type-modal='modalHeader'>
        <button data-type-modal='modalClose' class='global-button modal-close-button global-button-danger hoverAnimation'>X</button>
      </div>
      <div id="content" class='modal-body' data-type-modal='modalBody'></div>
      <div class="custom-modal-footer" data-type-modal='modalFooter'>
        ${this.#useDoneButton
        ? `<button data-type-modal='modalFooterClose' class='global-button global-button-blue hoverAnimation'>${this.#doneButtonTextContent
        }</button>`
        : ""
      }
      </div>
    </section>
      `;
  }

  modalBodyInserted = () => {
    const {
      modalBody,
    } =
      this._getComponent();

    return modalBody.firstElementChild;
  }

  #initModal() {
    const modal = this.#modalHTML();

    domUtilities.mutateDOM(modal, {
      successCase: () => {
        document.body.insertAdjacentHTML("afterbegin", modal);

        const {
          modalHeader,
          modalFooter,
          modalBody,
          modalFooterClose
        } =
          this._getComponent();
        this.#modalHeader.apply(
          null,
          this._insertParams({
            target: modalHeader,
            modalChildId: this.componentBodyChildId
          })
        );

        this.#modalFooter.apply(
          null,
          this._insertParams({
            target: modalFooter,
            button: modalFooterClose,
            modalChildId: this.componentBodyChildId
          })
        );

        this.componentBodyHTML.apply(
          null,
          this._insertParams({
            target: modalBody,
            modalChildId: this.componentBodyChildId
          })
        );

        this.onClose.__current__ = {
          overlay: this.#toggleOverlay,
          toggleModal: this.toggleModal,
          modalChildren: this.getBodyChildren,
          modalBody
        };
        this.#setModalListener()
        this.isModalBuild = true
      }
    }, 350)

  }

  #toggleOverlay = () => {
    toggleOverlay(this.#overlayId);
  };

  toggleModal = () => {
    if (!this.isModalBuild) return
    const {
      modal
    } = this._getComponent();
    this.#toggleOverlay();
    modal.classList.toggle(this.#modalActiveClass);
    this.onModalToggle.current = modal.classList.contains(
      this.#modalActiveClass
    );
  };

  #setModalListener = () => {
    const {
      main
    } = this._idSelector();
    document.querySelector(main).addEventListener("click", (event) => {
      event.stopPropagation();
      const {
        target
      } = event;
      const {
        dataset
      } = target;

      const modalCloseTypes = ["modalFooterClose", "modalClose"]
      if (!modalCloseTypes.includes(dataset?.typeModal)) {
        this.onContentClick({
          target,
          dataset,
          modalChildren: this.getBodyChildren,
          modalTypes: this._getComponent,
          modalId: this.componentBodyChildId
        })
        return
      }

      this.onClose.current = {
        ...this.onClose.current,
        type: dataset.typeModal === "modalFooterClose" ? "done" : "close"
      };
    });
  }
}