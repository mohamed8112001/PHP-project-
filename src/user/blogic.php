<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once('database.php');

class User extends Database{ 

    public function getAllRooms()
    {
        return $this->select('room');
    }
    public function getAllUsers()
    {
        return $this->select('user');
    }

    // function insertTrainee($name, $email, $password, $image_path, $room_id) {
    //     try {
    //         $pdo = connectDB();
    
    //         $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    //         $stmt = $pdo->prepare("INSERT INTO trainees (name, email, password, image_path, room_id) 
    //                                VALUES (:name, :email, :password, :image_path, :room_id)");
    //         $stmt->bindParam(':name', $name);
    //         $stmt->bindParam(':email', $email);
    //         $stmt->bindParam(':password', $hashed_password);
    //         $stmt->bindParam(':image_path', $image_path);
    //         $stmt->bindParam(':room_id', $room_id);
    //         $stmt->execute();
    
    //         return "Done";
    //     } catch (PDOException $e) {
    //         return "error " . $e->getMessage();
    //     }
    // }
    // public function update($tablename,$data,$condition)
    // {
        
    // }

        public function updateUser()
        {

        }
    public function insertCustomer($name,$email,$password,$Profile_Picture,$room_no)
{
	$password_hash = password_hash($password, PASSWORD_DEFAULT);
	// $values=array($name, $email, $password_hash, $ext, $role, $room_id, $pic_path);
	// $columns=array("name", "email", "password", "ext", "role", "room_id", "image_path"); 
	$res = $this->insert('user',['name','email','password','image_path','room_id'],[$name,$email,$password,$Profile_Picture,$room_no]);
}


    // public function insertAllTrainees($name,$email,$password,$Profile_Picture,$room_no)
    // {
    //     $res = $this->insert('user',['name','email','password','image_path','room_id'],[$name,$email,$password,$Profile_Picture,$room_no]);
    // }
    // public function insertRoom($number=1000,$ext=1000)
    // {
    //     // $res = $this->insert('room',['number','ext'],[$number,$ext]);
    // }
}
?>


