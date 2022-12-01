<!DOCTYPE html>
<html>
	<head> 
		<title>Gallery</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/css/dropzone.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/css/dropzone.min.css">
		<script type="text/javascript" src="<?php echo base_url();?>/js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>/js/jquery-ui-1.11.2.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <a href="#"  class="btn btn-primary show-tooltip clearr m-r-10" id="clearr" style="display:none" title="Clear Dropzone"><i class="icon-cloud-clear"></i> Clear Dropzone</a>
            <a href="#" class="btn btn-primary show-tooltip pull-right" title="Upload new images" id="upload-dropzone"><i class="icon-cloud-upload"></i>Upload Images</a>
            <div class="row m-b-10">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="upload-dropzone-area" >
                  <div  id="assignment-dropzone" action="<?php echo base_url('/addExpgallerydetails/'.$expedition_id);?>" class="dropzone dropzone-upload">
                    <div class="fallback">
                      <input name="image" type="file"  multiple />
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <div class="mask"></div>
              <div class="uploaded-images">
              	<hr>
                <ul class="gallery" id="gallery">
	                <?php foreach ($galleryImages->gallery_image as $images) { ?>
	                  <li class="sortable" id="photoid_<?php echo $images->image_id;?>">
	                    <a href="#" class="animal effect-zoe magnific" data-mfp-src="<?php echo $images->imageName;?>">
	                    <img width="180" height="130" src="<?php echo $images->imageName;?>" alt="no image" />
	                    </a>
	                    <div class="gallery-tools">
	                      <a href="#" id="<?php echo $images->image_id;?>" title="Delete<?php echo $images->imageName;?>" url=""  class="delete"><i class="icon-trash"></i>
	                      </a>
	                    </div>
	                  </li>
	                  <?php } ?>   
                </ul>
              </div>
          </div>
        </div>
		</div>
		<script> 
			$(document).ready(function(){
				 $("#assignment-dropzone").dropzone({  
      "maxFilesize": 20
    });
				Dropzone.autoDiscover = false;
			  $(".dropzone").hide();
			  $("#upload-dropzone").click(function(){
			    $(".dropzone").slideToggle('slow');
			  });
			});
		</script>

		<script> 
			$(".dropzone").click(function(){
			    $(".clearr").show();
			});
		    $(".clearr").click(function(){
			    $(".dropzone").animate({
			            height: 'toggle'
			    });
		        window.location.reload();			   
			});
		</script>
		<script type="text/javascript" src="<?php echo base_url();?>/js/dropzone.min.js"></script>

	</body>
</html>