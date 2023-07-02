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
  $email = $_POST['email'];

  $sql = "SELECT healthreport FROM usersdatabase WHERE email = '$email'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $healthReportPath = $row['healthreport'];

    if (file_exists($healthReportPath)) {
      header('Content-Type: application/pdf');
      header('Content-Disposition: inline; filename="healthreport.pdf"');
      readfile($healthReportPath);
    } else {
      echo "Health report not found.";
    }
  } else {
    echo "No user found with the given email ID.";
  }
}

mysqli_close($conn);
?>
