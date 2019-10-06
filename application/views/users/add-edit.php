<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <h2><?php echo $title; ?></h2>
    
    <!-- Display status message -->
    <?php if(!empty($success_msg)){ ?>
    <div class="col-xs-12">
        <div class="alert alert-success"><?php echo $success_msg; ?></div>
    </div>
    <?php }elseif(!empty($error_msg)){ ?>
    <div class="col-xs-12">
        <div class="alert alert-danger"><?php echo $error_msg; ?></div>
    </div>
    <?php } ?>
    
    <div class="row">
        <div class="col-md-6">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <img src="<?php echo base_url(); ?>upload/images/<?php echo !empty($userdata['s_profile'])?$userdata['s_profile']:'default-picture.png'; ?>" style="width: 75px; height: 75px;" id="picture" />
                        <input type="hidden" name="picture_name" value="<?php echo !empty($userdata['s_profile'])?$userdata['s_profile']:''; ?>">
                        <input class="form-control" type="file" name="picture" id="imgInp" />
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" name="s_name" placeholder="Enter name" value="<?php echo !empty($userdata['s_name'])?$userdata['s_name']:''; ?>" >
                        <?php echo form_error('s_name','<div class="invalid-feedback">','</div>'); ?>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Class</label>
                        <input type="text" class="form-control" name="s_class" placeholder="Enter class" value="<?php echo !empty($userdata['s_class'])?$userdata['s_class']:''; ?>" >
                        <?php echo form_error('s_class','<div class="invalid-feedback">','</div>'); ?>
                    </div>
                </div>
                
                <a href="<?php echo site_url('users'); ?>" class="btn btn-secondary">Back</a>
                <input type="submit" name="userSubmit" class="btn btn-success" value="Submit">
            </form>
        </div>
    </div>
</div>
<script>
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#picture').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}

$("#imgInp").change(function() {
  readURL(this);
});
</script>
</body>
</html>