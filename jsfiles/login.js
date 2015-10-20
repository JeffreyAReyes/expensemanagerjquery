$(document).ready(function(){
	$("#login").click(function(){
	var login_name = $("#loginname").val();
	var password = $("#password").val();
	// Checking for blank fields.
	if( login_name =='' || password ==''){
		$('input[type="text"],input[type="password"]').css("border","2px solid red");
		$('input[type="text"],input[type="password"]').css("box-shadow","0 0 3px red");
		alert("Please enter your login name and password.");
		}else {
			$.post("phpfiles/login.php",{ login_name1: login_name, password1:password},
				function(data) {
				if(data=='Invalid login_name.......') {
					$('input[type="text"]').css({"border":"2px solid red","box-shadow":"0 0 3px red"});
					$('input[type="password"]').css({"border":"2px solid #00F5FF","box-shadow":"0 0 5px #00F5FF"});
					alert(data);
					}else if(data=='login_name or Password is wrong...'){
						$('input[type="text"],input[type="password"]').css({"border":"2px solid red","box-shadow":"0 0 3px red"});
						alert(data);
						} else if(data=='Successfully Logged in...'){
							$("form")[0].reset();
							$('input[type="text"],input[type="password"]').css({"border":"2px solid #00F5FF","box-shadow":"0 0 5px #00F5FF"});
							document.location = "main.php";
							alert(data);
							} else{
								alert(data);
							}
						});
			}
		});
});