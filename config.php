<style>
.ctstable {
	border:1px solid black;
	margin-left:auto;
	margin-right:auto;
	width: 75%;
}
.ctsHeader {
font-family: futura;
      font-style: italic;    
      width:100%;
      margin: 0 auto;
      text-align: center;
      color:#313131;
      -webkit-animation:colorchange 20s infinite alternate;
      
      
    }

    @-webkit-keyframes colorchange {
      0% {
        
        color: blue;
      }
      
      10% {
        
        color: #8e44ad;
      }
      
      20% {
        
        color: #1abc9c;
      }
      
      30% {
        
        color: #d35400;
      }
      
      40% {
        
        color: blue;
      }
      
      50% {
        
        color: #34495e;
      }
      
      60% {
        
        color: blue;
      }
      
      70% {
        
        color: #2980b9;
      }
      80% {
     
        color: #f1c40f;
      }
      
      90% {
     
        color: #2980b9;
      }
      
      100% {
        
        color: pink;
      }
    }
}
</style>

<html>
   <body>
    <table class="ctstable">
<tbody>
<tr>
<td class="ctsHeader"><h1>Custom Theme </br> Upload Your custom.css or custom.js files.</h1></td>
<td class="ctsHeader"><?php
   if(isset($_FILES['text'])){
      $errors= array();
      $file_name = $_FILES['text']['name'];
      $file_size = $_FILES['text']['size'];
      $file_tmp = $_FILES['text']['tmp_name'];
      $file_type = $_FILES['text']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['text']['name'])));
      
      $extensions= array("css","js","gif","jpg","png");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a css, js, gif, jpg or png file.";
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
?></td>
</tr>
<tr>
<td>      <form action = "" method = "POST" enctype = "multipart/form-data">
         <input type = "file" name = "text" /></td>
<td> <input type = "submit" value="Upload"/></td>
</tr>
<tr>
<td><ul>
            <li>Sent file: <?php echo $_FILES['text']['name'];  ?>
            <li>File size: <?php echo $_FILES['text']['size'];  ?>
            <li>File type: <?php echo $_FILES['text']['type'] ?>
         </ul></td>

</tr>

</tbody>
</table>  
      </form>  
   </body>
</html>