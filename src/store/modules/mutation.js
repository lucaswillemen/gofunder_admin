export default {
  SET(state, payload) {
    for (var i in payload) {
      state[i] = payload[i]
    }
  },
  PUSH(state, payload) {
    state[payload.array].push(payload.obj)
  },
  REMOVE(state, payload) {
    let array = state[payload.array]
    array.splice(array.indexOf(payload.obj), 1)
  }
}