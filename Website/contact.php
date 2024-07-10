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
$header = "From: $email\r\n"; // Added "\r\n" to separate headers

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TRAVELER - Plan your Trips your way</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="LOGO.png">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid bg-light pt-3 d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left mb-2 mb-lg-0">
                    <div class="d-inline-flex align-items-center">
                        <p><i class="fa fa-envelope mr-2"></i>traveler@gmail.com</p>
                        <p class="text-body px-3">|</p>
                        <p><i class="fa fa-phone-alt mr-2"></i>+91 345 7890</p>
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-right">
                    <div class="d-inline-flex align-items-center">
                        </a>
                        <a class="text-primary px-3" href="login.php">
                            <i class="fa fa-user"></i>
                        </a>
                        <a class="text-primary px-3" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-primary px-3" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-primary px-3" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-primary px-3" href="">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a class="text-primary px-3" href="">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a class="text-primary px-3" href="login.php">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid position-relative nav-bar p-0">
        <div class="container-lg position-relative p-0 px-lg-3" style="z-index: 9;">
            <nav class="navbar navbar-expand-lg bg-light navbar-light shadow-lg py-3 py-lg-0 pl-3 pl-lg-5">
                <a href="register.html" class="navbar-brand">
                    <h1 class="m-0 text-primary"><span class="text-dark">TRAVEL</span>ER</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                    <div class="navbar-nav ml-auto py-0">
                        <a href="index.html" class="nav-item nav-link">Home</a>
                        <a href="about.html" class="nav-item nav-link">About</a>
                        <a href="service.html" class="nav-item nav-link">Services</a>
                        <a href="package.html" class="nav-item nav-link">Tour Packages</a>
                        <div class="nav-item dropdown">
                            <a href="blog.html" class="nav-item nav-link" >Blog</a>
                        </div>
                        <a href="contact.html" class="nav-item nav-link active">Contact</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Header Start -->
    <div class="container-fluid page-header">
        <div class="container">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
                <h3 class="display-4 text-white text-uppercase">Contact</h3>
                <div class="d-inline-flex text-white">
                    <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                    <i class="fa fa-angle-double-right pt-1 px-3"></i>
                    <p class="m-0 text-uppercase">Contact</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Contact Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Contact</h6>
                <h1>Contact For Any Query</h1>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-form bg-white" style="padding: 30px;">
                        <div id="success"></div>
                        <form name="contact" id="contact-form" novalidate="novalidate" method="post">
                            <div class="form-row">
                                <div class="control-group col-sm-6">
                                    <input type="text" class="form-control p-4" id="name" name="name" placeholder="Your Name"
                                        required="required" data-validation-required-message="Please enter your name" />
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="control-group col-sm-6">
                                    <input type="email" class="form-control p-4" id="email" name="email" placeholder="Your Email"
                                        required="required" data-validation-required-message="Please enter your email" />
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="control-group">
                                <input type="text" class="form-control p-4" id="subject" name="subject" placeholder="Subject"
                                    required="required" data-validation-required-message="Please enter a subject" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <textarea class="form-control py-3 px-4" rows="5" id="message" name="message" placeholder="Message"
                                    required="required" data-validation-required-message="Please enter your message"></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary py-3 px-4" type="submit" id="sendMessageButton">Send Message</button>
                            </div>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 py-5 px-sm-3 px-lg-5" style="margin-top: 90px;">
        <div class="row pt-5">
            <div class="col-lg-3 col-md-6 mb-5">
                <a href="" class="navbar-brand">
                    <h1 class="text-primary"><span class="text-white">TRAVEL</span>ER</h1>
                </a>
                <p>We're your travel dream team, ready to turn your wanderlust into unforgettable adventures. Your journey begins here!</p>
                <h6 class="text-white text-uppercase mt-4 mb-3" style="letter-spacing: 5px;">Follow Us</h6>
                <div class="d-flex justify-content-start">
                    <a class="btn btn-outline-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="text-white text-uppercase mb-4" style="letter-spacing: 5px;">Our Services</h5>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-white-50 mb-2" href="about.html"><i class="fa fa-angle-right mr-2"></i>About</a>
                    <a class="text-white-50 mb-2" href="destination.html"><i class="fa fa-angle-right mr-2"></i>Destination</a>
                    <a class="text-white-50 mb-2" href="service.html"><i class="fa fa-angle-right mr-2"></i>Services</a>
                    <a class="text-white-50 mb-2" href="package.html"><i class="fa fa-angle-right mr-2"></i>Packages</a>
                    <a class="text-white-50" href="blog.html"><i class="fa fa-angle-right mr-2"></i>Blog</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="text-white text-uppercase mb-4" style="letter-spacing: 5px;">Usefull Links</h5>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-white-50 mb-2" href="about.html"><i class="fa fa-angle-right mr-2"></i>About</a>
                    <a class="text-white-50 mb-2" href="destination.html"><i class="fa fa-angle-right mr-2"></i>Destination</a>
                    <a class="text-white-50 mb-2" href="service.html"><i class="fa fa-angle-right mr-2"></i>Services</a>
                    <a class="text-white-50 mb-2" href="package.html"><i class="fa fa-angle-right mr-2"></i>Packages</a>
                    <a class="text-white-50" href="blog.html"><i class="fa fa-angle-right mr-2"></i>Blog</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="text-white text-uppercase mb-4" style="letter-spacing: 5px;">Contact Us</h5>
                <p><i class="fa fa-map-marker-alt mr-2"></i>Andheri, Mumbai, India</p>
                <p><i class="fa fa-phone-alt mr-2"></i>+91 345 67890 25</p>
                <p><i class="fa fa-envelope mr-2"></i>traveler@gmail.com</p>
                <h6 class="text-white text-uppercase mt-4 mb-3" style="letter-spacing: 5px;">Newsletter</h6>
                <div class="w-100">
                    <div class="input-group">
                        <input type="text" class="form-control border-light" style="padding: 25px;" placeholder="Your Email">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-3">Sign Up</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark text-white border-top py-4 px-sm-3 px-md-5" style="border-color: rgba(256, 256, 256, .1) !important;">
        <div class="row">
            <div class="col-lg-6 text-center text-md-left mb-3 mb-md-0">
                <p class="m-0 text-white-50">Copyright &copy; <a href="#">Traveler</a>. All Rights Reserved.</a>
                </p>
            </div>
            <div class="col-lg-6 text-center text-md-right">
                <p class="m-0 text-white-50">Designed by Payal Mewada
                </p>
            </div>
        </div>
    </div>
    <!-- Footer End -->



    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js">
        !function(a){var e=[],t={options:{prependExistingHelpBlock:!1,sniffHtml:!0,preventSubmit:!0,submitError:!1,submitSuccess:!1,semanticallyStrict:!1,autoAdd:{helpBlocks:!0},filter:function(){return!0}},methods:{init:function(o){var r=a.extend(!0,{},t);r.options=a.extend(!0,r.options,o);var l=a.unique(this.map(function(){return a(this).parents("form")[0]}).toArray());return a(l).bind("submit",function(e){var t=a(this),i=0,n=t.find("input,textarea,select").not("[type=submit],[type=image]").filter(r.options.filter);n.trigger("submit.validation").trigger("validationLostFocus.validation"),n.each(function(e,t){var n=a(t).parents(".control-group").first();n.hasClass("warning")&&(n.removeClass("warning").addClass("error"),i++)}),n.trigger("validationLostFocus.validation"),i?(r.options.preventSubmit&&e.preventDefault(),t.addClass("error"),a.isFunction(r.options.submitError)&&r.options.submitError(t,e,n.jqBootstrapValidation("collectErrors",!0))):(t.removeClass("error"),a.isFunction(r.options.submitSuccess)&&r.options.submitSuccess(t,e))}),this.each(function(){var t=a(this),o=t.parents(".control-group").first(),l=o.find(".help-block").first(),s=t.parents("form").first(),d=[];if(!l.length&&r.options.autoAdd&&r.options.autoAdd.helpBlocks&&(l=a('<div class="help-block" />'),o.find(".controls").append(l),e.push(l[0])),r.options.sniffHtml){var c="";if(void 0!==t.attr("pattern")&&(c="Not in the expected format\x3c!-- data-validation-pattern-message to override --\x3e",t.data("validationPatternMessage")&&(c=t.data("validationPatternMessage")),t.data("validationPatternMessage",c),t.data("validationPatternRegex",t.attr("pattern"))),void 0!==t.attr("max")||void 0!==t.attr("aria-valuemax")){var v=void 0!==t.attr("max")?t.attr("max"):t.attr("aria-valuemax");c="Too high: Maximum of '"+v+"'\x3c!-- data-validation-max-message to override --\x3e",t.data("validationMaxMessage")&&(c=t.data("validationMaxMessage")),t.data("validationMaxMessage",c),t.data("validationMaxMax",v)}if(void 0!==t.attr("min")||void 0!==t.attr("aria-valuemin")){var u=void 0!==t.attr("min")?t.attr("min"):t.attr("aria-valuemin");c="Too low: Minimum of '"+u+"'\x3c!-- data-validation-min-message to override --\x3e",t.data("validationMinMessage")&&(c=t.data("validationMinMessage")),t.data("validationMinMessage",c),t.data("validationMinMin",u)}void 0!==t.attr("maxlength")&&(c="Too long: Maximum of '"+t.attr("maxlength")+"' characters\x3c!-- data-validation-maxlength-message to override --\x3e",t.data("validationMaxlengthMessage")&&(c=t.data("validationMaxlengthMessage")),t.data("validationMaxlengthMessage",c),t.data("validationMaxlengthMaxlength",t.attr("maxlength"))),void 0!==t.attr("minlength")&&(c="Too short: Minimum of '"+t.attr("minlength")+"' characters\x3c!-- data-validation-minlength-message to override --\x3e",t.data("validationMinlengthMessage")&&(c=t.data("validationMinlengthMessage")),t.data("validationMinlengthMessage",c),t.data("validationMinlengthMinlength",t.attr("minlength"))),void 0===t.attr("required")&&void 0===t.attr("aria-required")||(c=r.builtInValidators.required.message,t.data("validationRequiredMessage")&&(c=t.data("validationRequiredMessage")),t.data("validationRequiredMessage",c)),void 0!==t.attr("type")&&"number"===t.attr("type").toLowerCase()&&(c=r.builtInValidators.number.message,t.data("validationNumberMessage")&&(c=t.data("validationNumberMessage")),t.data("validationNumberMessage",c)),void 0!==t.attr("type")&&"email"===t.attr("type").toLowerCase()&&(c="Not a valid email address\x3c!-- data-validator-validemail-message to override --\x3e",t.data("validationValidemailMessage")?c=t.data("validationValidemailMessage"):t.data("validationEmailMessage")&&(c=t.data("validationEmailMessage")),t.data("validationValidemailMessage",c)),void 0!==t.attr("minchecked")&&(c="Not enough options checked; Minimum of '"+t.attr("minchecked")+"' required\x3c!-- data-validation-minchecked-message to override --\x3e",t.data("validationMincheckedMessage")&&(c=t.data("validationMincheckedMessage")),t.data("validationMincheckedMessage",c),t.data("validationMincheckedMinchecked",t.attr("minchecked"))),void 0!==t.attr("maxchecked")&&(c="Too many options checked; Maximum of '"+t.attr("maxchecked")+"' required\x3c!-- data-validation-maxchecked-message to override --\x3e",t.data("validationMaxcheckedMessage")&&(c=t.data("validationMaxcheckedMessage")),t.data("validationMaxcheckedMessage",c),t.data("validationMaxcheckedMaxchecked",t.attr("maxchecked")))}void 0!==t.data("validation")&&(d=t.data("validation").split(",")),a.each(t.data(),function(a,e){var t=a.replace(/([A-Z])/g,",$1").split(",");"validation"===t[0]&&t[1]&&d.push(t[1])});var m=d,g=[];do{a.each(d,function(a,e){d[a]=i(e)}),d=a.unique(d),g=[],a.each(m,function(e,n){if(void 0!==t.data("validation"+n+"Shortcut"))a.each(t.data("validation"+n+"Shortcut").split(","),function(a,e){g.push(e)});else if(r.builtInValidators[n.toLowerCase()]){var o=r.builtInValidators[n.toLowerCase()];"shortcut"===o.type.toLowerCase()&&a.each(o.shortcut.split(","),function(a,e){e=i(e),g.push(e),d.push(e)})}}),m=g}while(m.length>0);var h={};a.each(d,function(e,n){var o=t.data("validation"+n+"Message"),l=void 0!==o,s=!1;if(o=o||"'"+n+"' validation failed \x3c!-- Add attribute 'data-validation-"+n.toLowerCase()+"-message' to input to change this message --\x3e",a.each(r.validatorTypes,function(e,r){void 0===h[e]&&(h[e]=[]),s||void 0===t.data("validation"+n+i(r.name))||(h[e].push(a.extend(!0,{name:i(r.name),message:o},r.init(t,n))),s=!0)}),!s&&r.builtInValidators[n.toLowerCase()]){var d=a.extend(!0,{},r.builtInValidators[n.toLowerCase()]);l&&(d.message=o);var c=d.type.toLowerCase();"shortcut"===c?s=!0:a.each(r.validatorTypes,function(e,o){void 0===h[e]&&(h[e]=[]),s||c!==e.toLowerCase()||(t.data("validation"+n+i(o.name),d[o.name.toLowerCase()]),h[c].push(a.extend(d,o.init(t,n))),s=!0)})}s||a.error("Cannot find validation info for '"+n+"'")}),l.data("original-contents",l.data("original-contents")?l.data("original-contents"):l.html()),l.data("original-role",l.data("original-role")?l.data("original-role"):l.attr("role")),o.data("original-classes",o.data("original-clases")?o.data("original-classes"):o.attr("class")),t.data("original-aria-invalid",t.data("original-aria-invalid")?t.data("original-aria-invalid"):t.attr("aria-invalid")),t.bind("validation.validation",function(e,i){var o=n(t),l=[];return a.each(h,function(e,n){(o||o.length||i&&i.includeEmpty||r.validatorTypes[e].blockSubmit&&i&&i.submitting)&&a.each(n,function(a,i){r.validatorTypes[e].validate(t,o,i)&&l.push(i.message)})}),l}),t.bind("getValidators.validation",function(){return h}),t.bind("submit.validation",function(){return t.triggerHandler("change.validation",{submitting:!0})}),t.bind(["keyup","focus","blur","click","keydown","keypress","change"].join(".validation ")+".validation",function(e,i){var d=n(t),c=[];o.find("input,textarea,select").each(function(e,n){var o=c.length;if(a.each(a(n).triggerHandler("validation.validation",i),function(a,e){c.push(e)}),c.length>o)a(n).attr("aria-invalid","true");else{var r=t.data("original-aria-invalid");a(n).attr("aria-invalid",void 0!==r&&r)}}),s.find("input,select,textarea").not(t).not('[name="'+t.attr("name")+'"]').trigger("validationLostFocus.validation"),(c=a.unique(c.sort())).length?(o.removeClass("success error").addClass("warning"),r.options.semanticallyStrict&&1===c.length?l.html(c[0]+(r.options.prependExistingHelpBlock?l.data("original-contents"):"")):l.html('<ul role="alert"><li>'+c.join("</li><li>")+"</li></ul>"+(r.options.prependExistingHelpBlock?l.data("original-contents"):""))):(o.removeClass("warning error success"),d.length>0&&o.addClass("success"),l.html(l.data("original-contents"))),"blur"===e.type&&o.removeClass("success")}),t.bind("validationLostFocus.validation",function(){o.removeClass("success")})})},destroy:function(){return this.each(function(){var t=a(this),i=t.parents(".control-group").first(),n=i.find(".help-block").first();t.unbind(".validation"),n.html(n.data("original-contents")),i.attr("class",i.data("original-classes")),t.attr("aria-invalid",t.data("original-aria-invalid")),n.attr("role",t.data("original-role")),e.indexOf(n[0])>-1&&n.remove()})},collectErrors:function(e){var t={};return this.each(function(e,i){var n=a(i),o=n.attr("name"),r=n.triggerHandler("validation.validation",{includeEmpty:!0});t[o]=a.extend(!0,r,t[o])}),a.each(t,function(a,e){0===e.length&&delete t[a]}),t},hasErrors:function(){var e=[];return this.each(function(t,i){e=e.concat(a(i).triggerHandler("getValidators.validation")?a(i).triggerHandler("validation.validation",{submitting:!0}):[])}),e.length>0},override:function(e){t=a.extend(!0,t,e)}},validatorTypes:{callback:{name:"callback",init:function(a,e){return{validatorName:e,callback:a.data("validation"+e+"Callback"),lastValue:a.val(),lastValid:!0,lastFinished:!0}},validate:function(a,e,t){if(t.lastValue===e&&t.lastFinished)return!t.lastValid;if(!0===t.lastFinished){t.lastValue=e,t.lastValid=!0,t.lastFinished=!1;var i=t,n=a;!function(a,e){for(var t=Array.prototype.slice.call(arguments).splice(2),i=a.split("."),n=i.pop(),o=0;o<i.length;o++)e=e[i[o]];e[n].apply(this,t)}(t.callback,window,a,e,function(a){i.lastValue===a.value&&(i.lastValid=a.valid,a.message&&(i.message=a.message),i.lastFinished=!0,n.data("validation"+i.validatorName+"Message",i.message),setTimeout(function(){n.trigger("change.validation")},1))})}return!1}},ajax:{name:"ajax",init:function(a,e){return{validatorName:e,url:a.data("validation"+e+"Ajax"),lastValue:a.val(),lastValid:!0,lastFinished:!0}},validate:function(e,t,i){return""+i.lastValue==""+t&&!0===i.lastFinished?!1===i.lastValid:(!0===i.lastFinished&&(i.lastValue=t,i.lastValid=!0,i.lastFinished=!1,a.ajax({url:i.url,data:"value="+t+"&field="+e.attr("name"),dataType:"json",success:function(a){""+i.lastValue==""+a.value&&(i.lastValid=!!a.valid,a.message&&(i.message=a.message),i.lastFinished=!0,e.data("validation"+i.validatorName+"Message",i.message),setTimeout(function(){e.trigger("change.validation")},1))},failure:function(){i.lastValid=!0,i.message="ajax call failed",i.lastFinished=!0,e.data("validation"+i.validatorName+"Message",i.message),setTimeout(function(){e.trigger("change.validation")},1)}})),!1)}},regex:{name:"regex",init:function(a,e){return{regex:(t=a.data("validation"+e+"Regex"),new RegExp("^"+t+"$"))};var t},validate:function(a,e,t){return!t.regex.test(e)&&!t.negative||t.regex.test(e)&&t.negative}},required:{name:"required",init:function(a,e){return{}},validate:function(a,e,t){return!(0!==e.length||t.negative)||!!(e.length>0&&t.negative)},blockSubmit:!0},match:{name:"match",init:function(a,e){var t=a.parents("form").first().find('[name="'+a.data("validation"+e+"Match")+'"]').first();return t.bind("validation.validation",function(){a.trigger("change.validation",{submitting:!0})}),{element:t}},validate:function(a,e,t){return e!==t.element.val()&&!t.negative||e===t.element.val()&&t.negative},blockSubmit:!0},max:{name:"max",init:function(a,e){return{max:a.data("validation"+e+"Max")}},validate:function(a,e,t){return parseFloat(e,10)>parseFloat(t.max,10)&&!t.negative||parseFloat(e,10)<=parseFloat(t.max,10)&&t.negative}},min:{name:"min",init:function(a,e){return{min:a.data("validation"+e+"Min")}},validate:function(a,e,t){return parseFloat(e)<parseFloat(t.min)&&!t.negative||parseFloat(e)>=parseFloat(t.min)&&t.negative}},maxlength:{name:"maxlength",init:function(a,e){return{maxlength:a.data("validation"+e+"Maxlength")}},validate:function(a,e,t){return e.length>t.maxlength&&!t.negative||e.length<=t.maxlength&&t.negative}},minlength:{name:"minlength",init:function(a,e){return{minlength:a.data("validation"+e+"Minlength")}},validate:function(a,e,t){return e.length<t.minlength&&!t.negative||e.length>=t.minlength&&t.negative}},maxchecked:{name:"maxchecked",init:function(a,e){var t=a.parents("form").first().find('[name="'+a.attr("name")+'"]');return t.bind("click.validation",function(){a.trigger("change.validation",{includeEmpty:!0})}),{maxchecked:a.data("validation"+e+"Maxchecked"),elements:t}},validate:function(a,e,t){return t.elements.filter(":checked").length>t.maxchecked&&!t.negative||t.elements.filter(":checked").length<=t.maxchecked&&t.negative},blockSubmit:!0},minchecked:{name:"minchecked",init:function(a,e){var t=a.parents("form").first().find('[name="'+a.attr("name")+'"]');return t.bind("click.validation",function(){a.trigger("change.validation",{includeEmpty:!0})}),{minchecked:a.data("validation"+e+"Minchecked"),elements:t}},validate:function(a,e,t){return t.elements.filter(":checked").length<t.minchecked&&!t.negative||t.elements.filter(":checked").length>=t.minchecked&&t.negative},blockSubmit:!0}},builtInValidators:{email:{name:"Email",type:"shortcut",shortcut:"validemail"},validemail:{name:"Validemail",type:"regex",regex:"[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,4}",message:"Not a valid email address\x3c!-- data-validator-validemail-message to override --\x3e"},passwordagain:{name:"Passwordagain",type:"match",match:"password",message:"Does not match the given password\x3c!-- data-validator-paswordagain-message to override --\x3e"},positive:{name:"Positive",type:"shortcut",shortcut:"number,positivenumber"},negative:{name:"Negative",type:"shortcut",shortcut:"number,negativenumber"},number:{name:"Number",type:"regex",regex:"([+-]?\\d+(\\.\\d*)?([eE][+-]?[0-9]+)?)?",message:"Must be a number\x3c!-- data-validator-number-message to override --\x3e"},integer:{name:"Integer",type:"regex",regex:"[+-]?\\d+",message:"No decimal places allowed\x3c!-- data-validator-integer-message to override --\x3e"},positivenumber:{name:"Positivenumber",type:"min",min:0,message:"Must be a positive number\x3c!-- data-validator-positivenumber-message to override --\x3e"},negativenumber:{name:"Negativenumber",type:"max",max:0,message:"Must be a negative number\x3c!-- data-validator-negativenumber-message to override --\x3e"},required:{name:"Required",type:"required",message:"This is required\x3c!-- data-validator-required-message to override --\x3e"},checkone:{name:"Checkone",type:"minchecked",minchecked:1,message:"Check at least one option\x3c!-- data-validation-checkone-message to override --\x3e"}}},i=function(a){return a.toLowerCase().replace(/(^|\s)([a-z])/g,function(a,e,t){return e+t.toUpperCase()})},n=function(e){var t=e.val(),i=e.attr("type");return"checkbox"===i&&(t=e.is(":checked")?t:""),"radio"===i&&(t=a('input[name="'+e.attr("name")+'"]:checked').length>0?t:""),t};a.fn.jqBootstrapValidation=function(e){return t.methods[e]?t.methods[e].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof e&&e?(a.error("Method "+e+" does not exist on jQuery.jqBootstrapValidation"),null):t.methods.init.apply(this,arguments)},a.jqBootstrapValidation=function(e){a(":input").not("[type=image],[type=submit]").jqBootstrapValidation.apply(this,arguments)}}(jQuery);
    </script>
    <script src="mail/contact.js">
        $(function () {

    $("#contactForm input, #contactForm textarea").jqBootstrapValidation({
        preventSubmit: true,
        submitError: function ($form, event, errors) {
        },
        submitSuccess: function ($form, event) {
            event.preventDefault();
            var name = $("input#name").val();
            var email = $("input#email").val();
            var subject = $("input#subject").val();
            var message = $("textarea#message").val();

            $this = $("#sendMessageButton");
            $this.prop("disabled", true);

            $.ajax({
                url: "contact.php",
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    subject: subject,
                    message: message
                },
                cache: false,
                success: function () {
                    $('#success').html("<div class='alert alert-success'>");
                    $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                            .append("</button>");
                    $('#success > .alert-success')
                            .append("<strong>Your message has been sent. </strong>");
                    $('#success > .alert-success')
                            .append('</div>');
                    $('#contactForm').trigger("reset");
                },
                error: function () {
                    $('#success').html("<div class='alert alert-danger'>");
                    $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                            .append("</button>");
                    $('#success > .alert-danger').append($("<strong>").text("Sorry " + name + ", it seems that our mail server is not responding. Please try again later!"));
                    $('#success > .alert-danger').append('</div>');
                    $('#contactForm').trigger("reset");
                },
                complete: function () {
                    setTimeout(function () {
                        $this.prop("disabled", false);
                    }, 1000);
                }
            });
        },
        filter: function () {
            return $(this).is(":visible");
        },
    });

    $("a[data-toggle=\"tab\"]").click(function (e) {
        e.preventDefault();
        $(this).tab("show");
    });
});

$('#name').focus(function () {
    $('#success').html('');
});

    </script>

    <!-- Template Javascript -->
    <script src="js/main.js">
        (function ($) {
    "use strict";
    
    // Dropdown on mouse hover
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Date and time picker
    $('.date').datetimepicker({
        format: 'L'
    });
    $('.time').datetimepicker({
        format: 'LT'
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        margin: 30,
        dots: true,
        loop: true,
        center: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });
    
})(jQuery);


    </script>
</body>
</html>
