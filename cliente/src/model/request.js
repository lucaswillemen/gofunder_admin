if (!global.$post) {
  global.$post = {};
}

var axios = require('axios')
var apiUrl = 'http://api.gofunder.io'


global.$get = function(section, form, token = false) {
  let data = new FormData()
  for (var i in form) {
    data.append(i, form[i])
  }
  let headers = {
    'Content-Type': 'multipart/form-data'
  }

  if (token) {
    headers.Authorization = token
  }
  return axios({
    method: 'GET',
    url: apiUrl + section,
    data: data,
    headers: headers
  })
}

global.$post = function(section, form, token = false) {
  let data = new FormData()
  for (var i in form) {
    data.append(i, form[i])
  }
  let headers = {
    'Content-Type': 'multipart/form-data'
  }
  if (token) {
    headers.Authorization = token
  }

  return axios({
    method: 'POST',
    url: apiUrl + section,
    data: data,
    headers: headers
  })
}