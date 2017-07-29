import store from '../vuex'
import localforage from 'localforage'

const beforeEach = ((to, from, next) => {   //to and from are route objects.
    store.dispatch('auth/checkTokenExists').then(() => {
        if (to.meta.guest) {    //Login and register pages have meta.guest = true
            next({ name: 'home' })  //Go to home if user is navigating to Login/Register page, when token is present
            return
        }

        next()
    }).catch(() => {
        if (to.meta.needsAuth) {	//if we are not loged in (no token) and we try to navigate to a url that needs authentication, redirect to login.
            localforage.setItem('intendedRouteObject', to)
            .then(() => {
                window.location.replace(window.frontPageUrl)
            })
            
            //next({ name: 'login' })
            return
        }

        next()
    })
})

export default beforeEach