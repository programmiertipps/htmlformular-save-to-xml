<?php

	$xmlFile = 'formReport.xml';

	if ( isset( $_POST['sendform']) && !empty($_POST['email']) && !empty($_POST['optin']) ) {		
		
		$email = $_POST['email'];
		
		if ( preg_match("/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email) ) {
			
			if (!file_exists($xmlFile)) {
				$xml = new DOMDocument('1.0', 'ISO-8859-1');
				$xml->formatOutput = true; 
				$xml->preserveWhiteSpace = false;
				$base = $xml->createElement('formReport');
			} else {
				$xml = new DOMDocument('1.0', 'ISO-8859-1');
				$xml->formatOutput = true; 
				$xml->preserveWhiteSpace = false;
				$xml->load($xmlFile);
				$base = $xml->documentElement;
			}
			
			$xml->appendChild($base);

			$base->appendChild($xmlItem = $xml->createElement('submit'));
			
			$xmlItem->appendChild($xml->createElement('timestamp', date("Y-m-d H:i:s")));
			$xmlItem->appendChild($xml->createElement('gender', $_POST['gender']));
			$xmlItem->appendChild($xml->createElement('name', $_POST['name']));
			$xmlItem->appendChild($xml->createElement('email', $_POST['email']));
			$xmlItem->appendChild($xml->createElement('message', $_POST['message']));
			
			$xml->save($xmlFile);

			echo '
				<div class="container">
					<div class="alert alert-success" role="alert">
						Anfrage erfolgreich!
					</div>
				</div>
			';
		} else {
			echo '
				<div class="container">
					<div class="alert alert-danger" role="alert">
						Bitte eine korrekte E-Mail-Adresse eingeben.
					</div>
				</div>
			';
        }
	}

?>

<!DOCTYPE html>
<html lang="de">
<head>

    <meta charset="UTF-8">
    <title>Protipps - XML Datei aus Formular</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<link href="assets/css/libs/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet">
	
</head>
<body>
	<div class="container">
	
		<h2 class="display-4 pb-5">HTML-Formular in XML-Datei speichern</h2>

		<form action="" method="post">
		
			<div class="row">
			  <div class="form-group col-md-4">
				<label for="SelectGender">Anrede</label>
				<select name="gender" class="form-control" id="SelectGender">
				  <option value="Herr">Herr</option>
				  <option value="Frau">Frau</option>
				</select>
			  </div>
			</div>
			
			<div class="form-group">
			  <label for="InputName">Name</label>
			  <input name="name" type="name" class="form-control" id="InputName">
			</div>
			
			<div class="form-group">
			  <label for="InputEmail">E-Mail-Adresse <span class="req">PFLICHTFELD</span></label>
			  <input name="email" type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" required>
			</div>		

			<div class="form-group">
			  <label for="TextareaMessage">Nachricht</label>
			  <textarea name="message" class="form-control" id="TextareaMessage" rows="3"></textarea>
			</div>
			
			<div class="form-group">
				<input type="hidden" name="optin" value="0">
				<input type="checkbox" id="opt-in" name="optin" value="1" class="form-check" required>
				<label class="form-check-label" for="opt-in">
					<span class="req">PFLICHTFELD</span><br>Ich habe die Hinweise in der Datenschutzerkl&auml;rung verstanden und stimme diesen hiermit zu.
				</label>
			</div>
			
			<button type="submit" name="sendform" class="btn btn-dark">Absenden</button>
			
		</form>
		
	</div>

</body>
</html>