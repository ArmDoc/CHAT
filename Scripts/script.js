var url = 'http://chat/PHP/server.php';
var userId = null
var message_id = null;
var lastId = 0;

document.querySelector('.footer_button').addEventListener("click",function() {
	var xhr = new XMLHttpRequest;
	var formData = new FormData;

	formData.append('userName',document.getElementById("userName").value);
	formData.append('message',document.getElementById("message").value);
	formData.append('action', "send")
	
	xhr.onload = function(){
		if (xhr.readyState === xhr.DONE) {
			if (xhr.status === 200) {
				data = JSON.parse(xhr.responseText);
				userId = data.user_id
				lastId = data.message_id;
				draw(data);
			}
	  }
	}
	xhr.open('POST', url);
	xhr.send(formData);
});

window.onload = function () {
	setInterval(function(){
		var users = []
		var xhr = new XMLHttpRequest;
		var formData = new FormData;
		formData.append('action', "get")
		formData.append('lastId', lastId)
		
		xhr.onload = function(){	
			data = JSON.parse(xhr.responseText)
			if(data.messages.length) {
				lastId = data.messages[data.messages.length-1].id;
			}
			
			data.messages.forEach(element => {
				draw(element);
			});

			if(data.activeUsers.length > 0) {
				data.activeUsers.forEach(user => {
					users.push(user);
				});
				drawUser(users);
			}
		}
		xhr.open('POST', url);
		xhr.send(formData);
	},5 * 1000)
};

function draw(data) {
	var userName = data.userName;
	var msg = data.message;
	var time = data.created_at.split('.')[0];

	var li = document.createElement("li");

	if (data.user_id == userId) {
		li.classList.add("myMessage");
	} else {
		li.classList.add("otherMessages");
	}

	var span = document.createElement("span");
	var pN = document.createElement("p");
	pN.classList.add("msgName");
	pN.innerHTML = userName + " " + time;
	var pM = document.createElement("p");
	pM.classList.add("msgText");
	pM.innerHTML = msg;
	document.querySelector(".messages").appendChild(li);
	li.appendChild(span);
	span.appendChild(pN);
	span.appendChild(pM);
}

function drawUser(users) {
	document.querySelector(".users").innerHTML = ""
	users.forEach(user =>{
		var span = document.createElement("span");

		span.classList.add("users_item--active");
		span.innerHTML = user.name
		
		document.querySelector(".users").appendChild(span)
	});
}