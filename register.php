<?php
include_once 'autoload.php';

if(isset($_POST['signup_btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = Sanitizer::sanitize($_POST['frm']);
    
    $auth = new Auth();
    $auth->register($formData);
}
if(isset($_POST['log']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: login.php');die;
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
		<div class="signup">
      		<form method='POST' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?>">
	  			<input type="hidden" name="frm[csrf_token]" value="<?php echo CsrfToken::generate(); ?>">    
      			<label for="chk" aria-hidden="true">ثبت نام</label>
				<input type="text" name="frm[fname]" placeholder="نام و نام خانوادگی" required="">
          		<input type="number" name="frm[ncode]" placeholder="کد ملی" required="">
				<input type="number" name="frm[phone]" placeholder="موبایل" required="">
				<input type="password" name="frm[pass]" placeholder="رمز عبور" required="">
				<input type="password" name="frm[Cpass]" placeholder="تکرار رمز عبور" required="">
				<input class="button" type="submit" value="ثبت نام" name='signup_btn'>
			</form>
			<form method='POST' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?>">
				<input class="button" type="submit" value="صفحه ورود" name='log'>
			</form>
		</div>
	</div>
</body>
</html>