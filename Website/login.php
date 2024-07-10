<?php
// Start the session (add this at the beginning)
session_start();

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'user_accounts';

// Create a new MySQLi instance
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user input
function sanitizeData($data)
{
	return htmlspecialchars(trim($data));
}

if (isset($_POST['signup'])) {
	// Get and sanitize form data
	$username = sanitizeData($_POST['username']);
	$email = sanitizeData($_POST['email']);
	$password = sanitizeData($_POST['password']);
	$confirmPassword = sanitizeData($_POST['confirm_password']);

	// Validate input data
	$error = null;

	// Check if username already exists in the database
	$checkUsernameQuery = "SELECT * FROM users WHERE username='$username'";
	$result = $conn->query($checkUsernameQuery);

	if ($result->num_rows > 0) {
		$error = "Username already exists. Please choose a different username.";
	} elseif ($password !== $confirmPassword) {
		$error = "Passwords do not match.";
	} else {
		// Insert new user into the database using prepared statement
		$insertQuery = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
		if ($conn->query($insertQuery) === TRUE) {
			// Registration successful
			$_SESSION['user_id'] = $conn->insert_id;
			$_SESSION['username'] = $username;
			$_SESSION['email'] = $email;
		} else {
			$error = "Error: " . $insertQuery . "<br>" . $conn->error;
		}
	}
}

// Login Form Submission
if (isset($_POST['login'])) {
	$username = sanitizeData($_POST['username']);
	$password = sanitizeData($_POST['password']);

	// Validate input data
	if (empty($username) || empty($password)) {
		$error = "Please enter both username and password";
	} else {
		// Perform database query to validate user credentials
		$query = "SELECT * FROM users WHERE username='$username'";
		$result = $conn->query($query);

		if ($result->num_rows == 1) {
			// User found
			$row = $result->fetch_assoc();
			$storedPassword = $row['password'];

			// Verify the submitted password against the stored hashed password
			if ($password === $storedPassword) {
				// Password is correct
				$_SESSION['user_id'] = $row['user_id'];
				$_SESSION['username'] = $row['username'];
				$_SESSION['email'] = $row['email'];

				// Set a cookie to remember the user's login status
				setcookie('user_logged_in', true, time() + (86400 * 30), '/'); // Cookie lasts for 30 days

				// Redirect to the home page
				header("Location: index.html");
				exit();
			} else {
				// Invalid password
				$error = "Invalid password";
			}
		} else {
			// User not found
			$error = "User not found";
		}
	}
}
// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/x-icon" href="LOGO.png">
	<title>TRAVELER - Plan your Trips your way</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<script src="https://kit.fontawesome.com/7b39153ed3.js" crossorigin="anonymous"></script>
	<style>
		/* Add your CSS styles for the password rules here */
		.password-rules {
			position: absolute;
			top: 226px;
			left: 35px;
			width: 255px;
			background-color: #fff;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
			display: none;
			z-index: 2;
			font-size: 0.8rem;
			/* Adjust font size as needed */
			padding: 8px;
			/* Add padding for better spacing */
		}

		.password-rules p {
			margin: 4px 0;
		}

		.password-rules i {
			margin-right: 8px;
		}

		.password-rules i.fas {
			font-size: 12px;
		}
	</style>
</head>

<body>

	<div id="container" class="container">
		<!-- FORM SECTION -->
		<div class="row">
			<!-- SIGN UP -->
			<div class="col align-items-center flex-col sign-up">
				<div class="form-wrapper align-items-center">
					<form method="POST" action="" name="signupForm">
						<div class="form sign-up">
							<!-- Display error message if it exists -->
							<?php if (!empty($error)) : ?>
								<p class="error-message" style="color: red;"><?php echo $error; ?></p>
							<?php endif; ?>
							<div class="input-group">
								<i class='bx bxs-user'></i>
								<input type="text" placeholder="Username" name="username" required>
							</div>
							<div class="input-group">
								<i class='bx bx-mail-send'></i>
								<input type="email" placeholder="Email" name="email" required>
							</div>
							<div class="input-group">
								<i class='bx bxs-lock-alt'></i>
								<input type="password" placeholder="Password" id="password" name="password" required onfocus="showPasswordRules()" onblur="hidePasswordRules()" onkeyup="validatePassword(this.value)">
							</div>
							<div class="password-rules">
								<p>
									<i class="length-icon fas fa-check" style="color: green; display: none;"></i>
									<i class="length-icon-cross fas fa-times" style="color: red;"></i>
									At least 8 characters long
								</p>
								<p>
									<i class="numeric-icon fas fa-check" style="color: green; display: none;"></i>
									<i class="numeric-icon-cross fas fa-times" style="color: red;"></i>
									Contains at least 1 numeric digit
								</p>
								<p>
									<i class="uppercase-icon fas fa-check" style="color: green; display: none;"></i>
									<i class="uppercase-icon-cross fas fa-times" style="color: red;"></i>
									Contains at least 1 uppercase letter
								</p>
								<p>
									<i class="lowercase-icon fas fa-check" style="color: green; display: none;"></i>
									<i class="lowercase-icon-cross fas fa-times" style="color: red;"></i>
									Contains at least 1 lowercase letter
								</p>
								<p>
									<i class="special-char-icon fas fa-check" style="color: green; display: none;"></i>
									<i class="special-char-icon-cross fas fa-times" style="color: red;"></i>
									Contains at least 1 symbolic character
								</p>
							</div>
							<div class="input-group">
								<i class='bx bxs-lock-alt'></i>
								<input type="password" placeholder="Confirm password" name="confirm_password" id="confirm_password" required onkeyup="checkPasswordMatch()">
							</div>
							<p class="password-mismatch-error" style="color: red; display: none;">Passwords do not match</p>
							<button type="submit" name="signup">Sign up</button>
							<p>
								<span>
									Already have an account?
								</span>
								<b onclick="toggle()" class="pointer">
									Sign in here
								</b>
							</p>
						</div>
					</form>
				</div>
			</div>
			<!-- END SIGN UP -->

			<!-- SIGN IN -->
			<div class="col align-items-center flex-col sign-in">
				<div class="form-wrapper align-items-center">
					<form method="POST" action="">
						<div class="form sign-in">
							<?php if (isset($error)) : ?>
								<p style="color: red;"><?php echo $error; ?></p>
							<?php endif; ?>
							<div class="input-group">
								<i class='bx bxs-user'></i>
								<input type="text" placeholder="Username" name="username">
							</div>
							<div class="input-group">
								<i class='bx bxs-lock-alt'></i>
								<input type="password" placeholder="Password" name="password">
							</div>
							<button type="submit" name="login">Sign in</button>
							<p>
								<b>
									Forgot password?
								</b>
							</p>
							<p>
								<span>
									Don't have an account?
								</span>
								<b onclick="toggle()" class="pointer">
									Sign up here
								</b>
							</p>
						</div>
					</form>
				</div>
				<div class="form-wrapper">

				</div>
			</div>
			<!-- END SIGN IN -->
		</div>
		<!-- END FORM SECTION -->
		<!-- CONTENT SECTION -->
		<div class="row content-row">
			<!-- SIGN IN CONTENT -->
			<div class="col align-items-center flex-col">
				<div class="text sign-in">
					<h2>
						Welcome
					</h2>

				</div>
				<div class="img sign-in">

				</div>
			</div>
			<!-- END SIGN IN CONTENT -->
			<!-- SIGN UP CONTENT -->
			<div class="col align-items-center flex-col">
				<div class="img sign-up">

				</div>
				<div class="text sign-up">
					<h2>
						Join with us
					</h2>

				</div>
			</div>
			<!-- END SIGN UP CONTENT -->
		</div>
		<!-- END CONTENT SECTION -->
	</div>

	<script src="java.js"></script>
	<script>
		const passwordInput = document.getElementById('password');
		const rules = document.querySelector('.password-rules');

		function showPasswordRules() {
			rules.style.display = 'block';
		}

		function hidePasswordRules() {
			rules.style.display = 'none';
		}

		function hasSpecialCharacter(password) {
			return /[^a-zA-Z\d]/.test(password);
		}

		function validatePassword(password) {
			var lengthIcon = document.querySelector('.length-icon');
			var numericIcon = document.querySelector('.numeric-icon');
			var uppercaseIcon = document.querySelector('.uppercase-icon');
			var lowercaseIcon = document.querySelector('.lowercase-icon');
			var specialCharIcon = document.querySelector('.special-char-icon');

			var lengthIconCross = document.querySelector('.length-icon-cross');
			var numericIconCross = document.querySelector('.numeric-icon-cross');
			var uppercaseIconCross = document.querySelector('.uppercase-icon-cross');
			var lowercaseIconCross = document.querySelector('.lowercase-icon-cross');
			var specialCharIconCross = document.querySelector('.special-char-icon-cross');

			var isLengthValid = password.length >= 8;
			var hasNumeric = /\d/.test(password);
			var hasUppercase = /[A-Z]/.test(password);
			var hasLowercase = /[a-z]/.test(password);
			var hasSpecialChar = hasSpecialCharacter(password);

			lengthIcon.style.display = isLengthValid ? 'inline-block' : 'none';
			lengthIconCross.style.display = isLengthValid ? 'none' : 'inline-block';

			numericIcon.style.display = hasNumeric ? 'inline-block' : 'none';
			numericIconCross.style.display = hasNumeric ? 'none' : 'inline-block';

			uppercaseIcon.style.display = hasUppercase ? 'inline-block' : 'none';
			uppercaseIconCross.style.display = hasUppercase ? 'none' : 'inline-block';

			lowercaseIcon.style.display = hasLowercase ? 'inline-block' : 'none';
			lowercaseIconCross.style.display = hasLowercase ? 'none' : 'inline-block';

			specialCharIcon.style.display = hasSpecialChar ? 'inline-block' : 'none';
			specialCharIconCross.style.display = hasSpecialChar ? 'none' : 'inline-block';

		}

		passwordInput.addEventListener('focus', showPasswordRules);
		passwordInput.addEventListener('blur', hidePasswordRules);
		passwordInput.addEventListener('input', (e) => validatePassword(e.target.value));

		// Add an event listener to hide password rules when clicking outside the rules div
		document.addEventListener('click', (e) => {
			if (!rules.contains(e.target) && e.target !== passwordInput) {
				hidePasswordRules();
			}
		});
	</script>
	<script>
		function checkPasswordMatch() {
			const password = document.getElementById('password').value;
			const confirmPassword = document.getElementById('confirm_password').value;
			const passwordMismatchError = document.querySelector('.password-mismatch-error');
			const signupForm = document.querySelector('form[name="signupForm"]'); // Add a "name" attribute to your form

			if (password !== confirmPassword) {
				passwordMismatchError.style.display = 'block';
				// Prevent form submission
				signupForm.onsubmit = function(event) {
					event.preventDefault();
				};
			} else {
				passwordMismatchError.style.display = 'none';
				// Allow form submission
				signupForm.onsubmit = null;
			}
		}
	</script>
</body>

</html>