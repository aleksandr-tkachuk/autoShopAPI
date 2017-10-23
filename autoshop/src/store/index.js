import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios';

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        history: [],
        mainMsg: {
            type: '',
            text: 'msg text'
        },
        isLoggedIn: false
    },
    getters: {
        history(state) {
            return state.history;
        },
        mainMsg(state) {
            return state.mainMsg;
        },
        isLoggedIn(state) {
            return state.isLoggedIn;
        }
    },
    mutations: {
        set(state, {type, items}) {
            state[type] = items
        }
    },
    actions: {
        async history({ commit }, token) {
            try {
                let {data: {data: res = []}} = await axios.get('http://autoshopapi/api/history', {headers: {'token': token}})
                commit('set', {type: 'history', items: res})
            } catch (e) {
                error(this, 'Cant show history')
            }
        },
        async login({ commit, dispatch }, token) {

            if(_.isObject(token)) {
                try {
                    let response = await axios.post('http://autoshopapi/api/auth', token)
                    token = _.get(response, 'data.data.token')
                    if(!token) {
                        throw new Error("wrong token")
                    }
                    sessionStorage.setItem('token', token);
                    commit('set', {type: 'isLoggedIn', items: true})
                    dispatch('history', token);
                } catch (e) {
                    error(this, 'Cant get token')
                }
            }
        },
        logout({ commit }) {
            commit('set', {type: 'history',items: []})
            commit('set', {type: 'isLoggedIn',items: false})
            sessionStorage.removeItem('token');

        }
    }
})

function error(obj, text="unknown error") {
    obj.commit('set', {
        type: 'mainMsg',
        items: {
            type: 'error',
            text
        }
    })
}

export default store;
