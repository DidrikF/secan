import localforage from 'localforage'
import { isEmpty } from 'lodash'

/*
*	We pass the state object into each mutation so that it can modify the state of the store.
*/

export const setToken = (state, token) => {
    if (isEmpty(token)) {
        localforage.removeItem('authtoken', token)
        return
    }
    //Exit and reenter the "inspection console"
    localforage.setItem('authtoken', token) //add callback to deal with errors, or do more with the value if setItem was successful
}

export const setAuthenticated = ( state, trueOrFalse ) => {
	state.user.authenticated = trueOrFalse
}

export const setUserData = ( state, data ) => {
	state.user.data = data ? data : {}
}

/*
export const setInitialApplicationData = ( state, data ) => {
	rootState.investorProfile.investorProfile = data.investor_profile ? : null //module...
	
	rootState.investingRules = data.investing_rules ? : null
	rootState.investingGoals = data.investing_goals ? : null
	rootState.securitiesOfInterest = data.securities_of_interest ? : null
	rootState.industriesOfInterest = data.industries_of_interest ? : null
	rootState.investingStrategies= data.investing_trategies ? : null


}
*/