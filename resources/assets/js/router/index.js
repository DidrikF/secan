import Vue from 'vue'
import Router from 'vue-router'
import { routes as routes } from '../app/index' 
import beforeEach from './beforeEach'

Vue.use(Router)

const router = new Router({
	routes: routes
})

//reigster beforeEach hooks
router.beforeEach(beforeEach)



export default router

/*

You can used many advanced matching patterns such as optional dynamic segments, zero or more / one or more requirements, 
and even custom regex patterns. 

Matching priority is cascading

You can directly access this inside beforeRouteLeave. The leave guard is usually used to prevent the user from 
accidentally leaving the route with unsaved edits.


*/