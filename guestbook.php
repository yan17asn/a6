<!DOCTYPE html>
<html>
    <head>
        <title>GuestBook</title>
    </head>
<body>
    <h1>
        GuestBook
    </h1>
    
    <hr>
    <?php 
    
$servername = "mysql.yanr.dreamhosters.com";
$username = "yan17asn";
$password = "123456asd";
$dbname = "yandb";
 
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
 
$sql = "SELECT _id, name, tel, email FROM A6";
$result = $conn->query($sql);
 
if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["_id"]. "Name: " . $row["name"]. "tel: " . $row["tel"]. "email: " . $row["email"]."<br>";
    }
} else {
    echo "0 结果";
}

    
        //Track fields with errors
        $errors = [];
    //Only process on submit
    
    $guest_name = $guest_email = $guest_tel = $message = '';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!empty($_POST['guest_name'])){
           $guest_name = $_POST['guest_name'];   
        }
        else{
            
            $errors[] = 'guest_name';
        }
        
        if(isset($_POST['guest_email'])){
            $guest_email = $_POST['guest_email'];
            if(!filter_var($guest_email, FILTER_VALIDATE_EMAIL)){
                $errors[] = 'guest_email';
            }
        }else{
            $errors[] = 'guest_email';
        }
        
         if(isset($_POST['guest_tel'])){
            $guest_tel = $_POST['guest_tel'];
            if( !is_numeric($guest_tel)||$guest_tel<1000000000){
                $errors[] = 'guest_tel';
            }
        }else{
            $errors[] = 'guest_tel';
        }
        
        if(isset($_POST['message'])){
            $message = $_POST['message'];
        }
        
        if(count($errors) > 0){
            echo"<strong style='color:red'>Fix the errors.</strong>";
            echo "<ul>";
            foreach($errors as $error){
                echo"<li>Required field: $error</li>";
            }
            echo"</ul>";
        }else{
        
        $sql = "INSERT INTO A6 (name, tel, email)
VALUES ('$guest_name','$guest_tel','$guest_email')";
 
if ($conn->query($sql) === TRUE) {
    echo "New record added";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
        
        echo"<strong>Thank you, $guest_name.</strong>";
        $guest_name = $guest_email = $guest_tel = $message = '';
        
        }
        
    }
       
    $conn->close();
    ?>
    <hr>
    
    <h3>
        Sign the Guestbook
    </h3>
    <em>
        * fields are required
    </em>
    <form method="post" action="guestbook.php">
        <p>
            <label for="quest_name">
                Enter your name:*
            </label>
            <input type="text" name="guest_name" value="<?php echo $guest_name ?>" />
            <?php if(in_array('guest_name', $errors)): ?>
            <br>
               <span style="color:red">Field is required.</span>
            <?php endif ?>
        </p>
        
        <p>
            <label for="quest_tel">
                Enter your tel-number:*
            </label>
            <input type="text" name="guest_tel" value="<?php echo $guest_tel ?>" />
            <?php if(in_array('guest_tel', $errors)): ?>
            <br>
               <span style="color:red">Valid number is required.</span>
            <?php endif ?>
        </p>
        
        <p>
            <label for="guest_email">
                Enter a valid email:*
            </label>
            <input type="text" name="guest_email" value="<?php echo $guest_email ?>">
            <?php if(in_array('guest_email',$errors)): ?>
            <br>
               <span style="color:red">Valid email is required.</span>
            <?php endif ?>
        </p>
        
        <p>
            <label for="message">
                Please enter a message:
            </label>
            <br>
            <textarea name="message"><?php echo $message ?></textarea>
        </p>
        <p>
            <button type="submit">
                Sign Guestbook
            </button>
        </p>
        <a href="http://yanr.dreamhosters.com/a4/guests.txt">View txt file</a>
                
    </form>
</body>
</html>
