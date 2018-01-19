$(document).ready(function(){
	jQuery.validator.addMethod("lettersonly", function(value, element) {
    	return this.optional(element) || /^[a-z\s]+$/i.test(value);
	}, "Only alphabetical characters.");

	jQuery.validator.addMethod("email",function(value,element){
		return this.optional(element) || /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
	},"Please enter valid email address.");
	$("#registerForm").validate({
		rules: {
			"firstname":{
            	required:true,
            	lettersonly:true
   			},
   			"lastname":{
   				required:true,
   				lettersonly:true
   			},
   			"email":{
   				required:true,
   				email:true
   			},
   			"address":{
   				required:true
   			},
   			"password":{
   				required:true
   			},
   			"confpassword":{
			 	equalTo:"#password"
   			},
   			"gender":{
   				required:true
   			}
		}, 
		messages:{
        	"firstname":{
    	    	required: "Please enter your first name."
        	},
        	"lastname":{
        		required:"Please enter your last name."
        	},
        	"email":{
        		required:"Please enter your email.",
        		// email:"Please enter valid email address."
        	},
        	"address":{
        		required:"Please enter your address."
        	},
        	"password":{
        		required:"Please enter your password."
        	},
        	"confpassword":{
			 	equalTo:"The password does not match."
   			},
        	"gender":{
        		required:"This field is required."
        	}
    	}
	});
	$("#loginForm").validate({
		rules:{
			"email":{
				required:true,
				email:true
			},
			"password":{
				required:true
			}
		},
		messages:{
			"email":{
				required:"Please enter your email.",
				email:"Please enter your valid email address."
			},
			"password":{
				required:"Please enter your password."
			}
		}
	});
  $("#imageUploadButton").click(function(){
    $("#imageUploadFile").click();
  });
  $("#imageUploadFile").change(function(){
    if($("#imageUploadFile").valid()) {
      if(this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $("#imageUploadImg").attr("src", e.target.result).width(100);
        };
        reader.readAsDataURL(this.files[0]);
      }
    }else {
      $("#imageUploadImg").attr("src", "img/no-image.gif").width(100);
    }
  });
});
/*for image change whwn we upload image*/
function readURL(input) {
  if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#profile-img').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#UserProfileImage").change(function(){
    readURL(this);
});