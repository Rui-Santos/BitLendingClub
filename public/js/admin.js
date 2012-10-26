$(function() {
    
    initDatepicker();
    
    initDatetimepicker();
    
    initTimepicker();
    
    initSlugify();
    
    confirmTask();
    
    countryCityMunicipalityAj();
});


var initDatepicker = function()
{
    $(".datepicker").datepicker({
        showOn: 'button',
        buttonImage: '/images/datepicker.gif'
    });    
}

var initDatetimepicker = function()
{
    $(".datetimepicker").datetimepicker({
        showOn: 'button',
        buttonImage: '/images/datepicker.gif'
    });    
}

var initTimepicker = function()
{
    $('.timepicker').timepicker({
        showOn: 'button',
        buttonImage: '/images/time_clock.png'    
    })
}

var initSlugify = function () {
    $(".slug-master").slug({ 
        slug:'.slug-slave',
        hide: false
    });
}

var confirmTask = function() {
    $('.confirm').click(function(e) {
        if (confirm("Are you sure you want to perform this task ?")) {
            return true;
        }
        
        e.preventDefault();
    })
}

var countryCityMunicipalityAj = function() {   
    var countryObj = $('.country-aj');    
    var cityObj = $('.city-aj');
    var municipalityObj = $('.municipality-aj');
    
    countryObj.change(function() {
        var countryId = $(this).val();
        var params = {'id' : countryId};        
        $.post('/countries/get-cities/', params, function(data) {   
            cityObj.html('');
            $.each(data, function(key, value) {
                cityObj.append($('<option />').attr('value', key).text(value));
            });
        }, 'json');
    });
            
    cityObj.change(function() {
        var cityId = $(this).val();
        var params = {'id' : cityId}
        $.post('/cities/get-municipalities/', params, function(data) {
            municipalityObj.html('');
            $.each(data, function(key, value) {
                municipalityObj.append($('<option />').attr('value', key).text(value));
            });
        }, 'json');
    });
}