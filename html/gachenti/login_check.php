<?php

if(!isset($_POST["username"]) || !isset($_POST["password"])){
	die("ERROR 1: Formulario no enviado.");
}

if(strlen($_POST["username"]) < 3 || strlen($_POST["username"]) > 16){
	die("ERROR 2: Nombre de usuario no tiene un tamaño correcto.");
}

if(strlen($_POST["password"]) < 4){
	die("ERROR 3: La contraseña es muy corta.");
}

$username = addslashes($_POST["username"]);

if($username != $_POST["username"]){
	die("ERROR 4: El usuario tiene el username mal formado.");
}


$password = addslashes($_POST["password"]);
if($password != $_POST["password"]){
	die("ERROR 5: El usuario tiene una contraseña mal formada.");
}

$password = md5($password);

$query = <<<EOD
SELECT id_user
FROM users
WHERE
	username='{$username}'
	AND password='{$password}';

EOD;

$conn = mysqli_connect("localhost", "enti", "enti", "gachenti_db");

if(!$conn){
	die("ERROR DB 1: Error en la conexión.");
}

$result = mysqli_query($conn, $query);

if(!$result){
	die("ERROR DB 2: Error al realizar la petición.");
}

if(mysqli_num_rows($result) != 1){
	die("ERROR 6: El username o el password son erróneos.");
}

$user = mysqli_fetch_assoc($result);

echo $user["id_user"];

?>
