<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome');
	}

	public function upload()
	{
		// echo "<pre>";
		// print_r($_FILES);
		// print_r($_POST);
		// exit();

		$base64strcount = count($_POST["base64str"]);
		for($i=0;$i<$base64strcount;$i++)
		{
			$img_name = time()."_".rand(0,999999).".".FILE_EXT_PNG;
			$img_path = BASE_UPLOAD_PATH.$img_name;
			$img = $_POST["base64str"][$i];
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace('data:image/jpg;base64,', '', $img);
			$img = str_replace('data:image/jpeg;base64,', '', $img);
			$img = str_replace('data:image/gif;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$img_data = base64_decode($img);

			$im = imagecreatefromstring($img_data);
			if ($im !== false) {
				//header('Content-Type: image/png');
				imagepng($im, $img_path);
				imagedestroy($im);
			}
			else 
			{
				echo 'An error occurred.';
				exit();
			}

			// Get new sizes
			list($width, $height) = getimagesize($img_path);
			$extension = pathinfo($img_path, PATHINFO_EXTENSION);

			$resize_image_arr = array();
			array_push($resize_image_arr, array("width" => "75", "height" => "75", "base_path" => BASE_UPLOAD_PATH_75));
			array_push($resize_image_arr, array("width" => "120", "height" => "120", "base_path" => BASE_UPLOAD_PATH_120));
			array_push($resize_image_arr, array("width" => "256", "height" => "256", "base_path" => BASE_UPLOAD_PATH_256));

			foreach ($resize_image_arr as $row) 
			{
				// CREATE IMAGES
				$newwidth = $row['width'];
				$newheight = $row['height'];

				// Load
				$destination = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromstring($img_data);
				
				// Resize
				imagecopyresized($destination, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output
				imagepng($destination, $row['base_path'].$img_name);
			}
		}
	}
}