$(function() { 
  if (typeof FB != 'undefined') {
	    FB.init({
	        appId      : '468101889902680',
	        status     : true, 
	        cookie     : true,
	        xfbml      : true,
	        oauth      : true
	    });
    }

  initLoginDialog();
  
  initDatepicker();
    
});


var initLoginDialog = function() {
    var modalDialog = $('#main-modal-dialog');
    
    $('#login-button').click(function(e){
        modalDialog.jqm({
            ajax: '/auth/login'
        });                
        modalDialog.jqmShow();
    
        e.preventDefault();
    });

    $('#login-close').live('click', function(e){
        modalDialog.jqmHide();
        e.preventDefault();
    });
}

var doLogin = function(form) {
    var action = $(form).attr('action');
    var params = $(form).serialize();
    var loginSection = $('#show-login-holder');
    
    $.post(action, params, function(response) {
        if (typeof response == "object" && response.success == "true") {
            $('#main-modal-dialog').jqmHide();
            window.location.reload();
        }
        
        loginSection.html($(response).children());
    });
    
    return false;
}

var initDatepicker = function()
{
    $(".datepicker").datepicker({
        showOn: 'button',
        dateFormat: "dd/mm/yy",
        buttonImage: '/images/datepicker.gif'
    });    
}