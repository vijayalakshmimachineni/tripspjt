<html>
<head> 
	<title>Triping</title>
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
		<div class="container">
			<form action="<?php echo base_url().'/biketripIterinaryStore'?>" method="post" name="adminform" id="adminform" enctype="multipart/form-data">
				<input type="hidden" class="form-control" id="biketrips_id" name="biketrips_id" placeholder="" value="<?php echo $trip_id;?>">
				<?php 
				$i=1;
				//print_r($result);
				if($result){
				foreach($result as $t){ ?>
					<div class="form-group ">
						<div class="btn btn-sm btn-danger">day <?php echo $i++; ?></div>
					</div>
					<div class="form-group">
						<div class="mb-3">
					  <label for="exampleFormControlInput1" class="form-label">Title</label>
					  <input type="hidden" class="form-control" id="iterinary_id" name="iterinary_id[]" placeholder="" value="<?php echo $t->iterinary_id;?>">

					  <input type="text" class="form-control" id="iterinary_title" name="iterinary_title[]" placeholder="iterinary title" value="<?php echo $t->iterinary_title;?>">

					</div>
					<div class="mb-3">
					  <label for="exampleFormControlTextarea1" class="form-label">Description</label>
					  <textarea class="form-control" id="exampleFormControlTextarea1" name="iterinary_details[]" rows="3"><?php echo $t->iterinary_details;?></textarea>
					</div>
					</div>

				<?php }
				} ?>
				<div id="daysdiv"></div>
				<div class="form-group">
					<div onclick="addday();" class="btn btn-sm btn-primary"> + Add Day
						<span id="day" style="display:none;"><?php $a = $i-1; echo $a; ?></span>
					</div>
				</div>
				<div class="form-group">
					<input type="submit" name="submit" value="Update">
					<input type="button" name="cancel" value="Cancel" onclick="javascript:history.go(-1);">
				</div>
			</form>
		</div>
		
			
		
		
	<script> 
		function addday(){
			 day = parseInt($('#day').html())+1;
			var str = '<div class="form-group "><div class="btn btn-sm btn-danger">day '+day+'</div></div><div class="form-group"><div class="mb-3"><label for="exampleFormControlInput1" class="form-label">Title</label><input type="hidden" class="form-control" id="iterinary_id" name="iterinary_id[]" placeholder="" value=""><input type="text" class="form-control" id="iterinary_title" name="iterinary_title[]" placeholder="iterinary title" value=""></div><div class="mb-3"><label for="exampleFormControlTextarea1" class="form-label">Description</label><textarea class="form-control" id="exampleFormControlTextarea1" name="iterinary_details[]" rows="3"></textarea></div></div>';
			$('#daysdiv').append(str);
			$('#day').html(day);
		}
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