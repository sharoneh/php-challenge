let isoDates = []
let times = []
const elements = document.querySelectorAll('.js-date-format')
elements.forEach(el => {
  isoDates.push(el.innerHTML)
  times.push(new Date(el.innerHTML).getTime())
})

const minuteSeconds = 60
const hourSeconds = 60 * minuteSeconds
const daySeconds = 24 * hourSeconds

const formatIntervals = () => {
  elements.forEach((el, index) => {
    const secondsPassed = (Date.now() - times[index]) / 1000
    
    if (secondsPassed > daySeconds) {
      el.innerHTML = isoDates[index]
    } else if (secondsPassed > hourSeconds) {
      const hours = Math.floor(secondsPassed / hourSeconds)
      el.innerHTML = `${hours} hour${hours > 1 ? 's' : ''} ago`
    } else if (secondsPassed > minuteSeconds) {
      const minutes = Math.floor(secondsPassed / minuteSeconds)
      el.innerHTML = `${minutes} minute${minutes > 1 ? 's' : ''} ago`
    } else {
      const seconds = Math.floor(secondsPassed)
      el.innerHTML = `${seconds} second${seconds > 1 ? 's' : ''} ago`
    }
  })
}

formatIntervals()
window.setInterval(formatIntervals, 1000)