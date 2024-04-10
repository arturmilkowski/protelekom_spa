import { ref } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { useAuthStore } from './auth'

export const useStore = defineStore('store', () => {
  async function all(urlFragment) {
    const authStore = useAuthStore()
    let collection = []
    let err = null

    try {
      const res = await axios(urlFragment, {
        headers: {
          Authorization: `Bearer ${authStore.token}`
        }
      })
      collection = res.data
    } catch (e) {
      err = e
    }

    return { err, collection }
  }

  async function getOne(urlFragment, id) {
    const authStore = useAuthStore()
    let err = null
    let data = null
    try {
      const res = await axios(`${urlFragment}/${id}`, {
        headers: {
          Authorization: `Bearer ${authStore.token}`
        }
      })
      data = res.data
    } catch (e) {
      err = e
    }

    return { err, data }
  }

  async function create(urlFragment, payload) {
    const authStore = useAuthStore()
    let err = null
    let validationErr = null
    let data = null
    try {
      data = await axios.post(urlFragment, payload, {
        headers: {
          Authorization: `Bearer ${authStore.token}`
        }
      })
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

  async function createPostForm(urlFragment, payload) {
    const authStore = useAuthStore()
    let err = null
    let validationErr = null
    let data = null
    try {
      data = await axios.postForm(urlFragment, payload, {
        headers: {
          Authorization: `Bearer ${authStore.token}`
        }
      })
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

  async function update(urlFragment, id, payload) {
    const authStore = useAuthStore()
    let err = ref(null)
    let validationErr = []
    let data = null
    try {
      data = await axios.put(urlFragment + '\\' + id, payload, {
        headers: {
          Authorization: `Bearer ${authStore.token}`
        }
      })
    } catch (e) {
      err.value = e
      /*
      if (e.code != 'ERR_BAD_REQUEST') {
        err.value = e
      }
      */
      if (e.response?.data.errors) {
        validationErr = e.response.data.errors
      }
    }

    return { err, validationErr, data }
  }

  async function updatePostForm(urlFragment, id, payload) {
    const authStore = useAuthStore()
    let err = ref(null)
    let validationErr = []
    let data = null
    payload._method = 'PUT'
    try {
      data = await axios.postForm(urlFragment + '\\' + id, payload, {
        headers: {
          Authorization: `Bearer ${authStore.token}`
        }
      })
    } catch (e) {
      err.value = e
      if (e.response?.data.errors) {
        validationErr = e.response.data.errors
      }
    }

    return { err, validationErr, data }
  }

  async function destroy(urlFragment, id) {
    const authStore = useAuthStore()
    let err = null
    let data = null
    try {
      data = await axios.delete(urlFragment + '\\' + id, {
        headers: {
          Authorization: `Bearer ${authStore.token}`
        }
      })
    } catch (e) {
      err = e
    }

    return { err, data }
  }

  return { all, getOne, create, update, destroy, updatePostForm, createPostForm }
})
