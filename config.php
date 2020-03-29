<style>
.title{text-align: center;}
#dropzone{width: 100%; height: 50px; border: 2px solid green; text-align: center; line-height: 50px; margin-bottom: 20px;}
th, td {width: 30%;}
</style>
<script>
$('#fileupload').fileupload({
    dataType: 'json',
    dropZone: $('#dropzone'),
    add: function (e, data) { 
        var table= $('#fileTable');
        table.show();
        var tpl = $('<tr class="file">' +
                    '<td class="fname"></td>' +
                    '<td class="fsize"></td>' +
                    '<td class="fact">' +
                    '<a href="#" class="button rmvBtn"><i class="icon-cancel-2"></i> Cancel</a>' +
                    '<a href="#" class="button uplBtn"><i class="icon-play-2"></i> Start</a>' +
                    '</td></tr>');
        tpl.find('.fname').text(data.files[0].name);
        tpl.find('.fsize').text(data.files[0].size);
        data.context = tpl.appendTo('#fileList');
        
        $('#start').click(function () {
            //fix this?
			</script>
<h4 class="title"><i class="icon-chart-alt on-left"></i> blueimp/jQuery-File-Upload Test</h4>
<form id="fileupload" action="/echo/jsonp/" method="POST" enctype="multipart/form-data">
    <div id="dropzone">Drop your files here!</div>
    <input type="file" multiple="" name="files[]" />
    <input id="start" type="submit" value="Start upload" />
    <input id="cancel" type="reset" value="Cancel upload" />
</form>
     <table id="fileTable" style="display: none;">
         <thead>
             <tr><th>File Name</th><th>Size</th><th>&nbsp</th></tr>
         </thead>
         <tbody id="fileList">

         </tbody>
         <tfoot><tr><td id="result"></td><td>&nbsp</td><td>&nbsp</td></tr></tfoot>
    </table>