d<template>

    <div>
        <h3>Loading the application, please wait.</h3>
        <p>{{ errors.all() }}</p>

    </div>

</template>

<script>
	import localforage from 'localforage'
	import { Errors } from '../../../helperClasses'
	import { mapActions } from 'vuex'
	
	export default {
		data() {
			return {
				errors: new Errors
			}
		},
		methods: {
			...mapActions({
                loadApplication: 'auth/loadApplication'
            })
		},
		created() {
			let that = this
			setTimeout(function() {
				that.loadApplication().then(() => {
					return localforage.getItem('intendedRouteObject')
				}).then((intendedRouteObject) => {
					that.$router.replace(intendedRouteObject)				
				}).catch((error) => {
					that.errors.record(error)
				})
			}, 4000)
		}
	}

</script>