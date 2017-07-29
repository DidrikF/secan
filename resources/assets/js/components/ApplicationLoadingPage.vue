<template>

    <div class="box">
        <h3>Loading the application, please wait.</h3>
        <p>{{ errors.all() }}</p>
        <button v-on:click="backToFrontPage">Go Back</button>

    </div>

</template>

<script>
	import localforage from 'localforage'
	import { Errors } from '../helperClasses'
	import { mapActions } from 'vuex'
	
	export default {
		data() {
			return {
				errors: new Errors
			}
		},
		methods: {
			...mapActions({
                loadApplication: 'loading/loadApplication'
            }),
			backToFrontPage: () => {
				window.location.replace(window.frontPageUrl) //+ cleanup...
			}
		},
		created() {

			this.loadApplication().then(() => {
				//return Promise.reject('loading the application failed')
				return localforage.getItem('intendedRouteObject')
			}).then((intendedRouteObject) => {
				return localforage.removeItem('intendedRouteObject')
				.then(() => {
					return intendedRouteObject;
				})
			})
			.then((intendedRouteObject) => {
				this.$store.commit('loading/setAppLoading', false)
				this.$router.replace(intendedRouteObject) //if none, it just routes to home
			})
			.catch((error) => {	//only Promise.reject() will stop the promise chain, if an error is thrown, for example, catch is called to deal with the error then the promise chain continues!
				if(error.response) {
					this.errors.record(error.response.data.error)
					return
				}
				this.errors.record('Something went wrong when loading the application.' + error)

			})
		}
	}

</script>

<style>
	.box {
		background-color: blue;
		margin-top: -20px;
		width: 100%;
		height: 100%;
	}
</style>