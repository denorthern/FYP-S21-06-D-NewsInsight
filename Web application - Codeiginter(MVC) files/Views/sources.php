<?php 
include 'include1.php';
?>
<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url()."overview/".$country; ?>">overview</a></li>
        <li class="breadcrumb-item active">News Sources</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header 
    <h1 class="page-header">
        <a href="<?php echo base_url(); ?>add_tenant">
            <button type="button" class="btn btn-inverse"><i class="fa fa-plus"></i> Add Tenant</button>
        </a>
    </h1> -->
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-lg-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                
                <!-- begin panel-body -->
                <div class="panel-body">
                    <table id="data-table-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th class="text-nowrap">Name</th>
                                <th class="text-nowrap">Website</th>
                                <th class="text-nowrap">Country</th>
                               <!-- 
                                <th class="text-nowrap">Updated On</th>
                                <th class="text-nowrap">Updated By</th>
                                <th class="text-nowrap">Options</th> -->
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $count = 1;
                            $this->db->order_by('id', 'desc');
							if($code=="worldwide"){$sources= $this->db->get_where('sources', array('type' => '2'  ))->result_array();}
							else if($code=="pakistan"){$sources= $this->db->get_where('sources', array('country' => 'pk' ))->result_array();}
							else if($code=="india"){$sources=$this->db->get_where('sources', array('country' => 'in' ))->result_array();}
							else if($code=="china"){$sources=$this->db->get_where('sources', array('country' => 'ch' ))->result_array();}
							else if($code=="russia"){$sources=$this->db->get_where('sources', array('country' => 'ru' ))->result_array();}
							else if($code=="america"){$sources=$this->db->get_where('sources', array('country' => 'us' ))->result_array();}
							else{$sources=$this->db->get_where('sources', array('code' => $code ))->result_array();}
								
							
							foreach ($sources as $source):
                        ?>
                            <tr>
                                <td width="1%"><?php echo $count++; ?></td>
                              
								<td><?php echo html_escape($source['name']); ?></td>
								<td><?php echo html_escape($source['website']); ?></td>
								<td><?php echo html_escape($source['country']); ?></td>
                         
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- end panel-body -->
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
</div>
<!-- end #content -->


