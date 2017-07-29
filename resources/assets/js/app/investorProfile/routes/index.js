import { InvestorProfile } from '../components'

export default [
	{
		path: '/:username/investorprofile/',
		component: InvestorProfile,
		name: 'investorprofile',
		meta: {
			guest: false,
			needsAuth: true
		}
	}
	/* EXAMPLE:
	,children: [
        {
          // UserProfile will be rendered inside User's <router-view>
          // when /user/:id/profile is matched
          path: 'investingstrategies',
          component: InvestingStrategies
        },
        { path: '', component: InvestorProfileHome } //to render a default view
		//render components inside components by defining the children and adding <router-view></router-view> in the component
	*/
]