<form class="uploadform" action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<input class="input" type="file" name="file">
	<input class="submit" type="submit" name="submit" value="Upload File"/>
</form>
<div class="notifications">
	<?php

	// When pressed submit
	if (isset($_POST["submit"])) {

		$notifications = $validatorController->check();

		// Print out all notifications
		foreach ($notifications as $notification) {
			echo '<p>' . $notification . '</p>';
		}
	} ?>
</div>