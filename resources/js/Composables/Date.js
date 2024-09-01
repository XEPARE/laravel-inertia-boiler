import moment from "moment";

/** Date Time Format */
export const format = (value, format) => moment(value).format(format)

/** Date Time Format */
export const dateTime = (value, formatString = 'DD.MM.YYYY - HH:mm') => format(value, formatString)

/** Date Format */
export const date = (value, formatString = 'DD.MM.YYYY') => format(value, formatString)

/** INTL Date Format */
export const intlDate = (value) => new Intl.DateTimeFormat('default', { dateStyle: 'full' }).format(new Date(value))

/** INTL Time Format */
export const intlTime = (value) => new Intl.DateTimeFormat('default', { timeStyle: 'short' }).format(new Date(value))

/** INTL Date Time Format */
export const intlDateTime = (value) => new Intl.DateTimeFormat('default', { dateStyle: 'full', timeStyle: 'short' }).format(new Date(value))
