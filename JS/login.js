$(document).ready(function(){
	
});
$("#logincredentials").on('submit', function(e){
	console.log($("#username").value);
	console.log($("#password").value);
	if($("#username").val() === '')
	{
		alert("You need to enter a username.");
	}else
	{
		if($("#password").val() === '')
		{
			alert("You need to enter a password.");
		}else
		{
			console.log("Now check db");
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "PHP/login.php",
				data: {'username':$("#username").val(), 'password':$("#password").val()},
				success: function(data){//error will be 0 login success; 1 just pw wrong; 2 both wrong
					console.log("In here->"+data["error"]);
					if(data["error"] === 0)
					{
						console.log("successful login!");
					}else
					{
						if(data["error"] === 1)
						{
							console.log("wrong pw");
							alert("You fucked up your password entry");
							e.preventDefault();
						}else
						{
							console.log("all wrong");
							alert("Bro get that checked out. You don't even know your username.");
							e.preventDefault();
						}
					}
				},
				error: function(){
					alert("something went really wrong. My b");
					e.preventDefault();
				}
			});
		}
	}
	console.log("Checking login credentials");
});
