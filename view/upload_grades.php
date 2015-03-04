<?php
require("../config.php");
?>

<html>
<head>
	<title>List of People</title>
</head>
<body>

<form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<input type="file" name="file">
	<input type="submit" name="submit" value="Upload File"/>
</form>
<?php

if (isset($_POST["submit"])) {

	$notifications = array();

	if (isset($_FILES["file"])) {

		// Array with possible mimetypes for csv
		$mimes = array('text/plain', 'text/csv', 'text/tsv');
		if (in_array($_FILES['file']['type'], $mimes)) {

			$fh = fopen($_FILES['file']['tmp_name'], 'r');

			$csvArray = array();

			// Counter for Error
			$linecounter = 1;

			while (!feof($fh)) {

				$a = fgetcsv($fh);

				if (count($a) == 3) {

					//santisize fields
					$a0 = strip_tags($a[0]);
					$a1 = strip_tags($a[1]);
					$a2 = strip_tags($a[2]);

					if ($a0 && $a1 && $a2 && $a0 > 0 && $a1 > 0) {

						$studentId = intval($a0);
						$courseId = intval($a1);
						$grade = $a2;

						$tempArray = array($studentId, $courseId, $grade);
						array_push($csvArray, $tempArray);
					} else {
						// Throw Error
						array_push($notifications, $errorController->create('Values in line ' . $linecounter . ' are either empty or not correct. Value1 : StudentId, Value2 = CourseID, Value3 = Grade')->getErrormessage());
					}
				} else {
					// Throw Error
					array_push($notifications, $errorController->create('Line ' . $linecounter . ' has more than 3 values. Value1 : StudentId, Value2 = CourseID, Value3 = Grade')->getErrormessage());
				}

				$linecounter++;
			}

			$result = $gradeController->uploadGrades($csvArray);

			foreach ($result as $notification) {
				array_push($notifications, $notification);
			}
		} else {
			//Throw Error
			array_push($notifications, $errorController->create('Uploaded file has not the right type (csv) or no file uploaded.')->getErrormessage());
		}
	} else {
		//Throw Error
		array_push($notifications, $errorController->create('No File uploaded.')->getErrormessage());
	}

	foreach ($notifications as $notification) {
		echo $notification . '<br>';
	}
} ?>
</body>
</html>
