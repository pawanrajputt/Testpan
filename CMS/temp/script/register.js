$('document').ready(function() {   
  /* handle form validation */  
  $("#register-form").validate({
      rules:
   { 
   usertype: {
      required: true,
   //minlength: 3
   }, 
   mobile_no: {
      required: true,
   minlength: 10   
   },
   first_name: {
      required: true,
   minlength: 3
   },
    last_name: {
      required: true,
   minlength: 3
   },
   password: {
   required: true,
   minlength: 8,
   maxlength: 15
   },
   cpassword: {
   required: true,
   equalTo: '#password'
   },
   user_email: {
            required: true,
            email: true
            },
    },
       messages:
    {
			usertype: "Please Select User Role",
			mobile_no: "Please Enter Mobile Number",
            first_name: "Please Enter First Name",
			last_name: "Please Enter Last Name",
            password:{
                      required: "Please Provide a password",
                    //  minlength: "Password at least have 8 characters"
                     },
            user_email: "please enter a valid email address",
   cpassword:{
      required: "Please retype your password",
      equalTo: "Password doesn't match !"
       }
       },
    submitHandler: submitForm 
       });  
    /* handle form submit */
    function submitForm() {  
    var data = $("#register-form").serialize();    
    $.ajax({    
    type : 'POST',
    url  : 'register.php',
    data : data,
    beforeSend: function() { 
     $("#error").fadeOut();
     $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
    },
    success :  function(response) {      
        if(response==1){         
			 $("#error").fadeIn(1000, function(){
			   $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Sorry Email / Mobile Number already taken !</div>');           
			   $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account');          
			 });                    
        } else if(response=="registered"){         
			 $("#btn-submit").html('<img src="ajax-loader.gif" /> &nbsp; Signing Up ...');
			 setTimeout('$(".form-signin").fadeOut(500, function(){ $(".register_container").load("welcome.php"); }); ',3000);         
        } else {          
         	$("#error").fadeIn(1000, function(){           
      			$("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; Registered Successfully !</div>');           
         		$("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account');         
         	});           
       	}
        }
    });
    return false;
  }
});