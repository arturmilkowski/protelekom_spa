import axios from 'axios'

export async function useShow(url) {
  let err = null
  let data = null

  try {
    const res = await axios(url)
    data = res.data.data
  } catch (e) {
    err = e
  }

  return { err, data }
}
