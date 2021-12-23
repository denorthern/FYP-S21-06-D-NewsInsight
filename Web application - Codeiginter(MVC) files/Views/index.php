<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title><?php echo $this->db->get_where('setting', array('name' => 'system_name'))->row()->content; ?> | <?php echo $page_title; ?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="<?php echo $this->db->get_where('setting', array('name' => 'tagline'))->row()->content; ?>" name="description" />
   

    
    <?php include 'includes_top.php'; ?>
</head>
<body>
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show">
        <div class="material-loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
            </svg>
            <div class="message">Loading...</div>
        </div>
    </div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
	<?php if ($page_name!='home' ) {?>
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed page-with-wide-sidebar">
		
		
        <?php include 'header.php'; ?>
		
        <?php include 'trends.php'; ?> 
		<?php  ?> 
        <?php include $page_name . '.php';?>
        <?php  ?>

        <!-- begin scroll to top btn -->
        <!--<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" 
		data-click="scroll-top"><i class="material-icons">keyboard_arrow_up</i></a>-->
        <!-- end scroll to top btn -->
    </div>
	<?php }
	else {?>
	<div id="page-container" class="page-header-fixed ">
		
		
        <?php include 'header.php'; ?>
		

		<?php include 'side_chart.php'; ?> 
        <?php include $page_name . '.php';?>
        <?php  ?>

        <!-- begin scroll to top btn -->
        <!--<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" 
		data-click="scroll-top"><i class="material-icons">keyboard_arrow_up</i></a>--><!-- end scroll to top btn -->
    </div>
	<?php }?>
    <!-- end page container -->

    <?php include 'includes_bottom.php'; ?>
</body>
</html>
