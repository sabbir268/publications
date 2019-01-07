
// |-----------------------------------------------------------|
// |     Check Meter If active Client have it
// |-----------------------------------------------------------|
//
$('select#meter_no').on('change', function() {
 var meter =  this.value ;

 if (meter != '') {
    $.ajax({
        url: 'core/ajax/meter_exists.php',
        type: 'POST',
        data: {meter: meter},
        success:function(data){

            data = $.trim(data);
            if (data == '1') {
              $(window).scrollTop(0);
              $("#output").html('<p class="err_msg"> <b>Warning!</b> A Client using this meter.</p>').fadeIn('slow');;
          }else{
              $(window).scrollTop(0);
              $("#output").html('');
          }
      }
  })
}
})

// |-----------------------------------------------------------|
// |     Check Username Exists or not
// |-----------------------------------------------------------|

// |-----------------------------------------------------------|
// |    Add New Client
// |-----------------------------------------------------------|
$(document).ready(function() {
    $("#clientRegForm").submit(function(e) {
        /* Act on the event */
        e.preventDefault();
        $.ajax({
            url: 'core/ajax/reg_client.php',
            type: 'POST',
            data: $('form#clientRegForm').serialize(),
            success:function(data){

                data = $.trim(data);
                if (data == '1') {
                    $('html, body').animate({scrollTop:0}, 'slow');
                    $("#output").html('<p class="success_msg"> <b>Congratulations</b> Client Registration Succssful</p>');
                    $("#clientRegForm")[0].reset();
                }else{
                    $('html, body').animate({scrollTop:0}, 'slow');
                    $("#output").html('<p class="err_msg"> <b>Failed</b> Something wrong. Please try after sometime.</p>');
                }
            }
        })
    });
});


// |-----------------------------------------------------------|
// |    Update Client
// |-----------------------------------------------------------|
$(document).ready(function() {
    $("#clientUpdateForm").submit(function(e) {
        /* Act on the event */
        e.preventDefault();
        $.ajax({
            url: 'core/ajax/update_client.php',
            type: 'POST',
            data: $('form#clientUpdateForm').serialize(),
            success:function(data){

                data = $.trim(data);
                if (data == '1') {
                  $('html, body').animate({scrollTop:0}, 'slow');
                  $("#output").html('<p class="success_msg"> <b>Congratulations</b> Client Information Updated Succssful</p>');
              }else{
                  $('html, body').animate({scrollTop:0}, 'slow');
                  $("#output").html('<p class="err_msg"> <b>Failed</b> Something wrong. Please try after sometime.</p>');
              }
          }
      })
    });
});
