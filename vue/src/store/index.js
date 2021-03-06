import { createStore } from 'vuex'
import axios from 'axios'



export default createStore({
    state: {
        user: null,
        vcard: null,
        categoryTypes: ["D", "C"],
        userCategories: [],
        users: [],
        vcards: [],
    },
    mutations: {
        setUser(state, loggedInUser) {
            state.user = loggedInUser
        },
        resetUser(state) {
            if (state.user) {
                state.user = null
            }
        },

        updateUser(state, updateUser) {
            let idx = state.users.findIndex((t) => t.id === updateUser.id)
            if (idx >= 0) {
                state.users[idx] = updateUser
            }
        },
        deleteUser(state, deleteUser) {
            let idx = state.users.findIndex((t) => t.id === deleteUser.id)
            if (idx >= 0) {
                state.users.splice(idx, 1)
            }
        },
        setUsers(state, users) {
            state.users = users
        },
        resetUsers(state) {
            state.users = null
        },

        resetVCard(state) {
            this.$socket.emit('logged_out_vcard', state.vcard)
            state.vcard = null
        },
        setVCards(state, vcards) {
            state.vcard = vcards
        },
        setVCard(state, vcard) {
            state.vcard = vcard
        },
        updateVCard(state, updateVCard) {
            let idx = state.vcard.findIndex((t) => t.phone_number === updateVCard.phone_number)
            if (idx >= 0) {
                state.vcard[idx] = updateVCard
            }
        },
        setUserCategories(state, userCategories) {
            state.userCategories = userCategories
        },
        resetUserCategories(state) {
            state.userCategories = null
        }
    },
    actions: {
        async login(context, credentials) {
            try {
                let response = await axios.post('login', credentials)
                axios.defaults.headers.common.Authorization = "Bearer " + response.data.access_token
                sessionStorage.setItem('token', response.data.access_token)
            } catch (error) {
                delete axios.defaults.headers.common.Authorization
                sessionStorage.removeItem('token')
                context.commit('resetUser', null)
                throw error
            }
            await context.dispatch('refresh')
        },
        async adminLogin(context, credentials) {
            try {
                let response = await axios.post('adminlogin', credentials)
                axios.defaults.headers.common.Authorization = "Bearer " + response.data.access_token
                sessionStorage.setItem('token', response.data.access_token)
            } catch (error) {
                delete axios.defaults.headers.common.Authorization
                sessionStorage.removeItem('token')
                context.commit('resetUser', null)
                throw error
            }
            await context.dispatch('refresh')
        },
        async changedPassword(context, vcard) {
            let response = await axios.patch("vcards/" + vcard.phone_number + "/password", vcard)
            context.commit('updateVcard', response.data.data)
            return response.data.data

        },
        async logout(context) {
            try {
                await axios.post('logout')
            }
            finally {
                delete axios.defaults.headers.common.Authorization
                sessionStorage.removeItem('token')
                context.commit('resetUser', null)
            }
        },
        async loadUser(context) {
            try {
                let response = await axios.get('users/me')
                context.commit('setUser', response.data.data)
            } catch (error) {
                context.commit('resetUser', null)
            }
        },
        async loadUserCategories(context) {
            try {
                let response = await axios.get('mycategories/' + this.state.user.username)
                context.commit('setUserCategories', response.data.data)
            } catch (error) {
                context.commit('resetUserCategories', null)
            }
        },
        async loadVCard(context) {
            try {
                let response = await axios.get('vcards/' + this.state.user.username)
                context.commit('setVCards', response.data.data)
                console.log("emit logged in vcard")
                return response.data.data
            } catch (error) {
                context.commit('resetVCard', null)
            }
        },
        async restoreToken(context) {
            let storedToken = sessionStorage.getItem('token')
            if (storedToken) {
                axios.defaults.headers.common.Authorization = "Bearer " + storedToken
                return storedToken
            }
            delete axios.defaults.headers.common.Authorization
            context.commit('resetUser')
            return null
        },
        async loadLoggedInUser(context) {
            try {
                let response = await axios.get('users/me')
                context.commit('setUser', response.data.data)
            } catch (error) {
                delete axios.defaults.headers.common.Authorization
                context.commit('resetUser', null)
                throw error
            }
        },
        async loadUsers(context) {
            try {
                let response = await axios.get('users')
                context.commit('setUsers', response.data.data)
                return response.data.data
            } catch (error) {
                context.commit('resetUsers', null)
                throw error
            }
        },
        async updateUser(context, user) {
            let response = await axios.put("users/" + user.id, user)
            context.commit('updateUser', response.data.data)
            return response.data.data
        },
        async deleteUser(context, user) {
            let response = await axios.delete("users/" + user.id)
            context.commit('deleteUser', response.data.data)
            return response.data.data
        },
        async refresh(context) {
            let userPromise = context.dispatch('loadLoggedInUser')
            let usersPromise = context.dispatch('loadUsers')
            await userPromise
            await usersPromise
        },
        async updateVCard(context, vcard) {
            let response = await axios.put("vcards/" + vcard.phone_number, vcard)
            context.commit('updateVCard', response.data.data)
            // this.$socket.emit('updateVcardTransaction', response.data.data)
            return response.data.data
        },
        async SOCKET_newCategory(context, category) {
            console.log('Someone else has inserted a Category')
            this.$toast.info(`A new Category was created (#${category.id} : ${category.name})`)
            context.commit('insertCategory', category)
        },
        async SOCKET_updateVcardTransaction(_, vcardId) {
            console.log(vcardId)
            if (vcardId) {
                this.$toast.info(`User #${vcardId} transaction history was updated`)
            }
            // console.log('Your vcard has been updated with a new transaction')
            // console.log("context",context.state.vcard)
            // console.log("vcard",vcard)
            // if (context.state.vcard && vcard) {
            //     context.commit('updateVcardTransaction',vcard)
            //     if (vcard.id == context.state.vcard.id) {
            //         context.commit('setVcard',vcard)
            //         this.$toast.info('Your transaction history has been updated')
            //     }else
            //     this.$toast.info(`User #${vcard.id} was updated`)
            // }
        },
    },
    modules: {},
    getters: {
        isAdmin(state) {
            return (state.user) && state.user.type == 'A'
        },
        isVCard(state) {
            return (state.user) && state.user.type == 'V'
        },
        isLoggedIn(state) {
            return (state.user)
        },
        getBalance(state) {
            return (state.vcard.balance)
        },
        users: state => {
            return state.users.filter(users => users.type === 'A')
        },
        vcardsFilter: (state) => (filter) => {
            return state.users.filter(users => users.name === filter.name)
        },
        totalUsers: (state, getters) => {
            return getters.users.length
          },
          totalVCards: (state) => {
            return state.users.filter(users => users.type === 'V').length
          },
          vcards: state => {
            return state.users.filter(users => users.type === 'V')
          },
          
    }
})