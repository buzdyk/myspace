export const hoursToString = (number) =>
    Math.floor(number) + ':' + Math.round((number - Math.floor(number)) * 60).toString().padStart(2, '0')

export const formatMoney = number => {
    const options = { maximumSignificantDigits: 0, style: 'currency', currency: 'USD' }
    return `$` + Number.parseInt(number)
}
