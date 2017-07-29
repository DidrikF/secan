import { isEmpty } from 'lodash'
import { setHttpToken } from '../../../helpers' //import the constant by name setHttpToken, no {} means to import default (which there can only be one of per file btw)
import localforage from 'localforage'


//NOT USED ATM
export const register = ({ dispatch }, { payload, context }) => {
	return axios.post('/api/register', payload)
	.then((response) => {
		dispatch('setToken', response.data.meta.token)
		commit('setAuthenticated', true)
	}).catch((error) => {
        contect.errors.record(error.response.data.errors)
    })
}

//NOT USED ATM
export const login = ({ dispatch, commit }, { payload, context }) => {
	return axios.post('/api/login', payload)
	.then((response) => {
		dispatch('setToken', response.data.meta.token)
		commit('setAuthenticated', true)
	}).catch((error) => {
		console.log(error)
        //context.errors.record(error.response.data.errors)
    })
}

export const logout = ({ dispatch }) => {
	return axios.post('/api/logout')
	.then((response) => {
		dispatch('clearAuthentication')
	})
}

/*
*	Helper methods
*/

export const setToken = ({ commit, dispatch }, token) => { 
	if(isEmpty(token)) {
		return dispatch('checkTokenExists')
		.then((token) => { //Promise.resolve(token) is thenable...
			setHttpToken(token)
		})
	}
	commit('setToken', token)
	setHttpToken(token)
}

export const checkTokenExists = ({ commit, dispatch }) => {
	return localforage.getItem('authtoken')
	.then((token) => {
		if(isEmpty(token)) {
			return Promise.reject(new Error('NO_STORAGE_TOKEN'))
		}

		return Promise.resolve(token)
	})
}

export const isTokenValid = ({dispatch}, token) => { //assume token is set at this point (NOT USED ATM)
	return axios.get('/api/istokenvalid')
}

export const clearAuthentication = ({ commit }, token) => {
	commit('setAuthenticated', false)
	commit('setUserData', null)
	commit('setToken', null)
	setHttpToken(null)
}

/*	NOTES:
*	we use named parameters to pass into the functions only what we need. We could pass in state as well,
*	if it was needed. Dispatch is used to call other actions, commit is used to call mutations.
*	Mutations and getters need to be passed the state.
*/