<!DOCTYPE html>
<html>
	<head> 
		<title>Add FAQ</title>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
	    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

		<style>
			@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
			.form_bg{
				border: 1px solid grey;
			    border-radius: 25px;
			    padding: 10px;
			    margin-top: 25px;
			    background-color: #f0f0f0;
			}
		</style>

	</head>
	<body>
		<div class="container">
			<div class="offset-md-3 col-md-6">				
				<form class="row form_bg" action="<?php echo base_url('/saveLpFaq')?>" method="POST" name="addFaqForm" id="addFaqForm">
		            <div class="col-md-12 form-group">
		                <label for="faq_category">Category :</label>
		                <select class="form-control" id="faq_category" name="category_id" required>
		                	<?php foreach($categories -> faq_categories as $category){ ?>
							<option  value="<?php echo $category->faqCatId;?>"><?php echo $category->categoryTitle;?></option>
						<?php } ?>
		                </select> 
		            </div>
		            <div class="col-md-12 form-group">
		                <label for="question">Question:</label>
		                <input type="text" class="form-control" id="question" name="question" required>
		            </div>
		            <div class="col-md-12 form-group">
		                <label for="faq_answer">Answer:</label>
						<!-- <textarea   id="faq_answer" name="answer" ></textarea> -->
						<textarea id="faq_answer" name="answer" required></textarea>
		            </div>
		            <input type="hidden" name="leisure_id" value="<?php echo $leisure_id;?>">
		            <div class="col-md-12 text-center">
						<button type="submit" class="btn btn-success" name="submit">Save</button>
						<button type="button" class="btn btn-danger" name="cancel" onclick="javascript:history.go(-1);">Cancel</button>
					</div>		
				</form>
			</div>
		</div>
		<script>		
			$(document).ready(function() {
				$('#faq_answer').summernote({
					placeholder: 'Enter Your Answer Here...',
					tabsize: 2,
	            	height: 200
				});
			});		
		</script>
	</body>
</html>