<html>
<head>
	<title>expeditioning</title>
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
		<form action="<?php echo base_url().'/editexpedition'?>" method="post" name="adminform" id="adminform" enctype="multipart/form-data">
			<?php //echo "<pre>";
					//print_r($result);
			?>
		<table>
			<tr>
				<td>expedition</td>
				<td>:</td>
				<td><?php //echo $result->expedition_title; ?>
					<input type="text" name="expedition_title" value="<?php echo $result->expedition_title; ?>"/> 
					<input type="hidden" name="expedition_id" value="<?php echo $result->expedition_id; ?>"/> 
				</td>
			</tr><tr>
				<td>Overview</td>
				<td>:</td>
				<td><textarea name="expedition_overview" id="expedition_overview" class="summernote"><?php echo $result->expedition_overview; ?></textarea></td>
			</tr>

			<tr>
				<td>Things to carry</td>
				<td>:</td>
				<td><textarea name="things_carry" id="things_carry" class="summernote"><?php echo $result->things_carry; ?></textarea></td>
			</tr>
			<tr>
				<td>Terms&Conditions</td>
				<td>:</td>
				<td><textarea name="terms" id="terms" class="summernote"><?php echo $result->terms; ?></textarea></td>
			</tr>
			<tr>
				<td>How to reach</td>
				<td>:</td>
				<td><textarea name="map_image" id="map_image" class="summernote"><?php echo $result->map_image; ?></textarea></td>
			</tr>
			<tr>
				<td colspan="3" align="center">
					<input type="submit" name="submit" value="Update">
					<input type="button" name="cancel" value="Cancel" onclick="javascript:history.go(-1);">
				</td>
			</tr>
		</table>
		</form>
		
	<script> 
//$(document).ready(function() {
  
  $('#expedition_overview').summernote({
    height: 200,
    callbacks: {
        onImageUpload: function(files, editor, welEditable) {
            sendFile(files[0], editor, welEditable,'expedition_overview');
        }
    }
});
    $('#things_carry').summernote({
    height: 200,
    callbacks: {
        onImageUpload: function(files, editor, welEditable) {
            sendFile(files[0], editor, welEditable,'things_carry');
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
    $('#map_image').summernote({
    height: 200,
    callbacks: {
        onImageUpload: function(files, editor, welEditable) {
            sendFile(files[0], editor, welEditable,'map_image');
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
      url: "<?php echo base_url().'/expeditionFileupload';?>",
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
//});
		</script>
		</body>
</html>