<?php
/***********************************************************
* Image resizing from php.net using Imagick Class
* Author by: Roman Garcia
* Date: Sep 17, 2015
* comgateway.com (IT Manila Philippines)
* Usage: 192.168.100.76/autoresizeimage/[target folder name]
************************************************************/

if (isset($_GET['dir'])) {
	$path = $_GET['dir'];
	if (!is_dir($path)) {
		echo "<h2 style='background-color:red;'>No directory found. </h2>";
		echo "<h4 style='background-color:red;'>Please try again ! ! ! </h4>";

	echo  '<form>
		Enter target directory name:<br>
		<input type="text" name="dir">
		<br>
		<input type="submit" value="Submit">
		</form>';
		die();
	}
	else {
		echo '</br> <div style="height:0;width:1200px;border:0;border-bottom:2px;border-style: dashed;border-color: #000000"></div><span style="font-weight:bold; font-size:14px; color:red ">Directory Name: ';
		echo $path . "/" .  $file;
		echo '</span><div style="height:0;width:1200px;border:0;border-bottom:2px;border-style: dashed;border-color: #000000"></div></br>';

		loadDir($path);
	}
}
else {
	echo  '<form>
		Enter directory name:<br>
		<input type="text" name="dir">
		<br>
		<input type="submit" value="Submit">
		</form>';
}

function loadDir($path) {
	if ($handle=opendir($path)) {
		while (false!==($file=readdir($handle))) {
			if ($file <> "." AND $file <> "..") { //skip . and ..
				if (is_file($path.'/'.$file)) {
					$tmpFile = trim($file);
					$ext =  pathinfo($file, PATHINFO_EXTENSION);
					$File = pathinfo($file, PATHINFO_FILENAME);

					$valid_exts = array('jpeg', 'JPEG', 'jpg', 'JPG', 'png', 'PNG', 'gif', 'GIF');
					$sizes = array( 'f'=>45, 't'=>92, 's'=>120, 'm'=>225, 'l'=>300); //required sizes in WxH ratio

					if (in_array($ext, $valid_exts)) { // if file is image then process it!
						foreach ($sizes as $w => $h) {
							$image = new Imagick();
							$image->readImage($path.'/'.$tmpFile);
							$imgWidth = $image->getImageWidth();
							$imgHeight = $image->getImageHeight();
							$image->resizeImage($h, $h, Imagick::FILTER_LANCZOS,1); // resize from array sizes
							$fileName .= $File . '_' . $w . '.' . $ext; //create the image filaname
							$image->writeImage($path.'/'.$fileName);
							$tempFileName = $path.'/'.$fileName;
							$arrayfiles[] = $tempFileName;
							$custWidth = $image->getImageWidth();
							$custHeight = $image->getImageHeight();
							echo "[ Original dimension : $imgWidth x $imgHeight ] [ Custom dimension : $custWidth x $custHeight ] Output image location: <a href='{$tempFileName}' style='text-decoration:none'> ". $tempFileName . "</a>&nbsp;&nbsp;";
							echo "<img class='img' src='{$tempFileName}' /></br>";

							$w=''; $h='';$fileName='';
							$image->clear();
							$image->destroy();
						} //end foreach sizes
					}
				}
				if (is_dir($path.'/'.$file)) {
					echo '</br> <div style="height:0;width:1200px;border:0;border-bottom:2px;border-style: dashed;border-color: #000000"></div><span style="font-weight:bold; font-size:14px; color:red ">Directory Name: ';
					echo $path . "/" .  $file;
					echo '</span><div style="height:0;width:1200px;border:0;border-bottom:2px;border-style: dashed;border-color: #000000"></div></br>';
					loadDir($path.'/'.$file);
				}
			}
		} // end while
	} // end handle
}

?>
