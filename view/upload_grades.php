<form class="uploadform" action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<input class="input" type="file" name="file">
	<input class="submit" type="submit" name="submit" value="Upload File"/>
</form>
<div class="notifications">
	<?php

	// When pressed submit
	if (isset($_POST["submit"])) {

		$notifications = array();

		//Check if files were uploaded
		if (isset($_FILES["file"])) {

			// Array with possible mimetypes for csv
			$mimes = array('text/plain', 'text/csv', 'text/tsv');

			// Check if filetype is valid
			if (in_array($_FILES['file']['type'], $mimes)) {

				$fh = fopen($_FILES['file']['tmp_name'], 'r');

				$csvArray = array();

				// Counter for Error
				$linecounter = 1;

				while (!feof($fh)) {

					$a = fgetcsv($fh);

					if (count($a) == 4) {

						//santisize fields
						$a0 = strip_tags($a[0]);
						$a1 = strip_tags($a[1]);
						$a2 = strip_tags($a[2]);
						$a3 = strip_tags($a[3]);

						// When fields not empty or false
						if ($a0 && $a1 && $a2 && $a3 && $a0 > 0 && $a1 > 0) {

							$studentId = intval($a0);
							$courseId = intval($a1);
							$grade = $a2;
							$date = $a3;

							$tempArray = array($studentId, $courseId, $grade, $date);
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

				// Replies with notification array
				$result = $gradeController->uploadGrades($csvArray);

				// push the transferred notification in general notification array
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

		// Print out all notifications
		foreach ($notifications as $notification) {
			echo '<p>' . $notification . '</p>';
		}
	} ?>
</div>