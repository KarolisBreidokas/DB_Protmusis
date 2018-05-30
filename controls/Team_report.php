<?php
date_default_timezone_set("Europe/Vilnius");
include 'Libraries/Team.class.php';

		// išrenkame ataskaitos duomenis
		$Data = Team::GenerateReport();
		// rodome ataskaitą
		include 'templates/Team/Report_show.tpl.php';
?>
