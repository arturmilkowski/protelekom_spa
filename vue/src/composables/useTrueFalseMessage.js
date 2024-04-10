export function useTrueFalseMessage(field) {
  // console.log('field:', field, field == true)
  let message = ''
  const setMessage = () => {
    message = field == true ? 'Tak' : 'Nie'
  }
  setMessage()

  return { message }
}
