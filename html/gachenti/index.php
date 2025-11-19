<?php

session_start();

require("template.php");

openHTML("", "portada");

writeHeader();

$data = <<<EOD
	<article>
		<h2>La carta más cara</h2>
	</article>
EOD;

writeMain($data);

closeHTML();

?>
