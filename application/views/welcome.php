<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>dist/cropper.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>dist/mycss.css">
</head>
<body>

<div class="container">

	<form id="imageForm1" action="<?php echo base_url() ?>welcome/upload" method="POST">

		<div class="row">
			<div class="col-sm-6 col-md-6">
				<div><input type="submit" class="btn btn-info" value="UPLOAD ALL IMAGES"></div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div style="float: right;">
					<label class="label" data-toggle="tooltip" title="Upload your images">
						<img class="rounded avatar" src="<?php echo base_url() ?>upload/upload-cloud-flat.png" alt="choose image click here...">
						<input type="file" id="input" class="sr-only" name="image" accept="image/*" >
					</label>
				</div>
			</div>
		</div>

		<div id="image_crop_data"></div>
		
	</form>
	
		<!-- MODEL POPUP -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Crop the image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="img-container">
              <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="crop">Crop</button>
          </div>
        </div>
      </div>
    </div>
		<!-- MODEL POPUP -->

</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url() ?>dist/cropper.js"></script>
<script>
  window.addEventListener('DOMContentLoaded', function () {
		var image = document.getElementById('image');
		var input = document.getElementById('input');
		var $modal = $('#modal');
		var cropper;
		var image_cnt = 0;

		input.addEventListener('change', function (e) {
			var files = e.target.files;
			var reader;
			var file;
			var url;

			if (files && files.length > 0) {
				file = files[0];
				if (URL) {
					image.src = URL.createObjectURL(file);
					$modal.modal('show');
				} 
				else if (FileReader) 
				{
					reader = new FileReader();
					reader.onload = function (e) {
						image.src = reader.result;
						$modal.modal('show');
					};
					reader.readAsDataURL(file);
				}
			}
		});

		$modal.on('shown.bs.modal', function () {
			cropper = new Cropper(image, {
				aspectRatio: 1,
				viewMode: 1,
			});
		}).on('hidden.bs.modal', function () {
			cropper.destroy();
			cropper = null;
		});

		document.getElementById('crop').addEventListener('click', function () {

			var canvas;
			$modal.modal('hide');
			if (cropper) {
				canvas = cropper.getCroppedCanvas({
					width: 160,
					height: 160,
				});
				$("#image_crop_data").append('<div class="pad_row" id="image_cnt_'+image_cnt+'"><img class="rounded avatar img-rounded" src="'+canvas.toDataURL()+'"><a onclick="removeImage('+image_cnt+')" style="float: right;cursor: pointer;">Remove</a><textarea name="base64str[]" style="opacity: 0;">'+canvas.toDataURL()+'</textarea></div>');
				image_cnt++;
			}
		});
		
		var frm = $('#imageForm1');
    frm.submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                console.log('Submission was successful.');
                console.log(data);
								$("#image_crop_data").html("");
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    });

	});

	function removeImage(id)
	{
		$("#image_cnt_"+id).remove();
	}
  </script>

</body>
</html>