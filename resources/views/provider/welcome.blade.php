@extends('layout.app')

@section('content')

      <section class="banner-section">
         <div class="container">
            <div class="verify-id-number-col">
               <p class="text-uppercase identify-p">Verify Identity & Status For</p>
               <h1 class="verify-heading text-uppercase mb-4">Law Enforcement <span class="text-white">Agency.</span> Us Customs <span class="text-white">Border Protection!</span></h1>
               <p class="text-white mb-4">If you  are US Law Enforcement Agent, enter cardholder identification number to verify status.</p>
               <form class="mb-5">
                  <div class="form-field-custom">
                     <input type="text" name="client" placeholder="ID Number">
                     <button type="submit" formaction="search-result"
                      class="custom-button text-uppercase">Verify</button>
                  </div>
               </form>
            </div>
         </div>
      </section>
      <section class="images-gallery-col mt-5" >
         <div class="container">
            <div class="row">
               <div class="col-md-4 col-sm-6">
                  <div class="inner-img-gallery">
                     <h3 class="image-heading"><img src="images/ic_flag.png" align="flag" width="30px"> <span class="color-primary-custom">H-1B</span>Update</h3>
                     <div class="gallery-img-single">
                        <img src="images/gallery-1.jpg" align="image" class="img-fluid">
                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div class="inner-img-gallery">
                     <h3 class="image-heading"><img src="images/ic_flag.png" align="flag" width="30px"> <span class="color-primary-custom">Somalia</span>Extended</h3>
                     <div class="gallery-img-single">
                        <img src="images/gallery-2.jpg" align="image" class="img-fluid">
                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div class="inner-img-gallery">
                     <h3 class="image-heading"><img src="images/ic_flag.png" align="flag" width="30px"> <span class="color-primary-custom">Previous Forms</span>Update</h3>
                     <div class="gallery-img-single">
                        <img src="images/gallery-3.jpg" align="image" class="img-fluid">
                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div class="inner-img-gallery">
                     <h3 class="image-heading"><img src="images/ic_flag.png" align="flag" width="30px"> <span class="color-primary-custom">Previous Forms</span>Update</h3>
                     <div class="gallery-img-single">
                        <img src="images/gallery-3.jpg" align="image" class="img-fluid">
                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div class="inner-img-gallery">
                     <h3 class="image-heading"><img src="images/ic_flag.png" align="flag" width="30px"> <span class="color-primary-custom">Somalia</span>Extended</h3>
                     <div class="gallery-img-single">
                        <img src="images/gallery-2.jpg" align="image" class="img-fluid">
                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div class="inner-img-gallery">
                     <h3 class="image-heading"><img src="images/ic_flag.png" align="flag" width="30px"> <span class="color-primary-custom">H-1B</span>Update</h3>
                     <div class="gallery-img-single">
                        <img src="images/gallery-1.jpg" align="image" class="img-fluid">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
     

@endsection


@section('script')

@if(Session::has('invalid_login'))
<script>
		$(document).ready( function () {
			$('#example_login_model').click();
			// alert('wwwwwwww');
		});
	  </script>
@endif

@endsection
