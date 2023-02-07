<?php

session_start();

// Check if the user is trying to log in
if (isset($_POST['username']) && isset($_POST['qrcode'])) {
    
    // Get the username and QR code from the user
    $email= $_POST['email'];
    $qrcode = $_POST['qrcode'];
    
    // Connect to the database
    $conn = new mysqli("localhost","root","","system");
    
    // Check if the connection was successful
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    
    // Check if the username and QR code match
    $stmt = $conn->prepare('SELECT COUNT(*) FROM usertable WHERE email= ? AND qrcode = ?');
    $stmt->bind_param('ss', $email, $qrcode);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    if ($count == 1) {
        
        // Log the user in
        $_SESSION['logged_in'] = true;
        header('Location: home1.php');
        exit;
        
    } else {
        
        // Show an error message
        echo 'Invalid username or QR code.';
        
    }
   } 
    ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Code Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="home1.php" method="POST" autocomplete="off">
                    <h2 class="text-center">qrcode image verification</h2>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Email Address" required>
                    </div>
                
                    <div class="form-group">
                         <input type="file" class="form-control"  name="qrcode" id="file" required onfocusout="f1()">
                    </div>
                 <button type="submit" class="btn btn-primary" name="s" onclick="f1()">Submit</button>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>
