<!-- begin #sidebar -->
  <link href="<?php echo base_url(); ?>/now/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>/now/assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
    <div class="sidebar" data-color="white">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="" class="simple-text logo-mini">
        </a>
        <a href="http://localhost/newsinsight/" class="simple-text logo-normal">
          News Insight
        </a>
      </div>
	  <div  class="sidebar-wrapper" data-scrollbar="true" data-height="100%">
        <ul class="nav">
          <li class="nav-header blue">Top Trending</li>
			<?php			
                            $count = 1;
                            $this->db->select();
							$this->db->from('sources');
							$this->db->where("code='".$code."'");
							$sid=$this->db->get()->row()->id;
							$this->db->order_by('tfidf', 'desc');
							$this->db->limit(30);
							$this->db->select('*');
							$this->db->from('trend');
							
							//$this->db->where("ner.category='PERSON'");
							
							$this->db->join('ner','ner.nid = trend.nid');
							$this->db->where("sid='".$sid."'");
							
							$this->db->where('date', '2021-11-21');

							$ners=$this->db->get()->result_array();
							#$ners = $this->db->get_where('ner', array('source'=>'all'))->result_array();
							
							#$ners = $this->db->get_where('ner', array('id' == 1))->row()->trends;
                            #$ners = $this->db->get('ner')->result_array();
							$n='inxi';
					 #while($count!=5){
						 $categories=array("PERSON", "ORG", "LOC", "WORK_OF_ART", "GPE", "PRODUCT", "EVENT", "NORP"); 
					$catnames=array("Person", "Organisation", "Location", "Art", "GPE", "Product", "Event", "norp");
					 foreach ($ners as $ner){
					#			if (count==6){break;}?> 
			
			
            <li class="">
				
				<a href="<?php 
				echo base_url(); ?>details/<?php echo $asource."/".$ner['name']; ?>" class="">
                    <i  class="fa fa-list blue "></i>
					
					<span><?php echo $count++; ?></span>
                    <span><?php echo html_escape($ner['name']); ?> <tb> | </tb> <tb> </tb> <tb> </tb><?php
					
					$c=0;
					$var="";
					while ($c<8 ){
					if ( $categories[$c]==$ner['category']) $var=$catnames[$c];
					$c++;
					}	
					
					echo html_escape($var); ?></span>
				</a>	
			</li>	
			<?php } ?>
				
		 
        </ul>
	  </div>
    </div>

 
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->
