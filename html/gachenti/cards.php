<?php

require("template.php");

openHTML("", "cards");

writeHeader();

$data = <<<EOD
	<section>
		<h2>Listado de cartas</h2>
	</section>
EOD;

writeMain($data);

closeHTML();

?>