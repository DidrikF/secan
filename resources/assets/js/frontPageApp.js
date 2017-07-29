import localforage from 'localforage'
import { isEmpty } from 'lodash'

let axios = require('axios');

localforage.config({
    driver: localforage.LOCALSTORAGE,
    storeName: 'secan'
})

let applicationUrl = 'http://secan.app/app'

localforage.getItem('authtoken')
.then((authtoken) => {
	axios.defaults.headers.common = {
	    'X-CSRF-TOKEN': window.Laravel.csrfToken, //NOT BEING CHECKED ATM
	    'X-Requested-With': 'XMLHttpRequest',
	    'authorization': 'bearer ' + authtoken
	};
	return Promise.resolve()
})
.then(() => {
	return isTokenValid()
})
.then((isTokenValid) => {
	let button = document.createElement("BUTTON")
	let text = document.createTextNode("Go To Secan")
	button.appendChild(text);
	button.addEventListener("click", function () {
		window.location.replace(applicationUrl)
	})
	document.getElementById('go-to-secan-placeholder').appendChild(button)
})
.catch((error) => {
	localforage.removeItem('authtoken')
	axios.defaults.headers.common = {
	    'X-CSRF-TOKEN': window.Laravel.csrfToken, //NOT BEING CHECKED ATM
	    'X-Requested-With': 'XMLHttpRequest',
	    'authorization': ''
	}
})

//Event Handlers
document.getElementById('show-login-button').addEventListener("click", function () { show('login-form') })
document.getElementById('hide-login-button').addEventListener("click", function () { hide('login-form'); clearLoginForm() }) 
document.getElementById('submit-login-button').addEventListener("click", function () { login() })

document.getElementById('login-email').addEventListener("keydown", function () { clearNodeValue('login-root-error') })
document.getElementById('login-password').addEventListener("keydown", function () { clearNodeValue('login-root-error') })


document.getElementById('show-register-button').addEventListener("click", function () { show('register-form') }) 
document.getElementById('hide-register-button').addEventListener("click", function () { hide('register-form'); clearRegistrationForm() }) 
document.getElementById('submit-register-button').addEventListener("click", function () { register() })

/*
document.getElementById('register-name-error').addEventListener("change", function () { clearValue('register-name-error') })
document.getElementById('register-email-error').addEventListener("change", function () { clearValue('register-email-error') })
document.getElementById('register-username-error').addEventListener("change", function () { clearValue('register-username-error') })
document.getElementById('register-password-error').addEventListener("change", function () { clearValue('register-password-error') })
*/

const login = function () {
	let email = document.getElementById('login-email')
	let password = document.getElementById('login-password')

	clearLoginErrors()

	axios.post('/api/login', { email: email.value, password: password.value }) //add csrf field (by configuring axios!)
	.then((response) => {
		localforage.setItem('authtoken', response.data.meta.token)
		.then(() => {
			window.location.replace(applicationUrl)
		})
	})
	.catch((error) => {
		clearValue('login-password')

		let rootErrorText = ''
		let emailErrorText = ''
		let passwordErrorText = ''
		try {
			rootErrorText = (error.response.data.errors.root !== undefined) ? error.response.data.errors.root : '';
		} catch (error) {
			console.log('Unknow error when loggin in. Error: ' + error)
			rootErrorText = '';
		}
		try {
			emailErrorText = (error.response.data.errors.email !== undefined) ? error.response.data.errors.email : '';
		} catch (error) {
			console.log('Unknow error when loggin in. Error: ' + error)
			emailErrorText = '';
		}
		try {
			passwordErrorText = (error.response.data.errors.password !== undefined) ? error.response.data.errors.password : '';
		} catch (error) {
			console.log('Unknow error when loggin in. Error: ' + error)
			passwordErrorText = '';
		}
		document.getElementById('login-root-error').textContent = rootErrorText
		document.getElementById('login-email-error').textContent = emailErrorText 
		document.getElementById('login-password-error').textContent = passwordErrorText 
	})

}

const register = function () {
	let name = document.getElementById('register-name')
	let email = document.getElementById('register-email')
	let username = document.getElementById('register-username')
	let password = document.getElementById('register-password')

	clearRegistrationErrors()

	axios.post('/api/register', { name: name.value, email: email.value, username: username.value, password: password.value }) //add csrf field (by configuring axios!)
	.then((response) => {
		localforage.setItem('authtoken', response.data.meta.token)
		.then(() => {
			window.location.replace(applicationUrl)
		})
	})
	.catch((error) => {
		clearValue('register-password')
		let nameError
		let emailError
		let usernameError
		let passwordError
		try {
			nameError = (error.response.data.errors.name !== undefined) ? error.response.data.errors.name : '';
		} catch (error) {
			nameError = ''
		}
		try {
			emailError = (error.response.data.errors.email !== undefined) ? error.response.data.errors.email : '';
		} catch (error) {
			emailError = ''
		}
		try {
			usernameError = (error.response.data.errors.username !== undefined) ? error.response.data.errors.username : '';
		} catch (error) {
			usernameError = ''
		}
		try {
			passwordError = (error.response.data.errors.password !== undefined) ? error.response.data.errors.password : '';
		} catch (error) {
			passwordError = ''
		}
		document.getElementById('register-name-error').appendChild(document.createTextNode(nameError))
		document.getElementById('register-email-error').appendChild(document.createTextNode(emailError))
		document.getElementById('register-username-error').appendChild(document.createTextNode(usernameError))
		document.getElementById('register-password-error').appendChild(document.createTextNode(passwordError))

	})
}

/*
*	HELPERS
*/

const setHttpToken = (token) => {
	if(isEmpty(token)) {
		axios.defaults.headers.common['Authorization'] = null
	}
	axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
}

//"Go To Secan" button if user is loged in
const isTokenValid =  function () {
	return axios.get('/api/istokenvalid')
}

const show = function (elementId) {
	document.getElementById(elementId).classList.remove('--hide')
}

const hide = function (elementId) {
	document.getElementById(elementId).classList.add('--hide')
}

const clearValue = function (elementId) {
	document.getElementById(elementId).value = null
}

const clearNodeValue = (elementId) => {
	document.getElementById(elementId).textContent = ''
}

const clearLoginErrors = () => {
	clearNodeValue('login-email-error')
	clearNodeValue('login-password-error')
	clearNodeValue('login-root-error')
}

const clearRegistrationErrors = () => {
	clearNodeValue('register-name-error')
	clearNodeValue('register-email-error')
	clearNodeValue('register-username-error')
	clearNodeValue('register-password-error')
}

const clearLoginForm = () => {
	clearValue('login-email')
	clearValue('login-password')

	clearValue('login-email-error')
	clearValue('login-password-error')
	clearValue('login-root-error')
}

const clearRegistrationForm = () => {
	clearValue('register-name')
	clearValue('register-email')
	clearValue('register-username')
	clearValue('register-password')

	clearNodeValue('register-name-error')
	clearNodeValue('register-email-error')
	clearNodeValue('register-username-error')
	clearNodeValue('register-password-error')
}




