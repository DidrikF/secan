import router from './router'
import store from './vuex'
import localforage from 'localforage'
import Vuex from 'vuex'
import axios from 'axios'


require('./bootstrap')
require('./helperClasses')

window.Vue = require('vue')

window.frontPageUrl = 'http://secan.app'

localforage.config({
    driver: localforage.LOCALSTORAGE,
    storeName: 'secan'
})

Vue.component('application', require('./components/Application.vue'))
Vue.component('navigation', require('./components/Navigation.vue'))
Vue.component('application-loading-page', require('./components/ApplicationLoadingPage.vue'))

let app

//this is logic I don't want for all routes, i just want this for app/user/x routes that require authentication.
//setting the token makes sence to do though
Promise.all([
    store.dispatch('auth/setToken').then(() => {
        axios.get('/api/istokenvalid')
        .then(() => {
            store.commit('auth/setAuthenticated', true)
        }).catch((error) => { 
            //a token was retreved, but it was invalid, then clear authentication and redirect to login
            store.dispatch('auth/clearAuthentication')
            
            window.location.replace(window.frontPageUrl)
        })

    }).catch((error) => {
        store.dispatch('auth/clearAuthentication')
        .then(() => {
            console.log('Not able to retreve a token, please log in to get a new one.')
            window.location.replace(window.frontPageUrl)
        })
    })
]).then(() => {
    app = new Vue({
        el: '#app',
        router: router,
        store: store,
        beforeCreate() {
            console.log('before create new Vue')
        },
        created() {
            console.log('created new Vue')
        }, 
        beforeMount() {
            console.log('before mount new Vue')
        },
        mounted() {
            console.log('mounted new Vue')
        },
        beforeDestroy() {
            console.log('before destroy new Vue')
            
            localforage.getItem('authtoken')
            .then((authtoken) => {
                localforage.clear().then(() => {
                    return authtoken
                })
            })
            .then((authtoken) => {
                localforage.setItem('authtoken', authtoken)
            })
            .catch((error) => {
                console.log(error)
            })
            
        },
        destroyed() {
            console.log('destroyed new Vue')
        }
    });
})



/*
*	A better way to deal with errors (avoiding "cannot access property "something" on null): 
*	Add @keydown="errors.clear($event.target.name)" to the form itself and use event.target.name to see what field was
*	modified, so that you can delete that specific fields error message.
*/

