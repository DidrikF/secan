

export const loadApplication = ({ commit, dispatch }, context) => { //might need context to output errors or progress
	return axios.get('api/user')
	.then((response) => {
		commit('auth/setUserData', response.data.user, { root: true })
		let username = response.data.user.username
		return Promise.all([
			axios.get(`/api/${username}/investorprofile`)
				.then((response) => {
					commit('investorProfile/setInvestorProfile', response.data.investor_profile, { root: true })
					commit('investorProfile/setInvestingRules', response.data.investing_rules, { root: true })
					commit('investorProfile/setInvestingGoals', response.data.investing_goals, { root: true })
					commit('investorProfile/setSecuritiesOfInterest', response.data.securities_of_interest, { root: true })
					commit('investorProfile/setIndustriesOfInterest', response.data.industriesOfInterest, { root: true })
					commit('investorProfile/setInvestingStrategies', response.data.investing_strategies, { root: true })
				})
			,
			/*
			axios.get('/api/')
				.then((response) => {

				})
			*/
		])
	})
	//Error handled in ApplicationLoadingPage.vue
}
