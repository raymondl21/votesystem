<?php
	include 'includes/session.php';
	include 'includes/sms.php';

	if(isset($_POST['add'])){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$contact = $_POST['contact'];
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$filename = $_FILES['photo']['name'];
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
		}
		
		// $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$voter = $_POST['voter_id']; //substr(str_shuffle($set), 0, 15);

		$sql = "SELECT * FROM voters WHERE voters_id = '$voter'";

		if($result = $conn->query($sql)){
			if($result->num_rows > 0){
				$_SESSION['error'] = "Voter's ID has already taken.";
			}
			else{
				$sql = "INSERT INTO voters (voters_id, password, firstname, lastname, contact, photo) VALUES ('$voter', '$password', '$firstname', '$lastname', '$contact', '$filename')";
				if($conn->query($sql)){
					$_SESSION['success'] = 'Voter added successfully';
					$sms = new SmsAPI('49798b0f3293a8531c35dadcf0b14e2b', 'SEMAPHORE');
					$msgBody = "Hi $firstname $lastname,\n\n";
					$msgBody .= "You have a new Voter's Account:\n\n";
					$msgBody .= "Voter's ID: $voter\nPassword: " . $_POST['password'];
					$msgBody .= "\n\nNCC STUDENT COUNCIL VOTING SYSTEM";
					if (preg_match('/^(09|\+639)\d{9}$/', $contact)) {
						$sms->send($contact, $msgBody);
					}
				}
				else{
					$_SESSION['error'] = $conn->error;
				}
			}
		}
	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: voters.php');
?>