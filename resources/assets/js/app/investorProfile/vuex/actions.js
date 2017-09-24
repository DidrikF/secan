import { isEmpty } from 'lodash'
import { setHttpToken } from '../../../helpers' //import the constant by name setHttpToken, no {} means to import default (which there can only be one of per file btw)
import localforage from 'localforage'


export const getInvestorProfile = ({ commit, state }, {routeParamUsername}) => { //state is the module's state, not the root state.
	return axios.get('/api/' + routeParamUsername + '/investorprofile')
	.then((response) => {
		commit('setInvestorProfile', response.data.investor_profile)
		commit('setInvestingRules', response.data.investing_rules)
		commit('setInvestingGoals', response.data.investing_goals)
		commit('setSecuritiesOfInterest', response.data.securities_of_interest)
		commit('setIndustriesOfInterest', response.data.industriesOfInterest)
		commit('setInvestingStrategies', response.data.investing_strategies)
	}).catch((error) => {
        state.errors.record(error.response.data.errors)
    })
}

export const saveInvestorProfile = ({ state }, { routeParamUsername }) => {
	return axios.post('/api/' + routeParamUsername + '/investorprofile', {
		investorProfile: null
	})
	.then((response) => {

	})
	.catch((error) => {

	})
}
