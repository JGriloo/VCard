import {createStore} from 'vuex'
import axios from 'axios'

export default createStore({
    state:{
        user:null
    },
    mutations:{
        resetUser(state){
            state.user = null
        },
        setUser (state,loggedInUser){
            state.user = loggedInUser
        }
    },
    actions:{
        async loadUser(context){
            try {
                let response = await axios.get('users/me')
                context.commit('setUser',response.data.data)
            } catch (error) {
                context.commit('resetUser',null)
            }
        },
    },
    modules:{},
    getters:{
        isAdmin(state){
            return (state.user) && state.user.type == 'A'
        }
    }
})