<!DOCTYPE html>
<html>
<head>
  <title>Health Report</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "healthreport";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $age = $_POST['age'];
  $weight = $_POST['weight'];
  $email = $_POST['email'];

  $uploadDir = 'uploadfiles/';
  $fileName = $_FILES['file']['name'];
  $fileTmpName = $_FILES['file']['tmp_name'];
  $filePath = $uploadDir . $fileName;


  if (move_uploaded_file($fileTmpName, $filePath)) {
    // Insert the user details and file path into the database
    $sql = "INSERT INTO usersdatabase (name, age, weight, email, healthreport) VALUES ('$name', '$age', '$weight', '$email', '$filePath')";
    if (mysqli_query($conn, $sql)) {
      echo "<strong>Success!</strong> Your entry has been submitted successfully!";
    } else {
      echo "<strong>Error!</strong> We are facing some technical issues and your entry was not submitted successfully! We regret the inconvenience caused";
    }
  } else {
    echo "Error uploading the health report.";
  }
   
   
  } 


mysqli_close($conn);
?>

<div class="container">
  <h1>Health Report</h1>

  <form id="healthReportForm" enctype="multipart/form-data" action="index.php" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required placeholder="ENTER YOUR NAME"><br><br>

    <label for="age">Age:</label>
    <input type="number" id="age" name="age" required placeholder="ENTER YOUR AGE"><br><br>

    <label for="weight">Weight:</label>
    <input type="number" id="weight" name="weight" required placeholder="ENTER YOUR WEIGHT"><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required placeholder="ENTER YOUR EMAIL"><br><br>

    <label for="file">Upload Health Report:</label>
    <input type="file" id="file" name="file" accept="application/pdf"><br><br>

    <input type="submit" value="Submit">
  </form>
</div>

<div class="healthreport-container">
<h1>Fetch Health Report</h1>
  <form id="fetchHealthReportForm" action="fetchreport.php" method="post">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required placeholder="ENTER YOUR EMAIL"><br><br>
  
    <input type="submit" value="Fetch Health Report">
  </form>
</div>

<script src="script.js"></script>
</body>
</html>
