export class Errors {
	constructor () {
		this.errors = {};
	}

	has(field) {
		return this.errors.hasOwnProperty(field)
	}

	any() {
		return Object.keys(this.errors).length > 0
	}

	get(field) {
		if(this.errors[field]) {
			return this.errors[field][0]
		}
	}

	record(errors) {
		this.errors = errors
	}

	clear(field) {
		delete this.errors[field]
	}

	all() {
		if(this.any())	return this.errors
	}
}

export class Form {
	constructor(data) {
		for(let field in data) {
			this[field] = data[field];
 		}
	}

	reset() {

	}

	submit() {
		//axios ??, but this does not work with the vuex workflow...
	}
}