@extends('layout.app')

@section('content')
      <div id="hero">
			<div class="q-container">
				<div class="box-join simple-half">
					<h2 class="section-headline inverted"><span>VERIFY IDENTITY & STATUS for</span>LAW ENFORCEMENT <em>AGENCY</em>.<br>US CUSTOMS <em>Border Protection</em>!</h2>

					<p>If you are US Law Enforcement Agent, enter cardholder identification number to verify status.</p>
					<form class="mb-5">
					  <div class="form-field-custom">
						 <input type="text" name="client" placeholder="ID Number">
						 <button type="submit" formaction="search-result"
						  class="custom-button text-uppercase">Verify</button>
					  </div>
					  @if(Session::has('invaid_cient'))
						<p class="text-danger">{{Session::get('invaid_cient')}}</p>
					  @endif
				   </form>
				</div>
			</div>
		</div>
      <!-- Start: Main -->
      <main id="main">
			<!-- Start: Article Grid -->
			<div class="section article-grid">
				<div class="q-container">
					<div class="q-row">
						<article class="q-col-1-3 wow animated fadeInUp" data-wow-offset="100" data-wow-duration="1s">
							<div class="article-headline"><h3 class="sub-headline deco-headline"><a href="page-wide.php#demo-tabs-hor1">H-1B <span>UPDATE</span></a></h3></div>
							<div class="article-summary">
								<div class="article-image"><a href="#"><img src="assets/img/news-pic-worker.png" alt="Better Jobs"></a></div>
								<p> U.S. Citizenship and Immigration Services will begin accepting H-1B petitions subject to the fiscal year 2018 cap on April 3, 2017. All cap-subject H-1B petitions filed before April 3, 2017, for the FY 2018 cap will be rejected.</p>
								<p><a href="https://www.uscis.gov/news/news-releases/uscis-will-accept-h-1b-petitions-fiscal-year-2018-beginning-april-3" class="button">Find Out More</a></p>
							</div>
						</article>
						<article class="q-col-1-3 wow animated fadeInUp" data-wow-offset="200" data-wow-duration="1s">
							<div class="article-headline"><h3 class="sub-headline deco-headline"><a href="#">SOMALIA <span>EXTENDED</span></a></h3></div>
							<div class="article-summary">
								<div class="article-image"><a href="#"><img src="assets/img/news-pic-somalia.png" alt="Better Health"></a></div>
								<p> Secretary of Homeland Security Jeh Johnson has extended Temporary Protected Status (TPS) for eligible nationals of Somalia (and eligible individuals without nationality who last habitually resided in Somalia) for an additional 18 months, effective March 18, 2017, through Sept. 17, 2018.</p>
								<p><a href="https://www.uscis.gov/news/temporary-protected-status-extended-somalia-0" class="button">Find Out More</a></p>
							</div>
						</article>
						<article class="q-col-1-3 wow animated fadeInUp" data-wow-offset="300" data-wow-duration="1s">
							<div class="article-headline"><h3 class="sub-headline deco-headline"><a href="#">PREVIOUS FORMS <span>UPDATE</span></a></h3></div>
							<div class="article-summary">
								<div class="article-image"><a href="#"><img src="assets/img/news-immigration-forms.png" alt="News - Forms"></a></div>
								<p>When new fees for most USCIS forms went into effect on December 23, 2016, we published updated versions of the forms at uscis.gov/forms. We strongly encourage customers to submit these new versions, which are updated with the new fees and have an edition date of 12/23/16. </p>
								<p><a href="https://www.uscis.gov/news/alerts/previous-editions-forms-accepted-until-feb-21-2017-must-include-new-fees" class="button">Find Out More</a></p>
							</div>
						</article>
					</div>
				</div>
			</div>
			<!-- End: Article Grid -->

			<!-- Start: Social Updates -->
			<div class="section social-updates">
				<div class="q-container">
					<div class="q-row">
						<div class="q-col-1-3">
							<h2 class="section-headline wow animated fadeInLeft" data-wow-offset="100" data-wow-duration="0.5s"><span>The USCIS in</span>Social Media</h2>
							<ul class="social-profiles">
								<li><a href="http://facebook.com/uscis" class="social-button social-facebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
								<li><a href="http://www.twitter.com/uscis" class="social-button social-twitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
							</ul>
						</div>
						<div class="q-col-2-3 wow animated fadeInUp" data-wow-duration="0.5s" data-wow-offset="200">
							<div id="social-slider" class="simple-slider">
								<div class="simple-slide">
									<div class="social-update">California is the first state to ever reach a trillion dollar economy in gross state product. <a href="#">#USpride</a></div>
									<p class="social-update-info"><a href="#">1 day ago</a> on Twitter via <a href="#">@uscis</a></p>
								</div>
								<div class="simple-slide">
									<div class="social-update">Washington is the second state to ever reach a trillion dollar economy in gross state product. <a href="#">#USpride</a></div>
									<p class="social-update-info"><a href="#">1 day ago</a> on Twitter via <a href="#">@uscis</a></p>
								</div>
								<div class="simple-slide">
									<div class="social-update">Oregon is the third state to ever reach a trillion dollar economy in gross state product. <a href="#">#USpride</a></div>
									<p class="social-update-info"><a href="#">1 day ago</a> on Twitter via <a href="#">@uscis</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End: Social Updates -->
			
		</main>
	  
	  



     

@endsection


@section('script')

@endsection
