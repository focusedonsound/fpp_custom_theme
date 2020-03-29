    <div id="tab-uploads">
      <div id= "divUploads">
        <fieldset  class="fs">
          <legend> Uploaded Files </legend>
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
        <legend> Upload Files </legend>
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