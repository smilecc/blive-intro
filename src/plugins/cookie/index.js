
function plugin (Vue) {
  if (plugin.installed) {
    return
  }

  let cookie = {
    get: (cookieName) => {
      if (window.document.cookie.length > 0) {
        let start = window.document.cookie.indexOf(cookieName + '=')
        if (start !== -1) {
          start = start + cookieName.length + 1
          let end = window.document.cookie.indexOf(';', start)
          if (end === -1) {
            end = window.document.cookie.length
          }
          return unescape(window.document.cookie.substring(start, end))
        }
      }
      return undefined
    },
    set: (name, value, expiredays) => {
      let exdate = new Date()
      exdate.setDate(exdate.getDate() + expiredays)
      window.document.cookie = name + '=' + escape(value) + ((expiredays === null) ? '' : ';path=/ ;expires=' + exdate.toGMTString())
    }
  }
  plugin.cookie = cookie

  Vue.cookie = cookie
  Object.defineProperties(Vue.prototype, {
    $cookie: {
      get () {
        return cookie
      }
    }
  })
}

export default plugin
