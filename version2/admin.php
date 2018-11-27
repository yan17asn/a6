<!DOCTYPE html>
<html>
    <head>
        <title>Administrator Page</title>
    </head>
<body>
    <h1>
        Guestbook Administrator Page
    </h1>
    <a href="./guestbook.php">GuestBook Sign Page</a>
    
    <hr>
    <?php 
    
    $errors = [];
    $admin_user = $admin_pwd = '';
    
    
    $username = password_hash("admin", PASSWORD_DEFAULT,['salt'=>'assignment4part2guestbook']);
    $password = password_hash("123456", PASSWORD_DEFAULT,['salt'=>'assignment4part2guestbook']);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        if(!empty($_POST['admin_user'])){
            $admin_user = $_POST['admin_user'];
            $user_hash = password_hash($admin_user, PASSWORD_DEFAULT,['salt'=>'assignment4part2guestbook']);
        }else{
            $errors[] = 'admin_user';
        }
        
        if(!empty($_POST['admin_pwd'])){
            $admin_pwd = $_POST['admin_pwd'];
            $pwd_hash = password_hash($admin_pwd, PASSWORD_DEFAULT,['salt'=>'assignment4part2guestbook']);
        }else{
            $errors[] = 'admin_pwd';
        }
        
        if ($user_hash == $username && $password == $pwd_hash) { 
               $myfile = fopen("guests.txt", "r");
    // Output until special "end of file" check returns true.
    while (!feof($myfile)) {
        echo fgets($myfile) . "<br>";
    }
    fclose($myfile);
    $admin_user = $admin_pwd = '';
             } else if(!empty($user_hash)&&!empty($pwd_hash)){  
              echo "Username or password incorrect"."<br>";
              }
        else{
            echo "Username and password can't be empty";
        }
    }
    ?>
    <hr>
    

<form method="post" action="admin.php">
        <p>
            <label for="admin_user">
                User: 
            </label>
            <input type="text" name="admin_user" value="<?php echo $admin_user ?>" />
            <?php if(in_array('admin_user', $errors)): ?>
            <br>
               <span style="color:red">Field is required.</span>
            <?php endif ?>
        </p>
        
        <p>
            <label for="admin_pwd">
                Password:
            </label>
            <input type="text" name="admin_pwd" value="<?php echo $admin_pwd ?>" />
            <?php if(in_array('admin_pwd', $errors)): ?>
            <br>
               <span style="color:red">Field is required.</span>
            <?php endif ?>
        </p>
            <button type="submit">
               Login
            </button>
        </p>
        
        
</form>
</body>
</html>
