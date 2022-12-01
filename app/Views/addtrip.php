<html>
<head>
	<title>triping</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<!-- include libraries(jQuery, bootstrap) -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    
	</head>
	<body>
		<form action="<?php echo base_url().'/storeBiketrip'?>" method="post" name="adminform" id="adminform" enctype="multipart/form-data">
			<?php //echo "<pre>";
					//print_r($result);
			?>
		<table>
			<tr>
				<td>trip</td>
				<td>:</td>
				<td>
					<input type="text" name="trip_title" value="<?= set_value('trip_title');?>"/> 
					
				</td>
			</tr>
			<tr>
				<td>trip Fee</td>
				<td>:</td>
				<td>
					<input type="text" name="trip_fee" value="<?= set_value('trip_fee');?>"/> 
					
				</td>
			</tr>
			<tr>
				<td>trip Days</td>
				<td>:</td>
				<td>
					<input type="text" name="trip_days" value="<?= set_value('trip_fee');?>"/> 
					
				</td>
			</tr>

			<tr>
				<td>Overview</td>
				<td>:</td>
				<td><textarea name="trip_overview" id="tripOverview" class="summernote"></textarea></td>
			</tr>

			<tr>
				<td>Things to carry</td>
				<td>:</td>
				<td><textarea name="things_carry" id="thingsCarry" class="summernote"></textarea></td>
			</tr>
			<tr>
				<td>Terms&Conditions</td>
				<td>:</td>
				<td><textarea name="terms" id="terms" class="summernote"></textarea></td>
			</tr>
			<tr>
				<td>How to reach</td>
				<td>:</td>
				<td><textarea name="map_image" id="mapImage" class="summernote"></textarea></td>
			</tr>
			<tr>
				<td colspan="3" align="center">
					<input type="submit" name="submit" value="Save">
					<input type="button" name="cancel" value="Cancel" onclick="javascript:history.go(-1);">
				</td>
			</tr>
		</table>
		</form>
		
	<script> 
$(document).ready(function() {
  
  $('#tripOverview').summernote({
    height: 200,
    callbacks: {
        onImageUpload: function(files, editor, welEditable) {
            sendFile(files[0], editor, welEditable,'tripOverview');
        }
    }
});
    $('#thingsCarry').summernote({
    height: 200,
    callbacks: {
        onImageUpload: function(files, editor, welEditable) {
            sendFile(files[0], editor, welEditable,'thingsCarry');
        }
    }
});
    $('#terms').summernote({
    height: 200,
    callbacks: {
        onImageUpload: function(files, editor, welEditable) {
            sendFile(files[0], editor, welEditable,'terms');
        }
    }
});
    $('#mapImage').summernote({
    height: 200,
    callbacks: {
        onImageUpload: function(files, editor, welEditable) {
            sendFile(files[0], editor, welEditable,'mapImage');
        }
    }
});

  function sendFile(file, editor, welEditable,summernotid) {
  	//alert('hi');
  	console.log(file);
    data = new FormData();
    data.append("file", file);
    data.append("foldername",summernotid);
    $.ajax({
      data: data,
      type: "POST",
      url: "<?php echo base_url().'/fileupload';?>",
      cache: false,
      contentType: false,
      processData: false,
      success: function(url) {
      	console.log(url);
      	var image = $('<img>').attr('src',url);
            $('#'+summernotid).summernote("insertNode", image[0]);
      	 
      }
    });
  }
});
		</script>
		</body>
</html>