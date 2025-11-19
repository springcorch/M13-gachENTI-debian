<?php

require("template.php");

openHTML("", "portada");

writeHeader();

$data = <<<EOD
	<section>
		<h2>Formulario de Login</h2>
		<form method="POST" action="login_check.php">
			<p><label for="login_username">Usuario</label> <input type="text" name="username" id=login_username /></p>
			<p><label for="login_password">Contraseña</label><input type="password" name="password" id=login_password /></p>
	
			<p><input type="submit" value="Login" /></p>
		</form>
	</section>

	<section>
		<h2>Formulario de Registro</h2>
		<form method="POST" action="register_check.php">
			<p><label for="registro_username">Usuario</label> <input type="text" name="username" id="registro_username" /></p>
			<p><label for="registro_email">Email</label> <input type="email" name="email" id="registro_email" /></p>
			<p><label for="registro_name">Nombre</label> <input type="text" name="name" id="registro_name" /></p>
			<p><label for="registro_surname">Apellidos</label> <input type="text" name="surname" id="registro_surname" /></p>
			<p><label for="registro_password">Contraseña</label> <input type="password" name="password" id="registro_password" /></p>
			<p><label for="registro_password2">Repite la Contraseña</label> <input type="password" name="password2" id="registro_password2" /></p>
			<p><label for="registro_birthdate">Fecha de Nacimiento</label> <input type="date" name="birthdate" id="registro_birthdate" /></p>
			<p><label for="registro_funds">Fondos Iniciales</label> <input type="number" step="0.01" name="funds" id="registro_funds" /></p>
	
			<p><input type="submit" value="Registrarse" /></p>
		</form>
	</section>
EOD;

writeMain($data);

closeHTML();

?>
