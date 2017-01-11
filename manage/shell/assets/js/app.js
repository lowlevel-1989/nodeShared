(function(jQuery, window, document, undefined){

  var $window = jQuery(window)
  var $pwd    = null

  function step(command, term, _query){

    var data = {}
    data['pwd']  = $pwd
    data[_query] = command

    jQuery.ajax({
      type: 'post',
      data: data,
      headers: {Authorization: term.token()},
      dataType: 'json',
      success: function (response) {

        term.set_prompt(term.login_name()+':'+response.pwd+' > ')
        term.echo(response.output)
        $pwd = response.pwd

        if (response.clear) term.clear()

        if (response.active){
          term.disable()
          step(command, term, 'step')
        }else term.enable()

      },
      error: function (err) {
        term.logout()
      }
    })
  
  }

  var $term = jQuery('body').terminal(function(command, term){

      step(command, term, 'q')


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
