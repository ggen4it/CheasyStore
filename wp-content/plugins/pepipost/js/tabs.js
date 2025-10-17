jQuery(document).ready(function($) {
	
	$( "#from_date" ).datepicker({
      defaultDate: "+1w",
	  changeMonth: true,
      changeYear: true,
      numberOfMonths: 1,
      minDate: -90, 
      maxDate: "-3M +92D",
      onSelect: function (selectedDate) {
            var dt = new Date(selectedDate);
            dt.setDate(dt.getDate() + 1);
            $("#to_date").datepicker("option", "minDate", dt);
        },
      onClose: function( selectedDate ) {
       // alert("df");
        
        $( "#to_date" ).datepicker( "option", "minDate", selectedDate );
        $( "#to_date" ).focus();
      },
       
    });
    $( "#to_date" ).datepicker({
      defaultDate: "+1w",
	  changeMonth: true,
      changeYear: true,
      numberOfMonths: 1,
      minDate: -90, 
      maxDate: "+3M -90D",
      
	  onSelect: function( selectedDate ) {
        var dt = new Date(selectedDate);
            dt.setDate(dt.getDate() - 1);
		$('#dateRangeForm').submit();
      },
      onClose: function( selectedDate ) {
        $( "#from_date" ).datepicker( "option", "maxDate", selectedDate );
        $('#dateRangeForm').submit();
		//location.reload(true);
      }
    });
    
    $('#wpms_action').click(function() {
        $('#error_login').hide();
        var email = $.trim($('#to').val());
        var sub = $.trim($('#subject').val());
        var msg = $.trim($('#email_message').val());
        var err = '';
        if ( email == '' ) {
            err += '<p>Please enter email address.</p>';
        }else
        if( !IsEmail(email)) {
            err += '<p>Please enter valid email address.</p>';
        }
        if ( sub == '' & sub.value.trim() == "" ) {
            alert("Subject Field cannot be empty");
            err += '<p>Please enter email subject.</p>';
        }
        if ( msg == '' ) {
            alert("Message Field cannot be empty");
            err += '<p>Please enter email message.</p>';
        }
        if ( err != '' ) {
            $('#show_error').html(err);
            $('#show_error').addClass('error');
            $('#show_error').show();
            return false;
        }
    });
    $('#submit-pepipost').click(function() {
        
        $('#error_login').hide();
        var email = $.trim($('#mail_from').val());
        var api_key = $.trim($('#api_key').val());
        var from_name = $.trim($('#mail_from_name').val());
        var reply_to = $.trim($('#mail_reply').val());
        var err = '';
        if ( api_key == '' || api_key.length != 32){
                err += '<p>Please enter correct API key.</p>';
                $('#message').hide();
        }
        if( !IsEmail(email)) {
            err += '<p>Please enter valid email address in From Email field.</p>';
            $('#message').hide();
        }
        if ( err != '' ) {
            $('#smtp_error').html(err);
            $('#smtp_error').addClass('error');
            $('#smtp_error').show();
            return false;
        }

        //if( from_name == "" ){
            //alert("asd");
          //  document.getElementById("mail_from_name").value = ' ';
           
       // }
        //if( reply_to == "" ){
            //alert("asd");
           // document.getElementById("mail_reply").value = ' ';
           // return true;
        //}
    });
    
});

function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

function AllowSingleSpaceNotInFirstAndLast() {
        var obj = document.getElementById('subject');
        obj.value = obj.value.replace(/^\s+|\s+$/g, "");
        var CharArray = obj.value.split(" ");
        if (CharArray.length > 2) {
            alert("User name NOT VALID");
            return false;
        }
        else {
            alert("User name VALID");
        }
        return true;
    }
