import { defineStore } from 'pinia'
import axios from 'axios'
import { computed, reactive } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  // console.log(JSON.parse(localStorage.getItem('user')))
  let user = reactive(JSON.parse(localStorage.getItem('user')) || {})

  const getToken = async () => {
    let err = null
    let token = null
    try {
      token = await axios.get('/sanctum/csrf-cookie')
    } catch (e) {
      err = e.message
    }

    return { err, token }
  }

  const getUser = async () => {
    const data = await axios.get('/api/user')
    user.id = data.data.id
    user.name = data.data.name
    user.email = data.data.email
    localStorage.setItem('user', JSON.stringify(user))

    return data.data
  }

  const login = async (payload) => {
    let err = null
    let validationErr = null
    const { err: err1, token } = await getToken()
    err = err1

    let response = null
    try {
      response = await axios.post('/login', payload)
      await getUser()
    } catch (e) {
      if (e.response?.data.message) {
        validationErr = e.response.data.errors
        if (e.response.status != 422) {
          err = e.response.data.message
        }
      }
    }

    return { err, validationErr, response }
  }

  const logout = async () => {
    let err = null
    let success = true

    delete user.id
    delete user.name
    delete user.email
    localStorage.removeItem('user')
    try {
      await axios.post('/logout')
    } catch (e) {
      err = e.message
      success = false

      return { err, success }
    }

    return { err, success }
  }

  const register = async (payload) => {
    let err = null
    let validationErr = null

    const { err: err1, token } = await getToken()
    err = err1

    let response = null
    try {
      response = await axios.post('/register', payload)
      await getUser()
    } catch (e) {
      if (e.response?.data.message) {
        validationErr = e.response.data.errors
        if (e.response.status != 422) {
          err = e.response.data.message
        }
      }
    }

    return { err, validationErr, response }
  }

  const isAuth = computed(() => {
    return Object.keys(user).length !== 0
  })

  const isGuest = computed(() => {
    return Object.keys(user).length === 0
  })

  return { user, isAuth, isGuest, login, logout, register }
})
