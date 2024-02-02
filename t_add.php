<?php 
require_once('../../../wp-load.php');

$t_day = $_POST['t_day'];
$u_id = $_POST['u_id'];
$t_morning = $_POST['t_morning'];
$t_evening = $_POST['t_evening'];

global $wpdb;

$table_name = $wpdb->prefix . "training_progress";

$check = $wpdb->get_results( "SELECT * FROM $table_name WHERE user_id='".$u_id."' AND t_day='".$t_day."' " );

if(!empty($check)){

$t_id = $check[0]->t_id;
  $wpdb->update($table_name, array('t_morning' => $t_morning,'t_evening'=>$t_evening),array("t_id" => $t_id) ); 
}else{
 $wpdb->insert($table_name, array('t_day' => $t_day, 't_morning' => $t_morning,'t_evening'=>$t_evening,'user_id'=>$u_id) ); 
}
  

?>
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

                        $tData = $wpdb->get_results( "SELECT * FROM $table_name WHERE user_id='".$u_id."' " );
                        // $tData=array( 
                        //         array(
                        //         't_id' => 1,
                        //         't_day' => 1,
                        //         't_morning' => 0,
                        //         't_evening' => 1,
                        //         'user_id' => 1,
                        //         ),
                        //         array(
                        //             't_id' => 2,
                        //             't_day' => 2,
                        //             't_morning' => 0,
                        //             't_evening' => 0,
                        //             'user_id' => 1,
                        //         )
                        //     );
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
                  <div class="skills html" style="width: <?=$nchk.'%';?>; "><?=$nchk.'%';?></div>
                </div> -->
            </div>
            
          </div>
          <div class="p-panel p-success">
            <div class="p-heading"># of consecutive practices <span class="badge"><?=$consecutive_chk;?> out of 60</span>
                <!-- <div class="pro-container">
<div class="skills consecutive" style="width: <?=$consecutive_chk.'%';?>;"><?=$consecutive_chk.'%';?></div>
                </div> -->
            </div>
          </div>
        </div>
   </div>