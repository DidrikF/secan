import Vue from 'vue'
import Vuex from 'vuex'
import auth from '../app/auth/vuex'
import investorProfile from '../app/investorProfile/vuex'
import loading from '../app/loading/vuex'

Vue.use(Vuex)

export default new Vuex.Store({
	modules: {
		auth: auth, //auth.mutations.setToken()
		investorProfile: investorProfile,
		loading: loading
	}
})