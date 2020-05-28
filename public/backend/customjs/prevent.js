$(document).ready(function() {
	$("#send").click(function(e) {
		if($("#check").prop("checked") == true){
                $('#parent').val(null);
                
            }
		/*var msg = $("#msg").val();
		if (!(name == '' || email == '' || msg == '')) {
			$("#submitdata").empty();
			$("#submitdata").append("Name: " + name + "<br/>Email: " + email + "<br/>Message: " + msg);
		} else {
			alert("Please Fill All Fields.");
		}*/
	});
});