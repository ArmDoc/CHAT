<?php
include_once "database.php";
date_default_timezone_set('Asia/Yerevan');

global $mysqli;

if($_POST['action']== 'send'){
	$userName 	= $_POST['userName'];
	$message		= $_POST['message'];

	if($userName && $message){
		$name = $mysqli->query("SELECT id FROM users WHERE `name` = '$userName' ")->fetch_row();
		if($name) {
			$id = (int)$name[0];
			$mysqli->query("UPDATE users SET last_active = NOW() WHERE id = '{$id}'");
		} else {
			$mysqli->query("INSERT INTO users (name, created_at,last_active) VALUES ('$userName', NOW(), NOW())");
			$id = $mysqli->insert_id;
		}
		
		$mysqli->query("INSERT INTO messages (user_id, message, created_at) VALUES ($id, '$message' ,NOW())");
		$messageId = $mysqli->insert_id;
		$time =date("Y-m-d H:i");
		echo json_encode([
			'user_id'		=> $id,
			'userName'		=> $userName,
			'message_id'	=> $messageId,
			'message'		=> $message,
			'created_at'	=> $time,
		]);
	}

}elseif($_POST['action'] == 'get') {
	$lastId = $_POST['lastId'] ?? 0;
	
	$getResult 		= $mysqli->query("SELECT messages.*, users.name as userName FROM `messages` JOIN users ON users.id = messages.user_id WHERE messages.id > {$lastId}")->fetch_all(MYSQLI_ASSOC);
	$activeUsers 	= $mysqli->query(" SELECT `name` FROM users WHERE last_active BETWEEN DATE_SUB(NOW() , INTERVAL 15 MINUTE) AND NOW() ORDER BY last_active DESC")->fetch_all(MYSQLI_ASSOC);
	
	echo json_encode([
		'messages' 		=> $getResult,
		'activeUsers' 	=> $activeUsers,
	]);
};

$mysqli->close();
?>