import {createStore} from 'vuex'

export const store = createStore({
    state(){
        return {
            loggedIn: false,
            user: {firstName:null, lastName:null}
        }
    },
    getters:{},
    mutations:{
        logIn (state, username) {
            state.user.firstName = username
            state.loggedIn = true
        },

        logOut (state) {
            state.user.firstName = null
            state.loggedIn = false
        }
    },
    actions:{}
})