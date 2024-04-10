import axios from 'axios'

export async function useStore(url, payload) {
  let err = null
  let validationErr = null
  let data = null

  try {
    data = await axios.post(url, payload)
  } catch (e) {
    if (e.response.status != 422) {
      err = e
    }
    if (e.response?.data.errors) {
      validationErr = e.response.data.errors
    }
  }

  return { err, validationErr, data }
}
