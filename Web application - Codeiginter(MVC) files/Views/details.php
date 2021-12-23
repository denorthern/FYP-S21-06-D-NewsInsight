<?php 
include 'include1.php';
?>
<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a > </a></li>
        <li class="breadcrumb-item active"></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-lg-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <!-- begin alert -->
                <?php if ($this->session->userdata('success')): ?>
                <div class="alert alert-success fade show">
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                    </button><?php echo $this->session->userdata('success'); ?>
                </div>
                <?php endif; ?>
                <!-- end alert -->
                <!-- begin panel-body -->
                	
<?php
     
	 # include "db.php"; 
	$dataPoints = array(
    	array()
    );	
							#$this->db->order_by('frequency', 'desc');
							#$this->db->limit(10);
							$this->db->select();
							$this->db->from('sources');
							$this->db->where("code='".$code."'");
							$sid=$this->db->get()->row()->id;
							
							$this->db->select();
							$this->db->from('ner');
							$this->db->where("name='".$name."'");
							$nid=$this->db->get()->row()->nid;
							$this->db->order_by('date', 'asc');
							$this->db->select();
							$this->db->from('trend');
							
							$this->db->where("sid='".$sid."'");
							$this->db->where("nid='".$nid."'");
							

							$res=$this->db->get()->result_array();
						
							$count=0;
							foreach ($res as $row){
								$a=$row['date'];
								$b=$row['tfidf'];
								$dataPoints[$count]=array("label"=>$a, "y"=>$b);
								$count++;
							}		
    ?>	<div class="col-lg-12 col-md-9 ">
            <div class="widget widget-stats bg-grey-transparent-7s">
			
				<div class="stats-icon"><i class="fa "></i></div>
					<div class="stats-info">
                    <h4><b>Trend: <?php echo $trend?></b></h4>
					</div>
			
                <?php include "spline.php"?>
                <!-- end panel-body -->
			</div>
        </div>
		
		
		
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
</div>
<!-- end #content -->
