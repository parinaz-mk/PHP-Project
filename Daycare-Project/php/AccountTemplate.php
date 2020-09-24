<?php 
	class Account {

        private $username;
		private $email;
        private $password;
		private $user_type;

        function __construct($username, $email, $password, $user_type){
                    $this->username = $username;
                    $this->email = $email;
					$this->password = $password;
					$this->user_type = $user_type;
                }

        public function getUsername(){
			return $this->username;
		}

		public function setUsername($username){
			$this->username = $username;
		}

		public function getEmail(){
			return $this->email;
		}

		public function setEmail($email){
			$this->email = $email;
		}

		public function getPassword(){
			return $this->password;
		}	

		public function setPassword($password){
			$this->password = $password;
		}

		public function getUser_type(){
			return $this->user_type;
		}

		public function setUser_type($user_type){
			$this->user_type = $user_type;
		}
    }
?>