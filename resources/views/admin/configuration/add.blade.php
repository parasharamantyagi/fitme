@extends('layout.admin')

@section('style')
<style>
	
</style>
@endsection
@section('content')

	<div class="single-product-tab-area mg-b-30">
            <!-- Single pro tab review Start-->
            <div class="single-pro-review-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="review-tab-pro-inner">
                                
                                <div id="myTabContent" class="tab-content custom-product-edit">
                                    <div class="product-tab-list tab-pane fade active in" id="description">
									{{Form::open(['url'=>url('admin/add-configuration'),'id'=>'general_form'])}}
                                        <div class="row">
												<div class="col-md-6 form-group">
												  <label>Upload Video</label>
												  <input class="form-control" id="input-video-file" name="video_name" type="file" accepts="video/webm" />
												  <input name="video_thumb_image" type="hidden" />
												</div>
                                        </div>
										<div class="thumbnail_image_div">
											<div class="row">
												<div class="col-md-6 form-group">
													<label>Please select an image for thumbnail</label>
												</div>
											</div>
											<div class="row">
												<div class="col-md-3 form-group img-thumb-1">
													<img id="img-thumb" alt="Thumbnail of a video" src=""><br />
													<input type="radio" data-value="img-thumb" name='thumb_image'/>
												</div>
												<div class="col-md-3 form-group img-thumb-2">
													<img id="img-thumb-1" alt="Thumbnail of a video" src=""><br />
													<input type="radio" data-value="img-thumb-1" name='thumb_image'/>
												</div>
												<div class="col-md-3 form-group img-thumb-3">
													<img id="img-thumb-2" alt="Thumbnail of a video" src=""><br />
													<input type="radio" data-value="img-thumb-2" name='thumb_image'/>
												</div>
												<div class="col-md-3 form-group img-thumb-4">
													<img id="img-thumb-3" alt="Thumbnail of a video" src=""><br />
													<input type="radio" data-value="img-thumb-3" name='thumb_image'/>
												</div>
											</div>
										</div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="text-center custom-pro-edt-ds">
                                                    <button type="submit" class="btn btn-ctl-bt waves-effect waves-light m-r-10">Save
														</button>
                                                    <button type="button" class="btn btn-ctl-bt waves-effect waves-light">Discard
														</button>
                                                </div>
                                            </div>
                                        </div>
										{{Form::close()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('script')
	<script>
	async function getThumbnailForVideo(videoUrl,second) {
	  const video = document.createElement("video");
	  const canvas = document.createElement("canvas");
	  video.style.display = "none";
	  canvas.style.display = "none";

	  // Trigger video load
	  await new Promise((resolve, reject) => {
		video.addEventListener("loadedmetadata", () => {
		  video.width = video.videoWidth;
		  video.height = video.videoHeight;
		  canvas.width = video.videoWidth;
		  canvas.height = video.videoHeight;
		  // Seek the video to 25%
		  video.currentTime = video.duration * second;
		});
		video.addEventListener("seeked", () => resolve());
		video.src = videoUrl;
	  });

	  // Draw the thumbnailz
	  canvas
		.getContext("2d")
		.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
	  const imageUrl = canvas.toDataURL("image/png");
	  return imageUrl;
	}
	// Set up application
	// 
	$('div[class="thumbnail_image_div"]').hide();
	const img = document.querySelector("#img-thumb");
	const img1 = document.querySelector("#img-thumb-1");
	const img2 = document.querySelector("#img-thumb-2");
	const img3 = document.querySelector("#img-thumb-3");
	const fileInput = document.querySelector("#input-video-file");
	fileInput.addEventListener("change", async e => {
	  const [file] = e.target.files;
	  const fileUrl = URL.createObjectURL(file);
	  const thumbUrl = await getThumbnailForVideo(fileUrl,0.25);
	  const thumbUrl1 = await getThumbnailForVideo(fileUrl,0.50);
	  const thumbUrl2 = await getThumbnailForVideo(fileUrl,0.75);
	  const thumbUrl3 = await getThumbnailForVideo(fileUrl,1);
	  img.src = thumbUrl;
	  img1.src = thumbUrl1;
	  img2.src = thumbUrl2;
	  img3.src = thumbUrl3;
	  img.onload = function() {
		  if(this.width && this.height) {
			  $('div[class="col-md-3 form-group img-thumb-1"]').css('height',this.height/3).css('width',this.width/3);
		  }
	  }
	  img1.onload = function() {
		  if(this.width && this.height) {
			  $('div[class="col-md-3 form-group img-thumb-2"]').css('height',this.height/3).css('width',this.width/3);
		  }
	  }
	  img2.onload = function() {
		  if(this.width && this.height) {
			  $('div[class="col-md-3 form-group img-thumb-3"]').css('height',this.height/3).css('width',this.width/3);
		  }
	  }
	  img3.onload = function() {
		  if(this.width && this.height) {
			  $('div[class="col-md-3 form-group img-thumb-4"]').css('height',this.height/3).css('width',this.width/3);
		  }
	  }
	  $('div[class="thumbnail_image_div"]').show();
	});
	$(document).on("click",'input[name="thumb_image"]',function() {
		let image_src = $('img[id="'+$(this).data('value')+'"]').attr("src");
		$('input[name="video_thumb_image"]').val(image_src);
	});
	</script>
@endsection