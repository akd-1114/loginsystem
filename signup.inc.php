<?php
 if(isset($_POST['submit']))
 {
     include_once 'conn.php';
    $first=mysqli_real_escape_string($conn,$_POST['first']);
    $last=mysqli_real_escape_string($conn,$_POST['last']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $uid=mysqli_real_escape_string($conn,$_POST['uid']);
    $pwd=mysqli_real_escape_string($conn,$_POST['pwd']);
    if(empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd))
    {
        header("Location: signup.php?signup=empty");
        exit(); 
    }
    else
    {
       if(!preg_match("/^[a-zA-Z]*$/",$first)||!preg_match("/^[a-zA-Z]*$/",$last))
       {
        header("Location: signup.php?signup=invalid");
        exit(); 
       }
       else
       {
          if(!filter_var($email,FILTER_VALIDATE_EMAIL))
          {
            header("Location: signup.php?signup=email");
            exit();
          }
          else
          {
            $sql="select * from users where u_uid='$uid'";
            $result=mysqli_query($conn,$sql);
            $resultcheck=mysqli_num_rows($result);
            if($resultcheck>0)
            {
                header("Location:signup.php?signup=usertaken");
            exit();
            }
            else
            {
                $hashedpwd=password_hash($pwd,PASSWORD_DEFAULT);
               $sql="insert into users (u_first,u_last,u_email,u_uid,u_pwd) values ('$first','$last','$email','$uid','$hashedpwd')";
               $result=mysqli_query($conn,$sql);
               if(!$result)
               echo "something wrong";
               else
               {
               header("Location: signup.php?signup=success");
               exit();
               }
            }
          }
       }
    }
 }
 else
 {
     header("Location: signup.php");
     exit();
 }
?>