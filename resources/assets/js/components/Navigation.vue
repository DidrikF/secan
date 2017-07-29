s<template>

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <!-- Branding Image -->
                <router-link :to="{ name: 'home' }">Secan Home</router-link>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- render if unathenticated 
                <ul class="nav navbar-nav navbar-right" v-if="!user.authenticated">
                    <li><router-link :to="{ name: 'login' }">Login</router-link></li>
                    <li><router-link :to="{ name: 'register' }">Register</router-link></li>
                </ul>
                -->

                <!-- render if authenticated -->
                <ul class="nav navbar-nav navbar-right" v-if="user.authenticated">
                    <li><router-link :to="{ name: 'analysis' }">Analysis</router-link></li>
                    <li><router-link :to="{ name: 'investorprofile', params: { username: user.data.username } }">Investor Profile</router-link></li>
                    
                    <li><a href="#" @click.prevent="signout">Logout</a></li>

                    <li v-if="user.data"><span>Welcome, {{ user.data.name }}!</span></li>

                </ul>

            </div>
        </div>
    </nav>

</template>

<script>
    import { mapGetters, mapActions } from 'vuex'

    export default {
        data() {
            return  {
            }
        },
        computed: {
            ...mapGetters({
                user: 'auth/user'
            })
        },
        methods: {
            ...mapActions({
                logout: 'auth/logout'
            }),
            signout () {
                this.logout().then(() => {
                    window.location.replace(window.frontPageUrl)
                })
            }
        }
        ,
        beforeCreate() {
            console.log('before create Navigation.vue')
        },
        created() {
            console.log('created Navigation.vue')
        }, 
        beforeMount() {
            console.log('before mount Navigation.vue')
        },
        mounted() {
            console.log('mounted Navigation.vue')
        },
        beforeDestroy() {
            console.log('before destroy Navigation.vue')
        },
        destroyed() {
            console.log('destroyed Navigation.vue')
        }
        //router.push({ name: 'user', params: { userId: 123 }}) used to navigate
        
    }

</script>

