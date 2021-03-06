<!DOCTYPE html>
<html lang="en">
<head>
	<title>MMS - LOGIN</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/login_util.css">
	<link rel="stylesheet" type="text/css" href="css/login_main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-l-50 p-r-50 p-t-52 p-b-33">
				<form class="login100-form flex-sb flex-w" method="POST" action="{{ url('users/login_auth') }}">
					@csrf
					<span class="login100-form-title p-b-53">
						MIT Management System
					</span>
					
					<div class="p-t-31 p-b-9">
						<span class="txt1">Employee Number</span>
						@if ($errors->has('txt_employee_number'))
							<div class="alert alert-danger">
								<strong>Required! </strong> {{ $errors->first('txt_employee_number') }}
							</div>
						@endif
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Username is required">
						<input class="input100" type="text" name="txt_employee_number" id="txt_employee_number" autocomplete="off">
						<span class="focus-input100"></span>
					</div>
					
					<div class="p-t-13 p-b-9">
						<span class="txt1">Password</span>
						@if ($errors->has('txt_password'))
							<div class="alert alert-danger">
								<strong>Required! </strong> {{ $errors->first('txt_password') }}
								</div>
						@endif
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="txt_password" id="txt_password" >
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn m-t-17">
						<button class="login100-form-btn" type="submit">Sign In</button>
					</div>
					<br><br>
					<span> Forgot Password? 
					<a href="#" class="txt3" data-toggle="modal" data-target="#modal_forgot_password">
							Click Here
						</a>
					</span>
			

					<div class="w-full text-center p-t-55">
						<span class="txt2">
							<i clas="fa fa-fw fa-copyright"></i>2019 MMS - JOYSON
						</span>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Modal -->
<div class="modal fade" id="modal_forgot_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="p-t-20 p-b-9">
			<span class="txt1">
				Forgot Password
			</span>
		</div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<div class="wrap-input100 validate-input" data-validate = "Please input Email Address">
					<span class="email-envelope">
							<i class="fa fa-envelope-o"></i>
						</span>
				<input class="input100" type="text" name="txt_forgot_password_email" id="txt_forgot_password_email" placeholder="Input you Email" autocomplete="off">
				<span class="focus-input100"></span>
			</div>
      </div>
      <div class="modal-footer">
        <div class="container-login100-form-btn m-t-17">
			<button class="login100-form-btn">
				Send to Email
			</button>
		</div>
      </div>
    </div>
  </div>
</div>

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/login_main.js"></script>

</body>
</html>