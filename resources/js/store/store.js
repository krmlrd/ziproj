import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export const store = new Vuex.Store({
  state: {
    token: localStorage.getItem('access_token') || null,
    refresh_token: localStorage.getItem('refresh_token') || null,
    posts: [],
    images: [],
  },
  getters: {
    loggedIn(state) {
      return state.token !== null
    }
  },
  mutations: {
    retrieveToken(state, {token, refresh_token}) {
      state.token = token
      state.refresh_token = refresh_token
    },
    destroyToken(state) {
      state.token = null
      state.refresh_token = null
    },
    setPosts(state, response) {
      state.posts = response
    },
    setImages(state, response) {
      state.images = response
    },
  },
  actions: {
    register(context, data) {
      return new Promise((resolve, reject) => {
        axios.post('/auth/register', {
          name: data.name,
          email: data.email,
          password: data.password,
          password_confirmation: data.password_confirmation,
        })
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    },
    getAllPosts(context) {
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

      return new Promise((resolve, reject) => {
        axios.get('/post/get_all')
          .then(response => {
            context.commit('setPosts', response.data.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    },
    getAllImages(context) {
      return new Promise((resolve, reject) => {
        axios.get('/image/get_all')
          .then(response => {
            context.commit('setImages', response.data.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    },
    deletePost(context, params) {
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

      return new Promise((resolve, reject) => {
        axios.post('/post/delete', {
            id: params.id,
        })
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    },
    deleteImage(context, params) {
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

      return new Promise((resolve, reject) => {
        axios.post('/image/delete', {
            id: params.id,
        })
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    },
    destroyToken(context) {
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

      if (context.getters.loggedIn) {
        return new Promise((resolve, reject) => {
          axios.post('/auth/logout')
            .then(response => {
              localStorage.removeItem('access_token')
              localStorage.removeItem('refresh_token')
              context.commit('destroyToken')
              resolve(response)
            })
            .catch(error => {
              localStorage.removeItem('access_token')
              localStorage.removeItem('refresh_token')
              context.commit('destroyToken')
              reject(error)
            })
        })
      }
    },
    retrieveToken(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.post('/auth/login', {
          email: credentials.email,
          password: credentials.password,
        })
          .then(response => {
            const token = response.data.access_token
            const refresh_token = response.data.refresh_token

            localStorage.setItem('access_token', token)
            localStorage.setItem('refresh_token', refresh_token)
            context.commit('retrieveToken', {token, refresh_token})
            resolve(response)
          })
          .catch(error => {
            localStorage.removeItem('access_token')
            localStorage.removeItem('refresh_token')
            context.commit('destroyToken')
            console.log(error)
            reject(error)
          })
      })
    },
  }
})
