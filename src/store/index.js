import {createStore} from 'vuex'

export const store = createStore({
    state(){
        return {
            homeSearch: '',
            loggedIn: false,
            user: [{
                account_id: null,
                username: null,
                role: null
            }]
        }
    },
    getters:{
        isLoggedIn: (state) => !!state.loggedIn,
        userRole: (state) => state.user.role
    },
    mutations:{
        logIn (state, username) {
            state.user = username
            state.loggedIn = true
        },

        logOut (state) {
            state.user = [{
                account_id: null,
                username: null,
                role: null
            }]
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