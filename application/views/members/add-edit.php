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
            <form method="post">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label>First name</label>
                        <input type="text" class="form-control" name="first_name" placeholder="Enter first name" value="<?php echo !empty($member['first_name'])?$member['first_name']:''; ?>" >
                        <?php echo form_error('first_name','<div class="invalid-feedback">','</div>'); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Last name</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Enter last name" value="<?php echo !empty($member['last_name'])?$member['last_name']:''; ?>" >
                        <?php echo form_error('last_name','<div class="invalid-feedback">','</div>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" placeholder="Enter email" value="<?php echo !empty($member['email'])?$member['email']:''; ?>" >
                    <?php echo form_error('email','<div class="invalid-feedback">','</div>'); ?>
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="gender1" name="gender" class="custom-control-input" value="Male" <?php echo empty($member['gender']) || (!empty($member['gender']) && ($member['gender'] == 'Male'))?'checked="checked"':''; ?> >
                        <label class="custom-control-label" for="gender1">Male</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="gender2" name="gender" class="custom-control-input" value="Female" <?php echo (!empty($member['gender']) && ($member['gender'] == 'Female'))?'checked="checked"':''; ?> >
                        <label class="custom-control-label" for="gender2">Female</label>
                    </div>
                    <?php echo form_error('gender','<div class="invalid-feedback">','</div>'); ?>
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <input type="text" class="form-control" name="country" placeholder="Enter country" value="<?php echo !empty($member['country'])?$member['country']:''; ?>" >
                    <?php echo form_error('country','<div class="invalid-feedback">','</div>'); ?>
                </div>
                
                <a href="<?php echo site_url('members'); ?>" class="btn btn-secondary">Back</a>
                <input type="submit" name="memSubmit" class="btn btn-success" value="Submit">
            </form>
        </div>
    </div>
</div>