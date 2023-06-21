<?php
include_once 'autoload.php';

if(isset($_POST['login_btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = Sanitizer::sanitize($_POST['frm']);
    
    $auth = new Auth();
    $auth->login($data);
}
if(isset($_POST['signup']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    
    header('Location: register.php');die;

}
?>

<!DOCTYPE html>
<html dir="rtl">
<head>
	<title>SignUp & login</title>
	<link rel="stylesheet" type="text/css" href="slide navbar style.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
<link href="./assets/css1/style.css" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php Semej::alert(); ?>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
            	<form method='POST' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?>">
					<input type="hidden" name="frm[csrf_token]" value="<?php echo CsrfToken::generate(); ?>">
						<label for="chk" aria-hidden="true">ورود</label>
						<input type="number" name="frm[username]" placeholder="نام کاربری(موبایل یا کدملی)" required="">
						<input type="password" name="frm[Lpass]" placeholder="رمز عبور" required="">
          				<input class="button" type="submit" value="ورود" name='login_btn'>
						  
				</form>
				<form method='POST' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?>">
				<input class="button" type="submit" value="صفحه ثبت نام" name='signup'>
			</form>
			</div>
	</div>
</body>
</html>