$(document).ready(function(){
    
    var url = '';
    
    $("#LOGINSUBMIT").click(function(){ $("#FLOGIN").submit(); });
    
	$( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 310,
		width: 350,
		modal: true,
		buttons: {
			"Entra >>": function() {    					                        
                    $.post(
                        h_cursos_loginAjax,
                        { 'login':$("#login").val() , 'pass':$('#password').val() },
                         function(data) {                                                     
                            if(data == 'OK'){ $('#dialog-form').dialog( "close" ); $(location).attr('href',url); }
                            else { alert('Incorrecte'); }                                                           
                         }   
                        );                        
				}				
		},
		close: function() {
			//allFields.val( "" ).removeClass( "ui-state-error" );
		}
	});

	$( ".auth" )
		.click(function() {
            url = $(this).attr('href');
			$( "#dialog-form" ).dialog( "open" );
            return false;
		});        

	$( "#feedback-form" ).dialog({
		autoOpen: false,
		height: 510,
		width: 350,
		modal: true,
		buttons: {
			"Envia comentari": function() {    					                        
                    $.post(
                        h_feedback_Ajax,
                        { 'nom':$("#feedback-nom").val() , 'mail':$('#feedback-mail').val(), 'comentari':$('#feedback-comentari').val()  },
                         function(data) {                                                     
                            if(data == 'OK'){ $('#feedback-form').dialog( "close" ); }
                            else { alert('Incorrecte'); }                                                           
                         }   
                        );                        
				}				
		},
		close: function() {
			//allFields.val( "" ).removeClass( "ui-state-error" );
		}
	});

	$( "#feedback" )
		.click(function() {
            url = $(this).attr('href');
			$( "#feedback-form" ).dialog( "open" );
		});        
    

    /* Activem els ToolTip a la classe tip */    
    $(function(){
        $(".tip").tipTip();
    });
    
});