<?php

class Auth{

    protected $dbs;

    public function __construct() {
        $this->dbs = new Database();
    }

    public function register($formData) {

        $csrf_token = $formData['csrf_token'];

        if(!CsrfToken::validate($csrf_token)) {
            Semej::set('danger', 'error', "Missing CSRF Token.");
            header('Location: register.php');die;
        }
        
        if($formData['pass'] != $formData['Cpass']) {
            Semej::set('danger', 'error', "رمز عبور یکسان نیست");
            header('Location: register.php');die;
        }

        $ncode = $formData['ncode'];

        $checkNcode = (count($this->dbs->select('usertbl', "ncode = '$ncode'")) > 0) ? true : false;
 
       if($checkNcode) {
        Semej::set('danger', 'error', "کد ملی تکراری است");
            header('Location: register.php');die;
       }

        $phone = $formData['phone'];

        $checkPhone = (count($this->dbs->select('usertbl', "phone = '$phone'")) > 0) ? true : false;

       if($checkPhone) {
        Semej::set('danger', 'error', "شماره تلفن تکراری است");
            header('Location: register.php');die;
       }
       
       $password = $formData['pass'];

       $data = [
        'fullname' => $formData['fname'],
        'ncode' => $ncode,
        'phone' => $phone,
        'password' => $password
       ];


       $result = $this->dbs->insert('usertbl', $data);

       if($result != 1) {
            Semej::set('danger', 'error', "ثبت نام انجام نشد (دوباره تلاش کنید)");
            header('Location: index.php');die;
       }

       Semej::set('success', 'OK', "ثبت نام انجام شد");
       header('Location: login.php');die;
    }


    public function login($data) {
        $csrf_token = $data['csrf_token'];

        if(!CsrfToken::validate($csrf_token)) {
            Semej::set('danger', 'error', "Missing CSRF Token.");
            header('Location: login.php');die;
        }

        $username = $data['username'];
        $password = $data['Lpass'];
        $user = $this->dbs->select("usertbl", "ncode = '$username'OR phone = '$username'");

        if(count($user) == 0) {
            Semej::set('danger', 'error', "نام کاربری نامعتبر");
            header('Location: login.php');die;
        }
        
        if($user[0]['password'] != $password) {
            Semej::set('danger', 'error', "   رمز عبور نامعتبر");
            header('Location: login.php');die;
        }

        $user = $user[0];

        $_SESSION['auth_user'] = [
            "fullname" => $user['fullname'],
            "ncode" => $user['ncode'],
            "id" => $user['id']
        ];

        // generate auth token
        $token = $this->generateToken($user['ncode']);

        $_SESSION['auth_token'] = $token;

        header('Location: dashboard.php');die;
        
    }

    protected function generateToken($user) {
        $remote_addr = $_SERVER['REMOTE_ADDR'];
        $token = sha1(SALT.$remote_addr.$user);
        return $token;
    }

    public function validateToken() {
        if(!isset($_SESSION)) {
            return false;
        }

        if(!isset($_SESSION['auth_user']) || !isset($_SESSION['auth_token'])) {
            return false;
        }

        $ncode = $_SESSION['auth_user']['ncode'];
        $token = $_SESSION['auth_token'];

        $generated_token = $this->generateToken($ncode);

         if($token != $generated_token) {
             return false;
         }

         return true;
    }

     public function logout() {
         session_unset();
         session_destroy();
     }
}