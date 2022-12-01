<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Bike Trip List</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	</head>
	
	<body>
		<div class="col-md-12 text-right">
			<a href="<?php echo base_url('/addHostel');?>" class="btn btn-success">Add Hostel</a>
		</div>
		<table class="table">
			<thead>
				<tr>
					<th>S.No</th>
					<th>Hostel Name</th>
					<th>Detail Itinerary</th>
					<th>Edit</th>
					<th>Faqs</th>
					<th>Gallery</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($hostels->Hostels AS $k=>$value) {  ?>
				<tr>
					<td><?php echo $k+1; ?></td>
					<td><?php echo $value->hostelName; ?></td>
					<td><a class="btn btn-primary" href="hostelitinerary/<?php echo $value->hostelId; ?>">Itinerary</a></td>					
					<td><a class="btn btn-secondary" href="ridingsoloadmin/<?php echo $value->hostelId; ?>">Edit</a></td>
					<td><a class="btn btn-info" href="hostelsFaq/<?php echo $value->hostelId; ?>"> Faq's</a></td>
					<td><a class="btn btn-dark" href="hostelGallery/<?php echo $value->hostelId; ?>">Gallery</a></td>

				</tr>
				<?php } ?>
			</tbody>
			
			
		</table>
		</form>
	</body>
	
</html>