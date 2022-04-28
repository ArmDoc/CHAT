<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PHP Chat</title>
	<link href="/Styles/styles.css" rel="stylesheet">
</head>
<body>

<div class="page_wrapper">
	<h1 class="users_title">All active users in chat</h1>
	<div class="users">
	</div>
	<div class="page_header">
	<ul class="messages">
	</ul>
	</div>
	
	<span class="page_footer">
		<input name="userName"	type="text" id="userName"  placeholder="User" class="footer_name">
		<input name="message"	type="text" id="message"   placeholder="Type a message..." class="footer_message">
		<input name="button"		type="submit" class="footer_button" value="Send">
	</span>
<script src="/Scripts/script.js"></script>
</body>
</html>