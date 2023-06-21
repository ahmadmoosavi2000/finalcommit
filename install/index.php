<?php
include_once 'install.php';

if(isset($_POST['create']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $database-> createdb();
    $database-> createtbl();
}
?>
<!DOCTYPE html>
<html dir="rtl">
<head>
	<title>SignUp & login</title>
	<link rel="stylesheet" type="text/css" href="slide navbar style.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
<link href="../assets/css1/style.css" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>	
	<div class="signup">
    <form method='POST' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?>">
			<input class="button" type="submit" value="ساخت DataBase" name='create'>
		</form>
	</div>
</body>
</html>