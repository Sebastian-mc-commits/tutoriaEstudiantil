import colors from "../../constants/themes/colors.js";
import { domUtilities } from "../../helpers/index.js";

const { brightYellow, ...globColors } = colors.glob
const theme = Object.values(globColors)

domUtilities.setRandomColorBetween(theme)