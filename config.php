<?php	include 'common/menuHead.inc'; ?>


<?php
    exec($SUDO . " df -k //opt/fpp/www/css |awk '/\/dev\//{printf(\"%d\\n\", $5);}'", $output, $return_val);
    $freespace = $output[0];
    unset($output);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $pageTitle; ?></title>

<link  href="jquery/jQuery-Upload-File/css/uploadfile.min.css" rel="stylesheet">

<script src="jquery/jQuery-Form-Plugin/js/jquery.form.js"></script>
<script src="jquery/jQuery-Upload-File/js/jquery.uploadfile.min.js"></script>

<script type="text/javascript" src="jquery/Spin.js/spin.js"></script>
<script type="text/javascript" src="jquery/Spin.js/jquery.spin.js"></script>

<script>

function ButtonHandler(table, button) {
    var selectedCount = $('#tbl' + table + ' tr.selectedEntry').length;
    var filename = '';
    var filenames = [];
    if (selectedCount == 1) {
        filename = $('#tbl' + table + ' tr.selectedEntry').find('td:first').text();
    }

    if ((button == 'play') || (button == 'playHere')) {
        if (selectedCount == 1) {
            PlayPlaylist(filename, button == 'play' ? 1 : 0);
        } else {
            DialogError('Error', 'Error, unable to play multiple sequences at the same time.');
        }
    } else if (button == 'download') {
        var files = [];
        $('#tbl' + table + ' tr.selectedEntry').each(function() {
            files.push($(this).find('td:first').text());
        });
        DownloadFiles(table, files);
    } else if (button == 'rename') {
        if (selectedCount == 1) {
            RenameFile(table, filename);
        } else {
            DialogError('Error', 'Error, unable to rename multiple files at the same time.');
        }
    } else if (button == 'copyFile') {
        if (selectedCount == 1) {
            CopyFile(table, filename);
        } else {
            DialogError('Error', 'Error, unable to copy multiple files at the same time.');
        }
    } else if (button == 'delete') {
        $('#tbl' + table + ' tr.selectedEntry').each(function() {
            DeleteFile(table, $(this), $(this).find('td:first').text());
        });
    } else if (button == 'editScript') {
        if (selectedCount == 1) {
            EditScript(filename);
        } else {
            DialogError('Error', 'Error, unable to edit multiple files at the same time.');
        }
    } else if (button == 'playInBrowser') {
        if (selectedCount == 1) {
            PlayFileInBrowser(table, filename);
        } else {
            DialogError('Error', 'Error, unable to play multiple files at the same time.');
        }
    } else if (button == 'runScript') {
        if (selectedCount == 1) {
            RunScript(filename);
        } else {
            DialogError('Error', 'Error, unable to run multiple files at the same time.');
        }
    } else if (button == 'videoInfo') {
        if (selectedCount == 1) {
            GetVideoInfo(filename);
        } else {
            DialogError('Error', 'Error, unable to get info for multiple files at the same time.');
        }
    } else if (button == 'viewFile') {
        if (selectedCount == 1) {
            ViewFile(table, filename);
        } else {
            DialogError('Error', 'Error, unable to view multiple files at the same time.');
        }
    } else if (button == 'viewImage') {
        if (selectedCount == 1) {
            ViewImage(filename);
        } else {
            DialogError('Error', 'Error, unable to view multiple files at the same time.');
        }
    }
}

function ClearSelections(table) {
    $('#tbl' + table + ' tr').removeClass('selectedEntry');
    DisableButtonClass('single' + table + 'Button');
    DisableButtonClass('multi' + table + 'Button');
}

function HandleMouseClick(event, row, table) {
    HandleTableRowMouseClick(event, row);

    var selectedCount = $('#tbl' + table + ' tr.selectedEntry').length;

    DisableButtonClass('single' + table + 'Button');
    DisableButtonClass('multi' + table + 'Button');

    if (selectedCount > 1) {
        EnableButtonClass('multi' + table + 'Button');
    } else if (selectedCount > 0) {
        EnableButtonClass('single' + table + 'Button');
    }
}

$(function() {
    $('#tblSequences').on('mousedown', 'tr', function(event,ui){
        HandleMouseClick(event, $(this), 'Sequences');
    });

    $('#tblMusic').on('mousedown', 'tr', function(event,ui){
        HandleMouseClick(event, $(this), 'Music');
    });

    $('#tblVideos').on('mousedown', 'tr', function(event,ui){
        HandleMouseClick(event, $(this), 'Videos');
    });

    $('#tblImages').on('mousedown', 'tr', function(event,ui){
        HandleMouseClick(event, $(this), 'Images');
    });

    $('#tblEffects').on('mousedown', 'tr', function(event,ui){
        HandleMouseClick(event, $(this), 'Effects');
    });

    $('#tblScripts').on('mousedown', 'tr', function(event,ui){
        HandleMouseClick(event, $(this), 'Scripts');
    });

    $('#tblLogs').on('mousedown', 'tr', function(event,ui){
        HandleMouseClick(event, $(this), 'Logs');
    });

    $('#tblUploads').on('mousedown', 'tr', function(event,ui){
        HandleMouseClick(event, $(this), 'Uploads');
    });

  });

  function GetAllFiles() {
	GetFiles('Sequences');
	GetFiles('Music');
	GetFiles('Videos');
	GetFiles('Images');
	GetFiles('Effects');
	GetFiles('Scripts');
	GetFiles('Logs');
	GetFiles('Uploads');
  }

	function RunScript(scriptName)
	{
		window.open("runEventScript.php?scriptName=" + scriptName);
	}

	function EditScript(scriptName)
	{
		$('#fileText').html("Loading...");

		$.get("fppxml.php?command=getFile&dir=Scripts&filename=" + scriptName, function(text) {
			var ext = scriptName.split('.').pop();
			if (ext != "html")
			{
				var html = "<fieldset  class='fs'><legend> " + scriptName + " </legend><div><center><input type='button' class='buttons' onClick='SaveScript(\"" + scriptName + "\");' value='Save'> <input type='button' class='buttons' onClick='AbortScriptChange();' value='Cancel'><hr/>";
				html += "<textarea cols='100' rows='25' id='scriptText'>" + text + "</textarea></center></div></fieldset>";
				$('#fileText').html(html);
			}
		});

		$('#fileViewer').dialog({ height: 600, width: 800, title: "Script Editor" });
		$('#fileViewer').dialog( "moveToTop" );
	}

	function SaveScript(scriptName)
	{
		var contents = $('#scriptText').val();
		var info = {
				scriptName: scriptName,
				scriptBody: contents
			};

		postData = "command=saveScript&data=" + encodeURIComponent(JSON.stringify(info));

		$.post("fppjson.php", postData).done(function(data) {
			if (data.saveStatus == "OK")
			{
				$('#fileViewer').dialog('close');
				$.jGrowl("Script saved.");
			}
			else
			{
				DialogError("Save Failed", "Save Failed: " + data.saveStatus);
			}
		}).fail(function() {
			DialogError("Save Failed", "Save Failed!");
		});

	}

	function AbortScriptChange()
	{
		$('#fileViewer').dialog('close');
	}

</script>
<style>
#tblSequences {
	width: 100%;
}
#tblMusic {
	width: 100%;
}

#uploader_div {
	display: block;
	min-height: 200px;
	width: 100%;
	clear: both;
	padding-top: 00px;
}
fieldset {
	min-height: 200px;
	border: 2px solid #000000;
}
h2 {
	text-align: center;
}
.right {
	text-align: right;
}
</style>
</head>
<div class='title'>File Manager
<? if ($freespace > 95) { ?>
&nbsp;&nbsp;-&nbsp;&nbsp;<b><font color='red'>WARNING: storage device is almost full!</font></b>
<? } ?>
</div>
  <div id="tabs">
    <ul>
      <li><a href="#tab-uploads">Custom Template Files</a></li>
    </ul>
	
    <div id="tab-uploads">
      <div id= "divUploads">
        <fieldset  class="fs">
          <legend> Uploaded  Theme Files </legend>
          <div id="divUploadsData">
            <table id="tblUploads">
            </table>
          </div>
          <hr />
          <div class='right'>
            <input onclick="ClearSelections('Uploads');" class="buttons" type="button" value="Clear Selection" style="float: left;" />
            <input onclick="ButtonHandler('Uploads', 'download');" class="disableButtons singleUploadsButton multiUploadsButton" type="button"  value="Download" />
            <input onclick="ButtonHandler('Uploads', 'delete');" class="disableButtons singleUploadsButton multiUploadsButton" type="button"  value="Delete" />
          </div>
          <font size=-1><b>CTRL+Click to select multiple items</b></font>
        </fieldset>
      </div>
    </div>
    <div id='fileUploader' class='ui-tabs-panel'>
      <fieldset class='fs'>
        <legend> Upload Your Theme Files </legend>
        <div id='fileuploader'>Select Files</div>
      </fieldset>
    </div>
  </div>
</div>
<div id='fileViewer' title='File Viewer' style="display: none">
  <div id='fileText'>
  </div>
</div>
<div id="dialog-confirm" title="Sequence Conversion" style="display: none">
<p>Convert the selected file to?</p>
</div>
<div id="overlay">
</div>



<?php	include 'common/footer.inc'; ?>
<script>
	var activeTabNumber = 
<?php
	if (isset($_GET['tab']))
		print $_GET['tab'];
	else
		print "0";
?>;

    $("#tabs").tabs({cache: true, active: activeTabNumber, spinner: "", fx: { opacity: 'toggle', height: 'toggle' } });

// jquery upload file
$(document).ready(function()
{
	$("#fileuploader").uploadFile({
		url:"jqupload.php",
		fileName:"myfile",
		multiple: true,
		autoSubmit: true,
		returnType: "json",
		doneStr: "Close",
		dragdropWidth: '95%',
		dragDropStr: "<span><b>Drag &amp; Drop or Select Files to upload</b></span>",
		onSuccess: function(files, data, xhr) {
			for (var i = 0; i < files.length; i++) {
				moveFile(files[i]);
			}
			GetAllFiles();
		},
		onError: function(files, status, errMsg) {
			alert("Error uploading file");
		},
		});
});

</script>
</body>
</html>