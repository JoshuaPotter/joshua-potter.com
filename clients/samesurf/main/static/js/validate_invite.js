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

var validate_passwords = function() {
		var password1 = $("#password input").val();
		var password2 = $("#verify_password input").val();

		var lengthok = false;
		var matchok = false;

		if (password1.length < 6) {
			$("#password_length_error").css("display", "table-row");
		}
		else {
			$("#password_length_error").css("display", "none");
			lengthok = true;
		}

		if (password1 != password2) {
			$("#password_match_error").css("display", "table-row");
		} 
		else {
			$("#password_match_error").css("display", "none");
			matchok = true;
		}

		if (!lengthok || !matchok) {
			set_input_error_state("#password", true);									
			set_input_error_state("#verify_password", true);	
		}
		else {
			set_input_error_state("#password", false);									
			set_input_error_state("#verify_password", false);
		}

		return lengthok && matchok;
}

var validate_first_name = function() {
	var vp = $("#first_name input").val();
	if(vp.length == 0) {
		set_input_error_state("#first_name", true);
		$("#first_name_error").css("display", "table-row");
		return false
	}
	else {
		set_input_error_state("#first_name", false);
		$("#first_name_error").css("display", "none");;
		return true;
	}
}

var validate_last_name = function() {
	var vp = $("#last_name input").val();
	if(vp.length == 0) {
		set_input_error_state("#last_name", true);
		$("#last_name_error").css("display", "table-row");
		return false;
	}
	else {
		set_input_error_state("#last_name", false);
		$("#last_name_error").css("display", "none");
		return true;
	}
}

$(document).ready(function() {

	$("#verify_password input").on("blur", function() {
		validate_passwords();
	});	

	$("#password input").on("focus", function() {
		var vp = $("#verify_password input").val();
		if(vp.length == 0) {
			reset_input("#password");
		 	reset_input("#verify_password");
		}
	});

	$("#password input").on("blur", function() {
		var vp = $("#verify_password input").val();
		if(vp.length > 0) {
			validate_passwords();
		}
	});	

	$("#first_name input").on("focus", function() {
		var vp = $("#first_name input").val();
		if(vp.length == 0) {
			reset_input("#first_name");
		}
	});

	$("#first_name input").on("blur", function() {
		validate_first_name();
	});	

	$("#last_name input").on("focus", function() {
		var vp = $("#last_name input").val();
		if(vp.length == 0) {
			reset_input("#last_name");
		}
	});

	$("#last_name input").on("blur", function() {
		validate_last_name();
	});	

	$("#continue").on("click", function() {

		var fn = validate_first_name();
		var ln = validate_last_name();
		var vp = validate_passwords();
	
		if (fn && ln && vp) {
			$("#signup_step1_form form").submit();	
		} 

	});


});
