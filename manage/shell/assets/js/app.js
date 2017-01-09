(function(jQuery, window, document, undefined){

  var $window = jQuery(window)
  var $pwd    = null

  var $term = jQuery('body').terminal(function(command, term){

      jQuery.ajax({
        type: 'post',
        data: {q: command, pwd: $pwd},
        headers: {Authorization: term.token()},
        dataType: 'json',
        success: function (response) {

          term.set_prompt(term.login_name()+':'+response.pwd+' > ')
          term.echo(response.output)
          $pwd = response.pwd


        },
        error: function (err) {
          term.logout()
        }
      })

    }, {
      greetings: false,
      memory: true,
      login: function(user, pass, callback){
        jQuery.post('?login', {user:user, pass:pass}, function(response){
          $pwd = response.pwd
          callback(response.auth)
        })
      },
      onInit: function(term) {
        term.set_prompt(term.login_name()+':~ > ')
      }
  })

  $window.resize(function(){
    var _height = $window.height()
    $term.innerHeight(_height - 50)
  }).resize()

})(jQuery, window, document, undefined)
