<?php
$username = $_POST['username'];
$password = $_POST['password'];
$full_name = $_POST['full_name'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$phone_no = $_POST['phone_no'];

if (!empty($username) || !empty($password) || !empty($full_name) || !empty($gender) || !empty($email) || empty($phone_no)) {
	$host = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbname = "students";

	//create connection
	$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
	if (mysqli_connect_error()) {
		die('Connect Error('.mysqli_connect_errno().')'. mysqli_connect_error());
	} else {
		$SELECT = "SELECT email From account Where email = ? Limit 1";
		$INSERT = "INSERT Into account (username, password, full_name, gender, email, phone_no) values(?, ?, ?, ?, ?, ?)";

		//Prepare statement
		$stmt = $conn->prepare($SELECT);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->bind_result($email);
		$stmt->store_result();
		$rnum = $stmt->num_rows;

		if (rnum==0) {
			$stmt->close();

			$stmt = $conn->prepare($INSERT);
			$stmt->bind_param("sssssi", $username, $password, $full_name, $gender, $email, $phoneno);
			$stmt->execute();
			echo "New record inserted successfully";
		} else {
			echo "Someone already registered using this email";
		}
		$stmt->close();
		$conn->close();
	}
	
} else {
	echo "All field are required";
	die();
}

?>