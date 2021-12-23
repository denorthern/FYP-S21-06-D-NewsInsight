<?php 
include 'include1.php';
?>
<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url()."overview/".$country; ?>">overview</a></li>
        <li class="breadcrumb-item active">Trends List</li>
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
                <!-- begin panel-body -->
                <div class="panel-body">
                    <table id="data-table-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th class="text-nowrap">Name</th>
								<th class="text-nowrap">Category</th>
                                <th class="text-nowrap">Source</th>
                                <th class="text-nowrap">frequency</th>
                                <th class="text-nowrap">tfidf value</th>
                                <th class="text-nowrap">date</th>
                               <!-- <th class="text-nowrap">Created By</th>
                                <th class="text-nowrap">Updated On</th>
                                <th class="text-nowrap">Updated By</th>
                                <th class="text-nowrap">Options</th> -->
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $count = 1;
                            $this->db->select();
							$this->db->from('sources');
							$this->db->where("code='".$code."'");
							$sid=$this->db->get()->row()->id;
							$this->db->order_by('tfidf', 'desc');
							$this->db->select('*');
							$this->db->from('trend');
							
							if($category!=''){
							$this->db->where("ner.category='".$category."'");
							}
							
							$this->db->join('ner','ner.nid = trend.nid');
							$this->db->where("sid='".$sid."'");
							
							$this->db->where('date', '2021-11-21');

							$ners=$this->db->get()->result_array();
							 $categories=array("PERSON", "ORG", "LOC", "WORK_OF_ART", "GPE", "PRODUCT", "EVENT", "NORP"); 
					$catnames=array("Person", "Organisation", "Location", "Art", "GPE", "Product", "Event", "norp");
                            foreach ($ners as $ner):
                        ?>
                            <tr>
                                <td width="1%"><?php echo $count++; ?></td>
                                <td><?php echo html_escape($ner['name']); ?></td>
								<td><?php echo html_escape($ner['category']); ?></td>
                                <td><?php echo html_escape($ner['sid']); ?></td>
                                <td><?php echo html_escape($ner['freq']); ?></td>
                                <td><?php echo html_escape($ner['tfidf']); ?></td>
                                
                                <td><?php echo date($ner['date']); ?></td>
                               
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
