<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
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
        <div class="col-md-12 search-panel" style="padding-right: 0px; padding-bottom: 5px;">
                        
            <!-- Add link -->
            <div class="float-right">
                <a href="<?php echo site_url('users/add/'); ?>" class="btn btn-success"><i class="plus"></i> New Users</a>
            </div>
        </div>
        
        <!-- Data list table --> 
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Profile</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($userdata)){ foreach($userdata as $row){ ?>
                <tr>
                    <td><?php echo $row['s_id']; ?></td>
                    <td><?php echo $row['s_name']; ?></td>
                    <td><?php echo $row['s_class']; ?></td>
                    <td><img src="<?php echo base_url(); ?>upload/images/<?php echo !empty($row['s_profile'])?$row['s_profile']:'default-picture.png'; ?>" style="width: 75px; height: 75px;" onerror="this.onerror=null;this.src='<?php echo base_url(); ?>upload/images/default-picture.png';" /></td>
                    <td>
                        <a href="<?php echo site_url('users/edit/'.$row['s_id']); ?>" class="btn btn-warning">edit</a>
                        <a href="<?php echo site_url('users/delete/'.$row['s_id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?')">delete</a>
                    </td>
                </tr>
                <?php } }else{ ?>
                <tr><td colspan="5">No member(s) found...</td></tr>
                <?php } ?>
            </tbody>
        </table>
    
    </div>
</div>
</body>
</html>