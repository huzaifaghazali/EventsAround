<?php 
function checkLogin(){
    if(isset($_SESSION['userID']) && $_SESSION['userID'] != "" && isset($_SESSION['userFullName']) && $_SESSION['userFullName'] != "" && isset($_SESSION['userType']) && $_SESSION['userType'] != "" && isset($_SESSION['userEmail']) && $_SESSION['userEmail'] != "" ){
        return true;
    }else{
      return false;
    }
  }


  function generateErrorMsg($status){
  	if($status == 'P'){
      array_push($_SESSION['errors'],"Your Account is in Pending State, After Admin Approval You can Login in our Portal");
  		return false;
        
    }else if($status == 'B'){
        
         array_push($_SESSION['errors'],"Your Account Has Been Blocked By Admin, For more details please contact with admin support");
        return false;
        
    }else if($status == 'R'){
      
         array_push($_SESSION['errors'],"Your Account Has Been Rejected By Admin, For more details please contact with admin support");
        return false;
       
    }else{
    	return true;
    }
  }

  function getStatusRowBGColor($status){
    if($status == 'P'){
      return "background:#ffff0073;";
    }else if($status == 'A' || $status == '1' ){
      return "background:#00800066;";
    }else if($status == 'R'){
      return "background:#ff000061;";
    }else if($status == 'B' || $status == '0' ){
       return "background:#0000ff66;";
    }  
  }


 function checkCategoryTitleExist($cateTitle,$id=""){
    global $con;
    $sql = "SELECT count(*) as tot FROM `tbl_categories` WHERE `title` = '$cateTitle' and `id` != '$id'";
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['tot'];
    }

 }

  function getStatusTitle($status){
    if($status == 'P'){
      return "Pending";
    }else if($status == 'A' || $status == '1' ){
      return "Active";
    }else if($status == 'R'){
      return "Rejected";
    }else if($status == 'B' || $status == '0' ){
      return "Blocked";
    }else if($status == 'D' ){
      return "Deactivated";
    }else {
      return "N/A";
    }   
  }
 function getGroupName($groupID){
    global $con;
    $sql = "SELECT `group_name` FROM `tbl_groups` WHERE `group_id` = '$groupID'";
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['group_name'];
    }

 }


function getBlogLikes($blogID){
  global $con;
    $sql = "SELECT count(*) as tot FROM `tbl_blogs_like` WHERE `blogID` = '$blogID'";
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['tot'];
    }

}

function getAdminNotiForContactUs(){
  global $con;
    $sql = "SELECT count(*) as tot FROM `tbl_contact_us` WHERE `adminNoti` = '0'";
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['tot'];
    }

}



function getTotalStats($tbl,$statusFiled="",$statusFieldValue="",$userTypeFiled="",$userTypeVal=""){
   global $con;
   if ($statusFiled == "" && $statusFieldValue == "" && $userTypeFiled == "" && $userTypeVal == "") {
    $sql = "SELECT count(*) as tot FROM `".$tbl."`"; 
   }else if($statusFiled == "" && $statusFieldValue == "" && $userTypeFiled != "" && $userTypeVal != ""){
      $sql = "SELECT count(*) as tot FROM `".$tbl."` WHERE `".$userTypeFiled."` = '$userTypeVal'"; 
   }else if($statusFiled != "" && $statusFieldValue != "" && $userTypeFiled != "" && $userTypeVal != ""){
      $sql = "SELECT count(*) as tot FROM `".$tbl."` WHERE `".$statusFiled."` = '$statusFieldValue' AND `".$userTypeFiled."` = '$userTypeVal'"; 
   }else {
     $sql = "SELECT count(*) as tot FROM `".$tbl."` WHERE `".$statusFiled."` = '$statusFieldValue'"; 
   }
   
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['tot'];
    }
  }
?>
