import axios from 'axios'

export async function useDestroy(url) {
  let err = null
  let data = null

  try {
    data = await axios.delete(url)
  } catch (e) {
    err = e
  }

  return { err, data }
}
