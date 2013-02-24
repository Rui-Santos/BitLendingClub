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
  
  initWithdrawDialog();
  
  initFundDialog();
  
  initInvestDialog();
  
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

var initWithdrawDialog = function() {
    var modalDialog = $('#main-modal-dialog');
    
    $('#dash-withdraw').click(function(e){
        modalDialog.jqm({
            ajax: '/profile/withdraw'
        });                
        modalDialog.jqmShow();
    
        e.preventDefault();
    });

    $('#login-close').live('click', function(e){
        modalDialog.jqmHide();
        e.preventDefault();
    });
}

var initFundDialog = function() {
    var modalDialog = $('#main-modal-dialog');
    
    $('#dash-add-funds').click(function(e){
        modalDialog.jqm({
            ajax: '/profile/fund'
        });                
        modalDialog.jqmShow();
    
        e.preventDefault();
    });

    $('#login-close').live('click', function(e){
        modalDialog.jqmHide();
        e.preventDefault();
    });
}

var initInvestDialog = function() {
    var modalDialog = $('#main-modal-dialog');
    
    $('#dash-invest').click(function(e){
        
        modalDialog.jqm({
            ajax: '/loan/invest'
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

var doWithdraw = function(form) {
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

var doInvest = function(form) {
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