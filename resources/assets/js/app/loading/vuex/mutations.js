

export const setAppLoading = (state, trueOrFalse) => { //this is module local state, so it will be "namespaced" properly.
	state.appLoading = trueOrFalse;
}