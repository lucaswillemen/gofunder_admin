if (!global.$post) {
  global.$post = {};
  global.$get = {};
}

var axios = require('axios')
var apiUrl = 'http://25.20.118.56/gofunder/api'


global.$get = function(section, form, token = false) {
  let data = global.$parseData(section, form)

  let headers = {
    'Content-Type': 'multipart/form-data'
  }
  if (token) headers.Authorization = token
  return axios({
    method: 'GET',
    url: apiUrl + section,
    data: data,
    headers: headers
  })
}

global.$post = function(section, form, token = false) {
  let data = global.$parseData(section, form)

  let headers = {
    'Content-Type': 'multipart/form-data'
  }

  if (token) headers.Authorization = token
  return axios({
    method: 'POST',
    url: apiUrl + section,
    data: data,
    headers: headers
  })
}


global.$parseData = function(section, form) {
  let data = new FormData()
  for (var i in form) {
    data.append(i, form[i])
  }
  return data
}