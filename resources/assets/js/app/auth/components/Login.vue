<template>
	<div class="container">
	    <div class="row">
	        <div class="col-md-8 col-md-offset-2">
	            <div class="panel panel-default">
	                <div class="panel-heading">Login</div>
	                <div class="panel-body">

	                <div class="alert alert-danger" v-if="errors.root">
	                	{{ errors.get('root') }}
	                </div>

	                    <form class="form-horizontal" role="form" @submit.prevent="submit"> 
	                    <!-- @keydown="errors.clear($event.target.name) -->
	                        <div class="form-group" v-bind:class="{ 'har-error' : errors.email }">
	                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

	                            <div class="col-md-6">
	                                <input id="email" type="email" class="form-control" name="email"equired autofocus v-model="email">
	                                <div class="help-block" v-if="errors.email">
	                                	{{ errors.get('email') }}
	                                </div>

	                            </div>
	                        </div>

	                        <div class="form-group" v-bind:class="{ 'har-error' : errors.password }">
	                            <label for="password" class="col-md-4 control-label">Password</label>

	                            <div class="col-md-6">
	                                <input id="password" type="password" class="form-control" name="password" v-model="password">
	                                 <div class="help-block" v-if="errors.password"> <!-- v-if="errors.has('password') -->
	                                	{{ errors.get('password') }}	
	                                	<!-- errors.get('password') //avoid property on null error -->
	                                </div>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <div class="col-md-8 col-md-offset-4">
	                                <button type="submit" class="btn btn-primary">
	                                    Login
	                                </button>

	                                <a class="btn btn-link" href="">
	                                    Forgot Your Password?
	                                </a>
	                            </div>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</template>


<script>
    import { mapActions } from 'vuex'
    import localforage from 'localforage'
    import { isEmpty } from 'lodash'
    import { Errors } from '../../../helperClasses'

    export default {
        data () {
            return {
                email: null,
                password: null,
                errors: new Errors() //new Errors();
            }
        },
        methods: {
        	//auth.actions.login (from the Vuex.store object)
            ...mapActions({
                login: 'auth/login',
                load: 'auth/loadApplication'
            }),
            submit () {
                this.login({
                    payload: {
                        email: this.email,
                        password: this.password
                    },
                    context: this //to add errors
                }).then(() => {
                	//this.loadApplication()
                	this.$router.replace({ name: 'loadingpage' })
                })
            }
            /*,
            loadApplication () {
            	this.load().then(() => {
	            	localforage.getItem('intendedRouteObject').then((routeObject) => {
						if(isEmpty(routeObject)) {
							this.$router.replace({ name: 'home' })
							return
						}               		
	            		this.$router.replace(routeObject)
	            	})	
            	}).catch((error) => {
            		console.log('Unable to load initial application data, the following error was returned:')
            		console.log(error)
            		//Dont know should happen now...
            	})
            }
            */
        }
    }
</script>
