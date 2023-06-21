<?php
class User {
    protected $dbs;

    public function __construct() {
        $this->dbs = new Database();
    }
    public function getAll() {

        $users = $this->dbs->all('usertbl');

        return $users;

    }

    public function create($formData) {
        $csrf_token = $formData['csrf_token'];

        if(!CsrfToken::validate($csrf_token)) {
            Semej::set('danger', 'Error', 'Missing CSRF Token');
            header('Location: dashboard.php?page=user-create');die;
        }
        
        $ncode = $formData['ncode'];

        $checkNcode = (count($this->dbs->select('usertbl', "ncode = '$ncode'")) > 0) ? true : false;
 
       if($checkNcode) {
        Semej::set('danger', 'error', "کد ملی تکراری است");
        header('Location: dashboard.php?page=user-create');die;
       }

        $phone = $formData['phone'];

        $checkPhone = (count($this->dbs->select('usertbl', "phone = '$phone'")) > 0) ? true : false;

       if($checkPhone) {
        Semej::set('danger', 'error', "شماره تلفن تکراری است");
        header('Location: dashboard.php?page=user-create');die;
       }
        $data = [
            "fullname" => $formData['fullname'],
            "phone" => $phone,
            "password" => $formData['password'],
            "ncode" => $ncode,
            "is_active" => (array_key_exists('is_active', $formData)) ? 1 : 0
        ];
        
        $result = $this->dbs->insert('usertbl', $data);

        if($result != 1) {
            Semej::set('danger', 'Error', 'Create user failed');
            header('Location: dashboard.php?page=user-create');die;
        }
        
        Semej::set('success', 'OK', 'User created successfully.');
        header('Location: dashboard.php?page=users');die;
    }

    public function edit($id) {
        $user  = $this->dbs->select('usertbl', "id = '$id'");
        return $user;
    }
    
    public function update($id, $formData) {

        $csrf_token = $formData['csrf_token'];

        if(!CsrfToken::validate($csrf_token)) {
            Semej::set('danger', 'Error', 'Missing CSRF Token');
            header('Location: dashboard.php?page=user-edit&user_id='.$id);die;
        }

        $user = $this->dbs->select('usertbl', "id = '$id'");

        $password = (strlen($formData['password']) == 0) ? $user[0]['password'] : $formData['password'];

        $data = [
            "fullname" => $formData['fullname'],
            "phone" => $formData['phone'],
            "password" => $password,
            "ncode" => $formData['ncode'],
            "is_active" => (array_key_exists('is_active', $formData)) ? 1 : 0
        ];

        $result = $this->dbs->update('usertbl', $data, "id = '$id'");
        if($result != 1) {
            Semej::set('danger', 'Error', 'update user failed');
            header('Location: dashboard.php?page=user-edit&user_id='.$id);die;
        }

        Semej::set('success', 'OK', 'User updated
         successfully.');
        header('Location: dashboard.php?page=users');die;
    }
    public function delete($id) {

        $this->dbs->delete('usertbl', "id = '$id'");
        Semej::set('success', 'OK', 'User Deleted Successfully.');
        header('Location: dashboard.php?page=users');die;

    }
    public function getUser($id) {
        $user = $this->dbs->select('usertbl', "id = $id");

        return $user[0];
    }
}