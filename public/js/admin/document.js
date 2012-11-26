$(function() {
    
    var denyDocument = function(url) {
        
        $( "#dialog-form" ).dialog({
            autoOpen: false,
            height: 300,
            width: 350,
            modal: true,
            buttons: {
                "Create an account": function() {
                    $.ajax({
                        'type' : "POST",
                        "url" : url,
                        success : function(data) {
                            alert('success');
                            $(this).dialog("close");
                        }
                        
                    });
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });
    }
});