<template>
	<div>
        <balance-sheet></balance-sheet>
	</div>
</template>

<script>
    import BalanceSheet from './BalanceSheet'

    export default {
        components: {
            balanceSheet: BalanceSheet
        }
    }

/*
        data () {
            return {
                ticker: null, 
                value: null
            }
        },
        beforeCreate() {
        console.log('before create Analysis.vue')
        },
        created() {
            console.log('created Analysis.vue')
            axios.get('/api/analysis').then((response) => {
                    this.ticker = response.data.ticker
                    this.value = response.data.value
            })
        }, 
        beforeMount() {
            console.log('before mount Analysis.vue')
        },
        mounted() {
            console.log('mounted Analysis.vue')
            
        },
        beforeDestroy() {
            console.log('before destroy Analysis.vue')
        },
        destroyed() {
            console.log('destroyed Analysis.vue')
        }
        ,
        beforeRouteEnter (to, from, next) {
            // called before the route that renders this component is confirmed.
            // does NOT have access to `this` component instance,
            // because it has not been created yet when this guard is called!
            console.log('Before Route Enter Analysis.vue')
            next()
        },
        beforeRouteUpdate (to, from, next) {
            // called when the route that renders this component has changed,
            // but this component is reused in the new route.
            // For example, for a route with dynamic params /foo/:id, when we
            // navigate between /foo/1 and /foo/2, the same Foo component instance
            // will be reused, and this hook will be called when that happens.
            // has access to `this` component instance.
            console.log('Before Route Update Analysis.vue')
            next()
        },
        beforeRouteLeave (to, from, next) {
            // called when the route that renders this component is about to
            // be navigated away from.
            // has access to `this` component instance.
            console.log('Before Route Leave Analysis.vue')
            next()
        }
*/

</script>


