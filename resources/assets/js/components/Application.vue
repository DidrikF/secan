<template>
    <div>
        <div class="Application__loadingpage" v-if="appLoading">
            <application-loading-page></application-loading-page>
        </div>
        <div v-else>    <!-- Ensuring user.data is set during application loading before rendering the navigation -->
            <navigation></navigation>

            <div class="container">
                <keep-alive>
                    <router-view></router-view> <!-- Where the views will be injected based on there we navigate using the router -->
                </keep-alive>
            </div>
        </div>
        

        <!-- <helper-panel></helper-panel> -->
    </div>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	export default {
		methods: {
			...mapActions({
				setToken: 'auth/setToken'
			})
		},
        computed: {
            ...mapGetters({
                appLoading: 'loading/getAppLoading'
            })
        },
		beforeCreate() {
			console.log('before create Application.vue')
		},
        created() {
            console.log('created Application.vue')
        }, 
        beforeMount() {
            console.log('before mount Application.vue')
        },
        mounted() {
            console.log('mounted Application.vue')
        },
        beforeDestroy() {
            console.log('before destroy Application.vue')
        },
        destroyed() {
            console.log('destroyed Application.vue')
        }
		
	}

</script>


