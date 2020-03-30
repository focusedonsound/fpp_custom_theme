<?php
   if(isset($_FILES['text'])){
      $errors= array();
      $file_name = $_FILES['text']['name'];
      $file_size = $_FILES['text']['size'];
      $file_tmp = $_FILES['text']['tmp_name'];
      $file_type = $_FILES['text']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['text']['name'])));
      
      $extensions= array("css","jpg","png");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152) {
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true) {
         move_uploaded_file($file_tmp,"/home/fpp/media/config/".$file_name);
         echo "Success";
      }else{
         print_r($errors);
      }
   }
?>
<html>
   <body>
    <table>
<tbody>
<tr>
<td>      <form action = "" method = "POST" enctype = "multipart/form-data">
         <input type = "file" name = "text" /></td>
<td><input type = "submit"/></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</tbody>
</table>  

         
			
         <ul>
            <li>Sent file: <?php echo $_FILES['text']['name'];  ?>
            <li>File size: <?php echo $_FILES['text']['size'];  ?>
            <li>File type: <?php echo $_FILES['text']['type'] ?>
         </ul>
			
      </form>
      
   </body>
</html>