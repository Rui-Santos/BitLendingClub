$(function() { 
   
    FB.init({
        appId      : '300487403363155',
        status     : true, 
        cookie     : true,
        xfbml      : true,
        oauth      : true
    });
                    
    // this varialbe 
    // should be a result of an ajax call 
    // from the backend to start the effect.
    if (typeof totalAmmount != 'undefined') {
        /**
         *  refactoring with external javascript object for calendar and buyings
         *  
         */
        var $totalAmmount  = totalAmmount;
        
        countdown.setTotalAmmount(totalAmmount)
        .setAustDay(dealExpiryDate)
        .initCountdown();
    }
    
    initLoginDialog();
    
    initRegisterDialog();
    
    initForgottenPasswordDialog();
    
    // Add lightbox to all rel links that has value lightbox
    $('a.lightbox').lightBox();
    
    initDealDetailSection();
    
    initTooltip();
    
    // Adding initialization of datepicker
    initDatepicker();
    
    $('#deactivate-profile-btn').live('click', function() {
        var action = ''; // url for the XHR post action
        
        $.post(action, {}, function(response) {
            console.log(response);
        });
    });
    
    countryCityMunicipalityAj();
    
    initVauchers();
    
});


var initDatepicker = function() {
    $(".datepicker").datepicker({
        showOn: 'button',
        dateFormat: "dd/mm/yy",
        buttonImage: '/images/datepicker.gif'
    });    
}


var initLoginDialog = function() {
    var modalDialog = $('#main-modal-dialog');
    
    $('#login-section-button').click(function(e){
        modalDialog.jqm({
            ajax: '/auth/login'
        });                
        modalDialog.jqmShow();
    
        e.preventDefault();
    });
    
    $('#register-dialog').live('click', function(e){
        $('#login-close').trigger('click');
        $('#register-section-button').trigger('click');        
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
    var loginSection = $('#login-section');
    
    $.post(action, params, function(response) {
        if (typeof response == "object" && response.success == "true") {
            $('#main-modal-dialog').jqmHide();
            window.location.reload();
        }
        
        loginSection.html($(response).children());
    });
    
    return false;
}

var initForgottenPasswordDialog = function() {
    var modalDialog = $('#main-modal-dialog');
    
    $('#forgotten-password').live('click', function(e) {
        $('#login-close').trigger('click');
        
        modalDialog.jqm({
            ajax: '/auth/forgotten-password'
        });        
        modalDialog.jqmShow();
        
        e.preventDefault();
    });
    
    $('#forgotten-cancel, #forgotten-close').live('click', function(e){
        modalDialog.jqmHide();
        e.preventDefault();
    });     
}

var doForgottenPassword = function(form) {
    var action = $(form).attr('action');
    var params = $(form).serialize();
    var forgottenSection = $('#forgotten-section');
    
    $.post(action, params, function(response) {
        forgottenSection.html($(response).children());
    });
    
    return false;     
}

var initRegisterDialog = function() {
    var modalDialog = $('#main-modal-dialog');
    
    $('#register-section-button').click(function(e) {
        modalDialog.jqm({
            ajax: '/auth/register'
        });        
        modalDialog.jqmShow();
        
        e.preventDefault();
    });
    
    $('#register-cancel, #register-close').live('click', function(e){
        modalDialog.jqmHide();
        e.preventDefault();
    });    
}

var doRegister = function(form) {
    var action = $(form).attr('action');
    var params = $(form).serialize();
    var registerSection = $('#register-section');
    
    $.post(action, params, function(response) {
        registerSection.html($(response).children());
    });
    
    return false;    
}
var isGmapLoaded = false;

var initDealDetailSection = function()
{
    var shadowItem = $('#header-block-shadow-item');
    
    $('#deal-detail-button-open, #deal-detail-button-close').click(function(e){
        shadowItem.removeAttr('class');
        
        $('#header-block-content').slideToggle('slow', function(){
            if ($('#header-block-content').is(':hidden')) {
                shadowItem.addClass('header-block-shadow');
                shadowItem.removeClass('header-block-detail-shadow');
                $('#deal-detail-button-open').show();
                $('#deal-detail-button-close').hide();                
            	
            } else {
                shadowItem.addClass('header-block-detail-shadow');
                shadowItem.removeClass('header-block-shadow');
                $('#deal-detail-button-open').hide();
                $('#deal-detail-button-close').show();
            
            	if (!isGmapLoaded) {
            		var script = document.createElement("script");
            		script.type = "text/javascript";
            		script.src = "http://maps.googleapis.com/maps/api/js?key=AIzaSyC3fX24_P3oNxQv1GjXgRr5JYBA2nOoUJ8&sensor=false&callback=initGMap";
            		document.body.appendChild(script);
            		isGmapLoaded = true;
            	}
            }
        });
        
        e.preventDefault();
    });    
}

var initTooltip = function()
{
    $('.info-tooltip-small').mouseenter(function(){
        $(this).hide();
        $('.info-tooltip-large').show();
    });
    
    $('.info-tooltip-large').mouseleave(function(){
        $(this).hide();
        $('.info-tooltip-small').show();        
    });
}

var countryCityMunicipalityAj = function() {   
    var countryObj = $('.country-aj');    
    var cityObj = $('.city-aj');
    var municipalityObj = $('.municipality-aj');
    
    countryObj.change(function() {
        var countryId = $(this).val();
        var params = {
            'id' : countryId
        };        
        $.post('/countries/get-cities/', params, function(data) {   
            cityObj.html('');
            $.each(data, function(key, value) {
                cityObj.append($('<option />').attr('value', key).text(value));
            });
        }, 'json');
    });
            
    cityObj.change(function() {
        var cityId = $(this).val();
        var params = {
            'id' : cityId
        }
        $.post('/cities/get-municipalities/', params, function(data) {
            municipalityObj.html('');
            $.each(data, function(key, value) {
                municipalityObj.append($('<option />').attr('value', key).text(value));
            });
        }, 'json');
    });
}

var initVauchers = function()
{
    $('.vaucher-info-item').hover(function() {
        $(this).addClass('hover');
        
        var arrowItem = $(this).find('.vaucher-info-item-arrow a');
        if (arrowItem.hasClass('arrow-down')) {    
            arrowItem.addClass('arrow-down-hover');
        } else {
            arrowItem.addClass('arrow-right-hover');
        }
    }, function() {
        $(this).removeClass('hover');
        
        var arrowItem = $(this).find('.vaucher-info-item-arrow a');
        arrowItem.removeClass('arrow-down-hover');
        arrowItem.removeClass('arrow-right-hover');
    });
    
    $('.vaucher-info-item-arrow a').click(function(e) {
        if ($(this).hasClass('arrow-down')) {
            $(this).addClass('arrow-right').removeClass('arrow-down');
            $('.vaucher-info-container').slideUp('slow');
        } else {
            $(this).addClass('arrow-down').removeClass('arrow-right').removeClass('arrow-hover');
            $('.vaucher-info-container').slideDown('slow');
        }
        
        e.preventDefault();
    })
}