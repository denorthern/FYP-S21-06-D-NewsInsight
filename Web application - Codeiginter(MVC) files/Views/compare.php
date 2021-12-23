<!-- begin #content -->
<?php 
if($code!=$this->session->userdata('ttid')){
$this->session->set_userdata('ttid', $code);
}
?>

<!-- ================== BEGIN BASE CSS STYLE ================== -->
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
<script>
$(document).ready(function () {
//change selectboxes to selectize mode to be searchable
   $("select").select2();
});
</script>
	
<style>
    body{
        font-family: Arail, sans-serif;
    }
    /* Formatting search box */
    .search-box{
        width: 300px;
        position: relative;
        display: inline-block;
        font-size: 14px;
    }
    .search-box input[type="text"]{
        height: 32px;
        padding: 5px 10px;
        border: 1px solid #CCCCCC;
        font-size: 14px;
    }
    .result{
        position: absolute;        
        z-index: 999;
        top: 100%;
        left: 0;
    }
    .search-box input[type="text"], .result{
        width: 100%;
        box-sizing: border-box;
    }
    /* Formatting result items */
    .result p{
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #CCCCCC;
        border-top: none;
        cursor: pointer;
    }
    .result p:hover{
        background: #f2f2f2;
    }
</style>
<?php 
include 'include1.php';

?>

<?php 
$check=1;
 if ( isset( $_REQUEST['submit1'] ) ) {
$check=0;
 }


if ($check==1){
$date1='2021-11-01';
$date2='2021-11-31';
$name='india';
$name2='pakistan';
}
else{
$date1 = $_REQUEST['date1'];
if ($date1==''){
$date1='2021-10-01';}

$date2 = $_REQUEST['date2'];
$name=$_REQUEST['e1'];
$name2=$_REQUEST['e2'];

if($name=='' or $name2==''){
$name='india';
$name2='pakistan';
}

}

$code='pakistan';


$datax = array();	
$datay = array();	
$datay2= array();		


$begin = new DateTime($date1);
$end = new DateTime($date2);

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
$count=0;
$size=0;
foreach ($period as $dt) {
    $datax[$count]=$dt->format("Y-m-d");
	$datay[$count]=0;
	$datay2[$count]=0;
	$count++;
}
$size=$count;

		
							//
							$this->db->select();
							$this->db->from('sources');
							$this->db->where("code='".$code."'");
							$sid=$this->db->get()->row()->id;
							
							$this->db->select();
							$this->db->from('ner');
							$this->db->where("name='".$name."'");
							$nid=$this->db->get()->row()->nid;
							
							$this->db->order_by('date', 'asc');
							//$this->db->limit(10);
							$this->db->select('*');
							$this->db->from('trend');
							
							//$this->db->where("ner.category='PERSON'");
							
							//$this->db->join('ner','ner.nid = trend.nid');
							$this->db->where("sid='".$sid."'");
							$this->db->where("nid='".$nid."'");
							
							if (($date1!='' && $date1!='')){
								$this->db->where("(date>='".$date1."' and date<='".$date2."')");
							}
							else{
								if($date2==''){
								$this->db->where("(date>='".$date1."'"); }
								
								else if($date1=='' && $date2!=''){
									
									$this->db->where("(date>='".$date1."' and date<='".$date2."')"); }
									
								else{
									$date1='2021-10-01';
									$this->db->where("(date>='".$date1."'"); }
								
							}

							$res1=$this->db->get()->result_array();
							
							$len = count($res1);
							echo $len;
							
							if ($len!=0){
					/*		$count=0;
							$i=0;
							$j=0;
							while($i<$size){
								$row=$res1[$j];
								
								if ($row['date']==$datax[$i]){
									$b=$row['tfidf'];
									$datay[$i]=$b;
									$j++;
									}
								$i++;
							}
							*/
							$count=0;
							foreach ($res1 as $row){
								$i=0;
								while($i<$size){
									if ($row['date']==$datax[$i]){
										$b=$row['tfidf'];
										$datay[$i]=$b;
									}
									$i++;
								}
								
								
							}
							
							
							
						}
							
							
							
							
							
							
							
							
							
							
							$this->db->select();
							$this->db->from('ner');
							$this->db->where("name='".$name2."'");
							$nid=$this->db->get()->row()->nid;
							
							$this->db->order_by('date', 'asc');
							//$this->db->limit(10);
							$this->db->select('*');
							$this->db->from('trend');
							
							//$this->db->where("ner.category='PERSON'");
							
							//$this->db->join('ner','ner.nid = trend.nid');
							$this->db->where("sid='".$sid."'");
							$this->db->where("nid='".$nid."'");
							
							if (($date1!='' && $date1!='')){
								$this->db->where("(date>='".$date1."' and date<='".$date2."')");
							}
							else{
								if($date2=='' && $date1!=''){
								$this->db->where("(date>='".$date1."'"); }
								
								else if($date1=='' && $date2!=''){
									$date1='2021-10-01';
									$this->db->where("(date>='".$date1."' and date<='".$date2."')"); }
									
								else{
									$date1='2021-10-01';
									$this->db->where("(date>='".$date1."'"); }
								
							}

							$res2=$this->db->get()->result_array();
							
						/*	$count=0;
							$i=0;
							$j=0;
							while($i<$size){
								
								
								if ($res2[$j]['date']==$datax[$i]){
									$b=$res2[$j]['tfidf'];
									$datay2[$i]=$b;
									$j++;
									}
								$i++;
							}
							
							
							foreach ($res as $row){
								//echo html_escape($row['name']." - ".$row['freq']);
								$a=$row['date'];
								$b=$row['tfidf'];
								
								while()
								$datay[$count]=$b;
								$datax[$count]=$a;
								$count++;
							} */ 
							
							$len = count($res2);
							echo $len;
							
							if ($len!=0){
					/*		$count=0;
							$i=0;
							$j=0;
							while($i<$size){
								$row=$res1[$j];
								
								if ($row['date']==$datax[$i]){
									$b=$row['tfidf'];
									$datay[$i]=$b;
									$j++;
									}
								$i++;
							}
							*/
							$count=0;
							foreach ($res2 as $row){
								$i=0;
								while($i<$size){
									if ($row['date']==$datax[$i]){
										$b=$row['tfidf'];
										$datay2[$i]=$b;
									}
									$i++;
								}
								
								
							}
							
							
							
						}
							

?>
<script src="/plotly-latest.min.js"></script>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-left">
        <li class="breadcrumb-item active"></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <!-- end page-header -->

    <!-- begin row -->
	
	


	
<?php 
#$this->db->limit(100);
$this->db->select();
$this->db->from('ner');
$ner_all=$this->db->get()->result_array();



?>	
	
 <div  class="widget">	
	
 <form name='write' onSubmit=""	>  
	<label id="">Entity A:</label>
    <select id="e1" style="width:200px;" class="operator" name="e1"> 
         <option value="">Select a Page...</option>
		<?php foreach ($ner_all as $row){ ?> 
         <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option> 
		<?php } ?>
  </select>
  <label id="">Entity B:</label>
  <select id="e2" style="width:200px;" class="operator" name="e2"> 
         <option value="">Select a Page...</option>
         <?php foreach ($ner_all as $row){ ?> 
         <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>  
		<?php } ?>
  </select>
  
  <br></br>
  <label for="birthday">From:</label>
  <input type="date" id="date1" name="date1">
  <label for="birthday">To:</label>
  <input type="date" id="date2" name="date2">
  <input type="submit" name="submit1" id="submit1">
</form>

</div>
<br></br>
<div  class="widget">	
 <div class="row">


 






<div class="col-lg-12 col-md-9 ">
				<div class="widget widget-stats bg-black-transparent-5">

					<?php if($check==0){ include "multiline.php";}?>
				</div>
	</div>

<!-- row end -->	

</div>
</div>
</div>

<?php 
if($code!=$this->session->userdata('ttid')){
$this->session->set_userdata('ttid', $code);
}
?>
<!-- end #content -->

