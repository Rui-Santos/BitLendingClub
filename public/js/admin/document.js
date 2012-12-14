 var denyDocument = function(url) {
        
         
        var comment = $( "#comment" );
       
        $( "#dialog-form" ).dialog({
            autoOpen: false,
            height: 300,
            width: 350,
            modal: true,
            buttons: {
                "Comment": function() {
                    
                    var that = this;
                    $.ajax({
                        'type' : "POST",
                        "url" : url,
                        "data": {"comment" : comment},
                        dataType: "JSON",
                        success : function(data) {
                            alert('success');
                            $(that).dialog("close");
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
         $( "#dialog-form" ).dialog( "open" );
    }


