<?php
// custome title and header
$title = "Example Contact Page";
if (isset($_POST["submit"])) {
	// First, check BotBox trap
	if ($_POST['botbox'] == '1') {
		$result='<div class="alert alert-danger">You chekced the box. I told you not to check the box. Try again</div>';
	} else {

		// Inline form definitions
		$name = $_POST['name'];
		$email = $_POST['email'];
		$message = $_POST['message'];
		$human = intval($_POST['human']);

// BENGIN OPTIONS: Set these values to suit
		$from = 'From: John Smith <no-reply@example.com>';
		$to = 'example@example.com'; 
		$subject = 'Message from Example Contact Form ';
// END OPTIONS	
		$body ="From: $name\n E-Mail: $email\n Message:\n $message";

		// Check if name has been entered
		if (!$_POST['name']) {
			$errName = 'Please enter your name';
		} else { $errName = '';
				}
	
		// Check if email has been entered and is valid
		if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$errEmail = 'Please enter a valid email address';
		} else { $errEmail = '';
				}
	
		//Check if message has been entered
		if (!$_POST['message']) {
			$errMessage = 'Please enter your message';
		} else { $errMessage = '';
				}

		//Check if captcha is correct
		$captchaResult = $_POST["human"];
		$firstNumber = $_POST["firstNumber"];
		$secondNumber = $_POST["secondNumber"];
		$checkTotal = $firstNumber + $secondNumber;
		if ($human !== $checkTotal)
			{
			$errHuman = 'Your captcha math is incorrect';
		} else { $errHuman = ''; 
				}
	}
	// If there are no errors, send the email
	if (($_POST['botbox'] == '0') && !$errName && !$errEmail && !$errMessage && !$errHuman) {
		if (mail ($to, $subject, $body, $from)) {
			$result='<div class="alert alert-success">Thank You! I will be in touch</div>';
		} else {
			$result='<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later.</div>';
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bootstrap PHP Contact Form.">
    <meta name="author" content="unfettered.net">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/spacelab/bootstrap.min.css">
  </head>
  <body>
  	<div class="container">
  		<div class="row">
  			<div class="col-md-6 col-md-offset-3">
  				<h1 class="page-header text-center"><?php echo $title ?></h1>
				<form class="form-horizontal" role="form" method="post" action="">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="name" name="name" placeholder="First & Last Name" value="<?php echo (isset($_POST['name']) ? htmlspecialchars($_POST['name']) : null); ?>">
							<?php echo (isset($errName) ? ("<p class='text-danger'> $errName</p>") : null);?>
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="<?php echo (isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null); ?>">
							<?php echo (isset($errEmail) ? ("<p class='text-danger'> $errEmail</p>") : null);?>
						</div>
					</div>
					<div class="form-group">
						<label for="message" class="col-sm-2 control-label">Message</label>
						<div class="col-sm-10">
							<textarea class="form-control" rows="4" name="message"><?php echo (isset($_POST['message']) ? htmlspecialchars($_POST['message']) : null);?></textarea>
							<?php echo (isset($errMessage) ? ("<p class='text-danger'> $errMessage</p>") : null);?>
						</div>
					</div>
					<div class="form-group">
						<label for="human" class="col-sm-2 control-label"><?php  
							$min_number = 0;
							$max_number = 15;
							$random_number1 = mt_rand($min_number, $max_number);
							$random_number2 = mt_rand($min_number, $max_number);
							echo $random_number1 . ' + ' . $random_number2 . ' = '; ?></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="human" name="human" placeholder="Your Answer">
							<input name="firstNumber" type="hidden" value="<?php echo $random_number1; ?>" />
							<input name="secondNumber" type="hidden" value="<?php echo $random_number2; ?>" />
							<?php echo (isset($errHuman) ? ("<p class='text-danger'> $errHuman</p>") : null);?>
							<div class="checkbox">
							  <label>
							    <input type="hidden" name="botbox" value="0" />
							    <input name="botbox" type="checkbox" value="1"> Leave this box unchecked.
							  </label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<?php echo (isset($result) ? $result : null); ?>	
						</div>
					</div>
				</form> 
			</div>
		</div>
	</div>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
  </body>
</html>
