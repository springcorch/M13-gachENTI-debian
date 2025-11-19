<?php

if(
	!isset($_POST["name"]) ||
    !isset($_POST["surname"]) ||
    !isset($_POST["username"]) ||
    !isset($_POST["email"]) ||
    !isset($_POST["password"]) ||
    !isset($_POST["password2"]) ||
    !isset($_POST["birthdate"]) ||
    !isset($_POST["funds"])
	)
{
	die("ERROR 1: Formulario no enviado.");
}

//LONGITUD MÍNIMA Y MÁXIMA
if(strlen($_POST["name"]) < 2 || strlen($_POST["name"]) > 24){
	die("ERROR 2: Tamaño incorrecto en name.");
}

if(strlen($_POST["surname"]) < 2 || strlen($_POST["surname"]) > 24){
	die("ERROR 3: Tamaño incorrecto en surname.");
}

if(strlen($_POST["username"]) < 3 || strlen($_POST["username"]) > 16){
	die("ERROR 4: Tamaño incorrecto en username.");
}

if(strlen($_POST["email"]) < 5 || strlen($_POST["email"]) > 32){
	die("ERROR 5: Tamaño incorrecto en email.");
}

if(strlen($_POST["password"]) < 4){
	die("ERROR 6: Tamaño incorrecto en password.");
}

// PASSWORD Y PASSWORD2 SON IGUALES?
if($_POST["password"] !== $_POST["password2"]){
	die("ERROR 7: Los passwords no coinciden.");
}

// ES MAYOR DE EDAD O SE HA PASADO DE AÑOS?
$birth_year = intval(substr($_POST["birthdate"], 0, 4));
$current_year = intval(date("Y"));

if($current_year - $birth_year < 18){
	die("ERROR 8: Debe ser mayor de edad.");
}
if($current_year - $birth_year > 100){
	die("ERROR 8: Debe ser una fecha de nacimiento coherente.");
}

// NO TIENE CARÁCTERES RAROS
$name = addslashes($_POST["name"]);
if($name != $_POST["name"]){
	die("ERROR 9: Nombre mal formado.");
}

$surname = addslashes($_POST["surname"]);
if($surname != $_POST["surname"]){
	die("ERROR 10: Apellido mal formado.");
}

$username = addslashes($_POST["username"]);
if($username != $_POST["username"]){
	die("ERROR 11: Username mal formado.");
}

$email = addslashes($_POST["email"]);
if($email != $_POST["email"]){
	die("ERROR 12: Email mal formado.");
}

$password = addslashes($_POST["password"]);
if($password != $_POST["password"]){
	die("ERROR 13: Contraseña mal formada.");
}

//PASSWORD MD5
$password = md5($password);

//COMPROBACIÓN DE QUE NO EXISTA YA ESTE USUARIO
$birthdate = $_POST["birthdate"];
$funds = floatval($_POST["funds"]);
$status = 1;
$id_user_type = 1;
$registered = date("Y-m-d H:i:s");

$conn = mysqli_connect("localhost", "enti", "enti", "gachenti_db");

if(!$conn){
	die("ERROR DB 1: Error en la conexión.");
}

$query = "
SELECT username 
FROM users
WHERE username = '{$username}';
";

$result = mysqli_query($conn, $query);

if(!$result){
	die("ERROR DB 2: Error al consultar la BD.");
}

if(mysqli_num_rows($result) > 0){
	die("ERROR 14: El username ya existe.");
}

//COMPROBACIÓN DE QUE NO EXISTA YA ESTE EMAIL
$query = "
SELECT username 
FROM users
WHERE username = '{$email}';
";

$result = mysqli_query($conn, $query);

if(!$result){
	die("ERROR DB 3: Error al consultar la BD.");
}

if(mysqli_num_rows($result) > 0){
	die("ERROR 15: El email ya existe.");
}

//INSERTAR DATOS EN MYSQL
$insert = "INSERT INTO users(name, surname, username, email, password, birthdate, funds, registered, status, id_user_type)
VALUES (
    '{$name}',
    '{$surname}',
    '{$username}',
    '{$email}',
    '{$password}',
    '{$birthdate}',
    {$funds},
    '{$registered}',
    {$status},
    {$id_user_type}
);";

$result = mysqli_query($conn, $insert);

if(!$result){
	die("ERROR DB 4: Error al insertar el usuario.");
}

$new_id = mysqli_insert_id($conn);

session_start();
$_SESSION["id_user"] = $new_id;
header("Location: dashboard.php");
exit();

?>
