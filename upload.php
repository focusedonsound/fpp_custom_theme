<!--
  Author: Abhinav Singh
  Written on: 23th May, 2008
  Version: 1
  Last Edited: 30th May, 2008
  Contact: admin@abhinavsingh.com
  License: Creative Commons Attribution-Share Alike 2.5 India License
-->
<?php
  // Set the upload target directory
  $target_path = "upload/";

  for($i=1;$i<=5;$i++) {
    $attachments = 'attachment_'.$i;
    $attachmentdiv = 'attachmentdiv_'.$i;
    $FileName = $_FILES[$attachments]['name'];
    // Check if filename is empty
    if($FileName != "") {
      $FileType = $_FILES[$attachments]['type'];
      $FileExtension = strtolower(substr($FileName,strrpos($FileName,'.')+1));
      // Check for supported file formats
      if($FileExtension != "css" && $FileExtension != "jpg" && $FileExtension != "png") {
        echo "<script type='text/javascript'>parent.document.getElementById('typeerrormessage').style.display = 'inline';</script>";
      }
      else {
        $FileSize = round($_FILES[$attachments]['size']/1024);
        // Check for file size
        if($FileSize > 100) {
          echo "<script type='text/javascript'>parent.document.getElementById('sizeerrormessage').style.display = 'inline';</script>";
        }
        else {
          $FileTemp = $_FILES[$attachments]['tmp_name'];
          $FileLocation = $target_path.basename($FileName);
          // Finally Upload
          if(move_uploaded_file($FileTemp,$FileLocation)) {
            // On successful upload send a message to corresponding attachmentdiv from which the file came from
            echo "<script type='text/javascript'>parent.document.getElementById('".$attachmentdiv."').innerHTML = '<input CHECKED type=\"checkbox\"><a href=\"http://abhinavsingh.com/webdemos/upload/".$FileName."\" target=\"_blank\"><font size=2><b>".$FileName."</b> <i>(".$FileType.")</i> ".$FileSize." Kb</font>';</script>";
            echo "<script type='text/javascript'>parent.document.getElementById('typeerrormessage').style.display = 'none';</script>";
            echo "<script type='text/javascript'>parent.document.getElementById('sizeerrormessage').style.display = 'none';</script>";
          } 
          else {
            echo "There was an error uploading the file, please try again!";
          }
        }
      }
    }
  }
?>
