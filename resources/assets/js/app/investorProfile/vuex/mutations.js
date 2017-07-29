import localforage from 'localforage'
import { isEmpty } from 'lodash'

/*
*	We pass the state object into each mutation so that it can modify the state of the store.
*/

/*
*	SET
*/
export const setInvestorProfile = (state, data) => { //this is module local state, so it will be "namespaced" properly.
	state.investorProfile = data ? data : {}
}

export const setInvestingRules = (state, data) => {
	state.investingRules = data ? data : {}
}

export const setInvestingGoals = (state, data) => {
	state.investingGoals = data ? data : {}
}

export const setSecuritiesOfInterest = (state, data) => {
	state.securitiesOfInterest = data ? data : {}
}

export const setIndustriesOfInterest = (state, data) => {
	state.industriesOfInterest = data ? data : {}
}

export const setInvestingStrategies = (state, data) => {
	state.investingStrategies= data ? data : {}
}

/*
*	UPDATE
*/
export const updateInvestorProfile = (state, payload) => {
	state.investorProfile[payload.property] = payload.value
}

export const updateInvestingRule = (state, payload) => {
	state.investingRules[payload.index][payload.property] = payload.value
}

export const updateInvestingGoal = (state, payload) => {
	state.investingGoals[payload.index][payload.property] = payload.value
}

export const updateSecurityOfInterest = (state, payload) => {
	state.securitiesOfInterest[payload.index][payload.property] = payload.value
}

export const updateIndustryOfInterest = (state, payload) => {
	state.industriesOfInterest[payload.index][payload.property] = payload.value
}

export const updateInvestingStrategy = (state, payload) => {
	state.investingStrategies[payload.index][payload.property] = payload.value
}

/*
*	ADD
*/

export const addInvestingRule = (state, value) => {
	state.investingRules.push(value)
}

export const addInvestingGoal = (state, value) => {
	state.investingGoals.push(value)
}

export const addSecurityOfInterest = (state, value) => {
	state.securitiesOfInterest[payload.index] = payload.value
}

export const addIndustryOfInterest = (state, value) => {
	state.industriesOfInterest[payload.index] = payload.value
}

export const addInvestingStrategy = (state, value) => {
	state.investingStrategies[payload.index] = payload.value
}

/*
*	DELETE
*/


export const deleteInvestingRule = (state, index) => {
	state.investingRules.splice(index, 1)
}

export const deleteInvestingGoal = (state, index) => {
	state.investingGoals.splice(index, 1)
}

export const deleteSecurityOfInterest = (state, index) => {
	state.securitiesOfInterest.splice(index, 1)
}

export const deleteIndustryOfInterest = (state, index) => {
	state.industriesOfInterest.splice(index, 1)
}

export const deleteInvestingStrategy = (state, index) => {
	state.investingStrategies.splice(index, 1)
}

