$(function() {
   $('#chatt').on('submit',function(){
       $('.chatBox').append('<br>You: '+$('#message').val());
       $.ajax({
           type: "POST",
           url: "index.php",
           data: "message="+$('#message').val(),
           success: function(data){
               $('.chatBox').append('<br>Henry: '+data);
           }

       });
       $('#message').val('');
       return false
   })
});