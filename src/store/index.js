import {createStore} from 'vuex'

export const store = createStore({
    state(){
        return {
            homeSearch: '',
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
        },

        setHomeSearch(state, payload) {
            state.homeSearch = payload;
        },

        clearHomeSearch(state) {
        state.homeSearch = '';
        }
    },
    actions:{}
})