import {
  useSignal,
  useSignalJs
} from "../../helpers/index.js";

const classValues = useSignal({
  description: "",
  name: "",
  disabled: true
}, "class")

export const onSubmitData = useSignalJs({
  schedules: [],
  class: {
    description: "me",
      name: "me"
  }
})

onSubmitData.onHandlerChangeValue = ({
  schedules,
  class: {
    description, name
  }
}) => {
  const condition = schedules.length > 0 && !!description && !!name

  classValues.current.disabled = !condition
}

const oninput = (type) => {

  return (event) => {
    if (!event.isTrusted) return
    const value = event.target.value
    classValues.current[type] = value
    onSubmitData.current = {
      ...onSubmitData.current,
      class: {
        ...onSubmitData.current.class,
          [type]: value
      }
    }
  }
}

classValues.current.name = {
  oninput: oninput("name")
}

classValues.current.description = {
  oninput: oninput("description")
}

const f = async () => {
  const request = await fetch("../controllers/ClassController.php?type=createClass", {
    headers: {
      "Content-Type": "application/json"
    },
    method: "POST",
    body: JSON.stringify(onSubmitData.current)
  })

  console.log(request)
  const j = await request.json()
  console.log(j)
}

// f().then(() => console.log("good")).catch(e => console.log(`Error: ${e.message}`))