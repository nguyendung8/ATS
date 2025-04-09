const middleware = {}

middleware['permission'] = require('..\\middleware\\permission.js')
middleware['permission'] = middleware['permission'].default || middleware['permission']

export default middleware
