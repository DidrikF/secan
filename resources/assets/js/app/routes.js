//Pull together all routes from the different pages of your application.

import auth from './auth/routes' //same as ./auth/routes/index.js
import home from './home/routes'
import loading from './loading/routes'
import analysis from './analysis/routes'
import errors from './errors/routes'
import investorProfile from './investorProfile/routes'

export default [
	...auth, 
	...home,
	...loading,
	...analysis,
	...investorProfile,
	...errors
] 

//the router looks for a match from the beginning to the end. Adding the error routes at the beginning would render 404 every time.