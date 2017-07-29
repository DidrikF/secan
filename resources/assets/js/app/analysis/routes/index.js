import { Analysis } from '../components'

export default [
	{
		path: '/analysis', //app/analysis
		component: Analysis,
		name: 'analysis',
		meta: {
			needsAuth: true
		}
	}
	
]