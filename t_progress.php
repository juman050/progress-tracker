<!-- 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>  -->

<style type="text/css">
div.procontainer{

}
div.procontainer h3{
    text-align: center;
}
div#trainingContent {
    width: 100%;
    overflow: hidden;
}
.leftPro {
    width: 50%;
    float: left;
    padding-right: 15px;
    padding-left: 15px;
}
.rightPro {
    width: 50%;
    float: left;
    padding-right: 15px;
    padding-left: 15px;
}
.p-group {
    margin-top: 60px;
    padding: 0px;
    margin-bottom: 20px;
}
.p-panel {
    margin-bottom: 20px;
    background-color: #e8e8e8;
    border: 1px solid transparent;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.p-group .p-panel+.p-panel {
    margin-top: 5px;
}
.p-group .p-heading {
    border-bottom: 0;
}
.p-heading {
    padding: 10px 15px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
}
.p-group .p-info {
    margin-bottom: 0;
    border-radius: 4px;
    border-color: #bce8f1;
}
.p-info>.p-heading {
    color: #31708f;
    background-color: #d9edf7;
    border-color: #bce8f1;
}
.p-info>.p-heading .badge {
    color: #d9edf7;
    background-color: #31708f;
}
.p-success>.p-heading .badge {
    color: #dff0d8;
    background-color: #3c763d;
}
.badge {
    display: inline-block;
    min-width: 10px;
    padding: 3px 7px;
    font-size: 12px;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    background-color: #777;
    border-radius: 10px;
}
form#training_form table {
    font-size: 14px;
}
form#training_form .table>tbody>tr>td,form#training_form .table>tbody>tr>th,
form#training_form .table>tfoot>tr>td,form#training_form .table>tfoot>tr>th,
form#training_form .table>thead>tr>td,form#training_form .table>thead>tr>th{
    padding: 3px 5px;
    vertical-align: middle;
}
form#training_form .table-bordered>tbody>tr>td,form#training_form .table-bordered>tbody>tr>th, 
form#training_form .table-bordered>tfoot>tr>td,form#training_form .table-bordered>tfoot>tr>th, 
form#training_form .table-bordered>thead>tr>td,form#training_form .table-bordered>thead>tr>th {
    border: 1px solid #555;
}
.pro-container {
  width: 60%;
  background-color: #ddd;
}
.skills {
  text-align: right;
  padding-top: 2px;
  padding-bottom: 2px;
  color: white;
}

.html {background-color: #4CAF50;font-size: 12px}
.consecutive {background-color: #f00;font-size: 12px}
input.training_update {
    padding: 7px;
    font-size: 12px;
    background: #368c39;
}
</style>


<div class="procontainer">  
<h3>Progress</h3>

<div class="mainrow" id="trainingContent">  
    
    <div class="leftPro"> 
            
        <form method="post" id="training_form">
 
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>Days</th>
                        <th>Morning</th>
                        <th>Evening</th>
                        <th>Action</th>
                    </thead>
                    <tbody>

                        <?php 
                        $nchk=0;
                        $consecutive_chk=0;
                        $count=0;
                        global $wpdb;

                        $table_name = $wpdb->prefix . "training_progress";
                        $u_id = get_current_user_id();
                        $tData = $wpdb->get_results( "SELECT * FROM $table_name WHERE user_id='".$u_id."'" );
                        ?>
                    
                    <?php for ($i=1; $i <=30 ; $i++) { ?>
                        <?php 
                        $morningchk='';
                        $eveningchk='';
                        foreach ($tData as $training){
                            if($training->t_day==$i && $training->t_morning=='1'){
                                $morningchk='checked="checked"';
                                $nchk++;
                            }
                            if($training->t_day==$i && $training->t_evening=='1'){
                                $eveningchk='checked="checked"';
                                $nchk++;
                            }

                            if($training->t_day==$i && $training->t_morning=='1' && $training->t_evening=='1'){

                                $count+=2;
                                $consecutive_chk=$count;

                            }elseif($training->t_day==$i && $training->t_morning=='1' && $training->t_evening=='0'){
                                
                                $count++;
                                $consecutive_chk=$count;
                                $count=0;
                                //$count++;
                                
                            }elseif ($training->t_day==$i && $training->t_morning=='0' && $training->t_evening=='1') {
                                $count++;
                                
                                $consecutive_chk=$count;
                               // $count++;

                            }else{
                               // $consecutive_chk=$count;
                            }
                        }?>
                        <tr data-tDay="<?= $i;?>">
                            <td>Day <?= $i;?></td>
                            <td>
                                <input type="checkbox" class="t_morning<?= $i;?>" name="morning" <?= $morningchk;?>>
                            </td>
                            <td>
                                <input type="checkbox" class="t_evening<?= $i;?>" name="evening" <?=$eveningchk;?>>
                            </td>
                            <td data-tday="<?= $i;?>">
                                <input type="button" name="training_update" id="training_update" class="btn-sm btn-success training_update" value="save" />
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </form>
   
    </div>
    <div class="rightPro"> 
       <div class="p-group">
          <div class="p-panel p-info">
            <div class="p-heading">
                # of practices <span class="badge"><?=$nchk;?> out of 60</span>
                <!-- <div class="pro-container">
                  <div class="skills html" style="width: <?=$nchk;?>%; "><?=$nchk;?>%</div>
                </div> -->
            </div>
            
          </div>
          <div class="p-panel p-success">
            <div class="p-heading"># of consecutive practices <span class="badge"><?=$consecutive_chk;?> out of 60</span>
                <!-- <div class="pro-container">
<div class="skills consecutive" style="width: <?=$consecutive_chk;?>%;"><?=$consecutive_chk;?>%</div>
                </div> -->
            </div>
          </div>
        </div>
   </div>
</div>
</div>
<?php 

$plugins_url = site_url() . '/wp-content/plugins/training-progress';   

?>
<script>  
$(document).ready(function(){  
    $(document).on("click", ".training_update", function(){
    var tday = $(this).parent().data('tday');
    var t_morning = 0;
    var t_evening = 0;
    if($(".t_morning"+tday).is(":checked")){
        var t_morning = 1;
    }
    if($(".t_evening"+tday).is(":checked")){
        var t_evening = 1;
    }
    var u_id = '<?php echo get_current_user_id();?>';
    $.ajax({
        url:"<?php echo $plugins_url;?>/t_add.php",
        method:"POST", 
        dataType : "html",
        data:{
          u_id: u_id, 
          t_day: tday, 
          t_morning: t_morning, 
          t_evening: t_evening, 
        },
        success:function(response) {
         $("#trainingContent").html(response);
       },
       error:function(){
        alert("error");
       }

    });

  });
});
</script>
