require('dotenv').config()

const PROXY = process.env.PROXY || 'http://localhost/wptest'

module.exports = {
  host: 'localhost',
  port: 3333,
  proxy: PROXY,
  urlOverride: new RegExp(PROXY.replace('http://', ''), 'g') // /localhost\/wptest/g
}
