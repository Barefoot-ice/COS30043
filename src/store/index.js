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
        userRole: (state) => state.user.role,
        userId: (state) => state.user.account_id 
    },
    mutations:{
        logIn (state, userDetails) {
            state.user = userDetails
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
