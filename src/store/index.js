import {createStore} from 'vuex'

const savedUser = JSON.parse(sessionStorage.getItem('user'))
const savedLoggedIn = sessionStorage.getItem('loggedIn') === 'true'

export const store = createStore({
    state(){
        return {
            homeSearch: '',
            loggedIn: savedLoggedIn || false,
            user: savedUser || {
                account_id: null,
                username: null,
                role: null
            }
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
            sessionStorage.setItem('user', JSON.stringify(userDetails))
            sessionStorage.setItem('loggedIn', 'true')
        },

        logOut (state) {
            state.user = {
                account_id: null,
                username: null,
                role: null
            }
            state.loggedIn = false
            sessionStorage.removeItem('user')
            sessionStorage.removeItem('loggedIn')
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