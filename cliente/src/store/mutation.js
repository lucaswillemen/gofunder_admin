export default {
    set(state, payload) {
        for (var i in payload) {
            state[i] = payload[i]
        }
    },
    push(state, payload) {
        state[payload.array].push(payload.obj)
    },
    remove(state, payload) {
        let array = state[payload.array]
        array.splice(array.indexOf(payload.obj), 1)
    }
}
