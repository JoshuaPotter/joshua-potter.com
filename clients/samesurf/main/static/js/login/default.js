var reset_input = function(name) {
	$(name + " .input_tick").hide();
	$(name + " .input_style").removeClass("input_style_success");
	$(name + " .input_cross").hide();
	$(name + " .input_style").removeClass("input_style_error");
}

var set_input_error_state =  function(name, state) {
	if (state) {
		$(name + " .input_cross").show();
		$(name + " .input_style").addClass("input_style_error");

		$(name + " .input_tick").hide();
		$(name + " .input_style").removeClass("input_style_success");
		
	}	
	else {
		$(name + " .input_cross").hide();
		$(name + " .input_style").removeClass("input_style_error");

		$(name + " .input_tick").show();
		$(name + " .input_style").addClass("input_style_success");
	}
}

var validate_password = function() {

		var password1 = $("#password input").val();
		var lengthok = false;

		if (password1.length < 1) {
			$("#password_error").css("display", "table-row");
		}
		else {
			$("#password_error").css("display", "none");
			lengthok = true;
		}

		if (!lengthok) {
			set_input_error_state("#password", true);									
			set_input_error_state("#verify_password", true);	
		}
		else {
			set_input_error_state("#password", false);									
			set_input_error_state("#verify_password", false);
		}

		return lengthok;
}

var validate_email = function() {

	$("#email_incorrect_error").css("display", "none");
	
	var ok = false;
	var email = $("#email input").val();
	if(email.match(/\S+@\S+/)) {
		ok = true;
	}

	if (ok) {
		set_input_error_state("#email", false);
		$("#email_error").css("display", "none");
		return true;
	}
	else {
		set_input_error_state("#email", true);
		$("#email_error").css("display", "table-row");
		return false;
	}
}


$(document).ready(function() {

// 	var height = $(document).height();
// 	
// 	var winheight = $("#login_container").height();
// 	
// 	var top = (height - winheight) / 2;
// 	
// 	$("#login_container").css({"top":top});
	
	$("#login").on("click", function() {

		var vp = validate_password();
		var ve = validate_email();
	
		if (vp && ve) {
			$("#login_form form").submit();	
		} 

	});


});
