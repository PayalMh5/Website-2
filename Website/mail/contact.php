<?php
// Ensure that form data is present and valid
if (empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(500);
    echo "Invalid form data. Please check your input.";
    exit();
}

// Sanitize and store form data
$name = strip_tags(htmlspecialchars($_POST['name']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$m_subject = strip_tags(htmlspecialchars($_POST['subject']));
$message = strip_tags(htmlspecialchars($_POST['message']));

$to = "payalmewada2004@gmail.com"; // Change this email to your recipient's email address
$subject = "$m_subject:  $name";
$body = "You have received a new message from your website contact form.\n\n" . "Here are the details:\n\nName: $name\n\nEmail: $email\n\nSubject: $m_subject\n\nMessage: $message";
$header = "From: $email"; // Added "\r\n" to separate headers

// Send email
if (!mail($to, $subject, $body, $header)) {
    http_response_code(500);
    echo "Email sending failed.";
    exit();
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact";

// Establish a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    http_response_code(500);
    echo "Database connection failed: " . $conn->connect_error;
    exit();
}

// Prepare SQL statement to insert data into the table
$sql = "INSERT INTO contact_form (name, email, subject, message) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Bind parameters and execute the statement
$stmt->bind_param("ssss", $name, $email, $m_subject, $message);

if ($stmt->execute()) {
    // Submission was successful
    echo "Form submitted successfully.";
} else {
    // Submission to the database failed
    http_response_code(500);
    echo "Database insertion failed: " . $stmt->error;
}

// Close the database connection
$stmt->close();
$conn->close();
?>
