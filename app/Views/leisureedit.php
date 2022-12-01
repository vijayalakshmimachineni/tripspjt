<?php
/*
include("db.php");

$leisureId = $_GET['leisureId'];
if(isset($_POST['submit'])) {
	extract($_POST);
	$stmt2 = $conn->prepare("UPDATE  sg_trekingdetails SET trekOverview='".$trekOverview."', terms='".$terms."', mapImage='".$mapImage."', thingsCarry='".$thingsCarry."' WHERE leisureId=".$leisureId);
	$res = $stmt2->execute();
	
}
$stmt = $conn->prepare("SELECT * FROM sg_trekingdetails WHERE leisureId=".$leisureId);
$stmt->execute();

// set the resulting array to associative
$result = $stmt->fetch(PDO::FETCH_OBJ);
*/

?>
<html>
<head>
	<title>Treking</title>
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
		<form action="<?php echo base_url().'/editLeisure'?>" method="post" name="adminform" id="adminform" enctype="multipart/form-data">
			<?php //echo "<pre>";
					//print_r($result);
			?>
		<table>
			<tr>
				<td>Trek</td>
				<td>:</td>
				<td><?php //echo $result->trekTitle; ?>
					<input type="text" name="pkg_name" value="<?php echo $result->pkgName; ?>"/> 
					<input type="hidden" name="leisure_id" value="<?php echo $result->leisureId; ?>"/> 
				</td>
			</tr><tr>
				<td>Overview</td>
				<td>:</td>
				<td><textarea name="pkg_overview" id="pkg_overview" class="summernote"><?php echo $result->pkgOverview; ?></textarea></td>
			</tr>

			<tr>
				<td>inclusionExclusion</td>
				<td>:</td>
				<td><textarea name="inclusion_exclusion" id="inclusion_exclusion" class="summernote"><?php echo $result->inclusionExclusion; ?></textarea></td>
			</tr>
			<tr>
				<td>Terms&Conditions</td>
				<td>:</td>
				<td><textarea name="terms_conditions" id="terms" class="summernote"><?php echo $result->termsConditions; ?></textarea></td>
			</tr>
			<tr>
				<td>How to reach</td>
				<td>:</td>
				<td><textarea name="where_report" id="where_report" class="summernote"><?php echo $result->whereReport; ?></textarea></td>
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
  
  $('#pkg_overview').summernote({
    height: 200,
    callbacks: {
        onImageUpload: function(files, editor, welEditable) {
            sendFile(files[0], editor, welEditable,'pkg_overview');
        }
    }
});
    $('#inclusion_exclusion').summernote({
    height: 200,
    callbacks: {
        onImageUpload: function(files, editor, welEditable) {
            sendFile(files[0], editor, welEditable,'inclusion_exclusion');
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
    $('#where_report').summernote({
    height: 200,
    callbacks: {
        onImageUpload: function(files, editor, welEditable) {
            sendFile(files[0], editor, welEditable,'where_report');
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
      url: "<?php echo base_url().'/leisureFileupload';?>",
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