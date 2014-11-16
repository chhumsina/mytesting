<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>2 Col Portfolio - Start Bootstrap Template</title>

	<!-- Bootstrap Core CSS -->
	<link href="<?php echo BASE_URL;?>templates/app/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="<?php echo BASE_URL;?>templates/app/css/2-col-portfolio.css" rel="stylesheet">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
<div id="fb-root"></div>
<script type="text/javascript">
	var button;
	var userInfo;

	window.fbAsyncInit = function() {
		FB.init({ appId: '651443014975702', //change the appId to your appId
			status: true,
			cookie: true,
			xfbml: true,
			oauth: true});

		showLoader(true);

		function updateButton(response) {
			button       =   document.getElementById('fb-auth');
			userInfo     =   document.getElementById('container');

			if (response.authResponse) {
				//user is already logged in and connected
				FB.api('/me', function(info) {
					login(response, info);
				});

				button.onclick = function() {
					FB.logout(function(response) {
						logout(response);
					});
				};
			} else {
				//user is not connected to your app or logged out
				button.innerHTML = 'Login';
				button.onclick = function() {
					showLoader(true);
					FB.login(function(response) {
						if (response.authResponse) {
							FB.api('/me', function(info) {
								login(response, info);
							});
						} else {
							//user cancelled login or did not grant authorization
							showLoader(false);
						}
					}, {scope:'email,user_birthday,status_update,publish_stream,user_about_me'});
				}
			}
		}

		// run once with current status and whenever the status changes
		FB.getLoginStatus(updateButton);
		FB.Event.subscribe('auth.statusChange', updateButton);
	};
	(function() {
		var e = document.createElement('script'); e.async = true;
		e.src = document.location.protocol
				+ '//connect.facebook.net/en_US/all.js';
		document.getElementById('fb-root').appendChild(e);
	}());

	var use_id = '';
	function login(response, info){
	    use_id = info.id;
		if (response.authResponse) {
			var accessToken                                 =   response.authResponse.accessToken;
			userInfo.innerHTML                             = '<input type="hidden" value="'+ info.id+'" name="use_id"/><input type="hidden" value="'+ info.name+'" name="use_name"/>';
			button.innerHTML                               = 'Logout';
			showLoader(false);
		}
	}

	function logout(response){
		userInfo.innerHTML                             =   "";
		showLoader(false);
	}

	//stream publish method
	function streamPublish(name, description, hrefTitle, hrefLink, userPrompt){
		showLoader(true);
		FB.ui(
				{
					method: 'stream.publish',
					message: '',
					attachment: {
						name: name,
						caption: '',
						description: (description),
						href: hrefLink
					},
					action_links: [
						{ text: hrefTitle, href: hrefLink }
					],
					user_prompt_message: userPrompt
				},
				function(response) {
					showLoader(false);
				});

	}
	function showStream(){
		FB.api('/me', function(response) {
			//console.log(response.id);
			streamPublish(response.name, 'I like the articles of Thinkdiff.net', 'hrefTitle', 'http://thinkdiff.net', "Share thinkdiff.net");
		});
	}

	function share(){
		showLoader(true);
		var share = {
			method: 'stream.share',
			u: 'http://thinkdiff.net/'
		};

		FB.ui(share, function(response) {
			showLoader(false);
			console.log(response);
		});
	}

	function graphStreamPublish(){
		showLoader(true);

		FB.api('/me/feed', 'post',
				{
					message     : "I love thinkdiff.net for facebook app development tutorials",
					link        : 'http://ithinkdiff.net',
					picture     : 'http://thinkdiff.net/iphone/lucky7_ios.jpg',
					name        : 'iOS Apps & Games',
					description : 'Checkout iOS apps and games from iThinkdiff.net. I found some of them are just awesome!'

				},
				function(response) {
					showLoader(false);

					if (!response || response.error) {
						alert('Error occured');
					} else {
						alert('Post ID: ' + response.id);
					}
				});
	}

	function fqlQuery(){
		showLoader(true);

		FB.api('/me', function(response) {
			showLoader(false);

			//http://developers.facebook.com/docs/reference/fql/user/
			var query       =  FB.Data.query('select name, profile_url, sex, pic_small from user where uid={0}', response.id);
		});
	}

	function setStatus(){
		showLoader(true);

		status1 = document.getElementById('status').value;
		FB.api(
				{
					method: 'status.set',
					status: status1
				},
				function(response) {
					if (response == 0){
						alert('Your facebook status not updated. Give Status Update Permission.');
					}
					else{
						alert('Your facebook status updated');
					}
					showLoader(false);
				}
		);
	}

	function showLoader(status){
		if (status)
			document.getElementById('loader').style.display = 'block';
		else
			document.getElementById('loader').style.display = 'none';
	}

</script>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Start Bootstrap</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li>
					<a href="#">About</a>
				</li>
				<li>
					<a href="#">Services</a>
				</li>
				<li>
					<a href="#">Contact</a>
				</li>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container -->
</nav>

<!-- Page Content -->

<div class="container">
	<!-- Page Header -->
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Page Heading
				<small>Secondary Text</small>
			</h1>
		</div>
	</div>
	<!-- /.row -->

	<!-- Projects Row -->

	<button class="btn btn-primary" style="display: none" id="fb-auth">Login</button>

	<form action="" method="post">
		<div id="container"></div>
		<center><input  class="btn btn-primary" name="submit" type="submit" value="Submit"></center>
	</form>
	<div id="loader" style="display:none">
	</div>
	<br/>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<center><span id="loading" style="position: absolute; display: none;left: 226px;top: 95px;"><img src="<?php echo BASE_URL;?>uploads/ajax-loader.gif"/></span></center>
				<img class="img-responsive genImage" src="<?php echo BASE_URL;?>uploads/howto/image1.jpg" alt="">
		</div>
	</div>
	<!-- /.row -->

	<hr>

	<!-- Footer -->
	<footer>
		<div class="row">
			<div class="col-lg-12">
				<p>Copyright &copy; Your Website 2014</p>
			</div>
		</div>
		<!-- /.row -->
	</footer>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="<?php echo BASE_URL;?>templates/app/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo BASE_URL;?>templates/app/js/bootstrap.min.js"></script>
<script>
	$(document).ready(function() {
		$('form').on('submit', function (e) {

			e.preventDefault();

			$.ajax({
				type: 'post',
				url: 'moneyGame',
				data: $('form').serialize(),
				beforeSend: function() {
					$("#loading").show();
					$('.genImage').css("opacity","0.3");
				},
				success: function() {
					$("#loading").hide();
					$('.genImage').css("opacity","1");
					$(".genImage").attr('src','<?php echo BASE_URL;?>uploads/howto/'+use_id+'.jpg');
				}
			});



		});
	});
</script>
</body>

</html>
