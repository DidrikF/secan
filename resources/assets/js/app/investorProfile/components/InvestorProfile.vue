<template>
	<div>
        <h3>Investor Profile Page</h3>
        <div>
            <input v-model="investorProfile.name"></input> <!-- v-cloak -->
        </div>
        <div>
        <textarea v-model="investorProfile.investing_philosophy"></textarea>
        </div>
        <div>
            <textarea v-model="investorProfile.knowledge_and_experience"></textarea>
        </div>
        
        <div>
            <h4>Investing Rules</h4>

            <div v-for="(rule, index) in investingRules" class="box">
                <textarea :value="rule.text" @input="updateInvestingRule(index, 'text', $event.target.value)"></textarea>
                <input :value="rule.type" @input="updateInvestingRule(index, 'type', $event.target.value)"></input>
                <input :value="rule.quantitative_measure" @input="updateInvestingRule(index, 'quantitative_measure', $event.target.value)"></input>
            </div>
        </div>
        <div>
            <h4>Investing Goals</h4>
            <div v-for="(goal, index) in investingGoals" class="box">
                 <textarea :value="goal.text" @input="updateInvestingGoal(index, 'text', $event.target.value)"></textarea>
                <input :value="goal.type" @input="updateInvestingGoal(index, 'type', $event.target.value)"></input>
                <input :value="goal.quantitative_measure" @input="updateInvestingGoal(index, 'quantitative_measure', $event.target.value)"></input>
                <button @click="deleteInvestingGoal(index)">Delete</button>
            </div>
            <h5>New Goal</h5>
            <div>
                <textarea v-model="newGoal.text"></textarea>
                <input v-model="newGoal.type"></input>
                <input v-model="newGoal.quantitative_measure"></input>
                <button @click="addInvestingGoal">Add</button>
            </div>
        </div>

        <div>
            <h4>Securities of interest</h4>
            <div v-for="security in securitiesOfInterest" class="box">
                <input v-model="security.security_info.type"></input> 
                <!-- Not a problem here because there is no securitiesOfInterest to out put in the first place -->
                <textarea v-model="security.description"></textarea>
            </div>
        </div>
        <!--
        <div v-for="industry in industriesOfInterest">
            <input v-model="industry.industry_info.name">{{ industry.industry_info.name }}</input>
            <textarea v-model="industry.description"></textarea>
        </div>

        <div v-for="strategy in investingStrategies">
            <input v-model="strategy.name"></input>
            <textarea v-model="strategy.description"></textarea>
        </div>
        -->
        <!--
        <p>{{ investorProfileTest.id }}</p>
        -->
    </div>
</template>

<script>
    import { mapActions, mapState, mapMutations } from 'vuex'
    import { Errors } from '../../../helperClasses'

    export default {
        data () {
            return {
                newGoal: {
                    text: null,
                    type: null,
                    quantitative_measure: null
                },
                errors: new Errors
            }
        },
        computed: {//= {} when fist loaded
            ...mapState({
                investorProfile: state => state.investorProfile.investorProfile, 
                investingRules: state => state.investorProfile.investingRules,
                investingGoals: state => state.investorProfile.investingGoals,
                securitiesOfInterest: state => state.investorProfile.securitiesOfInterest,
                industriesOfInterest: state => state.investorProfile.industriesOfInterest,
                investingStrategies: state => state.investorProfile.investingStrategies
            }),
            investorProfileTest() {
                return this.$store.state.investorProfile.investorProfile
            } 
        },
        methods: {
            ...mapActions({
                getInvestorProfile: 'investorProfile/getInvestorProfile',
                saveInvestorProfile: 'investorProfile/saveInvestorProfile'
            }),
            addInvestingGoal() {
                let newGoal = {
                    text: this.newGoal.text,
                    type: this.newGoal.type,
                    quantitative_measure: this.newGoal.quantitative_measure
                }
                this.$store.commit('investorProfile/addInvestingGoal', newGoal, {root: true})
                clearNewGoalForm()
            },
            deleteInvestingGoal(index) {
                this.$store.commit('investorProfile/deleteInvestingGoal', index, {root: true})
            },
            updateInvestingRule(index, property, value) {
                this.$store.commit('investorProfile/updateInvestingRule', {index, property, value}, {root: true})
            },
            updateInvestingGoal(index, property, value) {
                this.$store.commit('investorProfile/updateInvestingGoal', {index, property, value}, {root: true})
            },
            clearNewGoalForm() {
                this.newGoal.text = null
                this.newGoal.type = null
                this.newGoal.quantitative_measure = null
            }
        },
        watch: {
            '$route' (to, from) {
            // react to route changes... when loading the same component with different data... 
            // avioding recreation of the component
            // <div>{{ $route.params.id }}</div> <- how to access route parameters
            }
        },
        deactivated() {

        }
    }
//the store is bound to all child components of the root when passing it in as an option when instantiating the Vue instance, this is enabled by calling Vue.use(Vuex).                
</script>

<style>
    .box {
        border: 2px solid black;
        padding: 5px;
    }

    [v-cloak] {
      display: none;
    }

</style>



