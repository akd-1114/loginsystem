<?php

session_start();
  if(isset($_POST['submit']))
{
      include_once 'conn.php';
      $uid=mysqli_real_escape_string($conn,$_POST['uid']);
    $pwd=mysqli_real_escape_string($conn,$_POST['pwd']);
    if(empty($uid)||empty($pwd))
    {
        header("Location: index.php?login=empty");
        exit();
    }
    else
    {
       $sql="select * from users where u_uid='$uid' or u_email='$uid'";
       $result=mysqli_query($conn,$sql);
       $resultcheck=mysqli_num_rows($result);
       if($resultcheck<1)
       {
        header("Location: index.php?login=invalid");
        exit();
       }
       else
       {
          if($rows=mysqli_fetch_assoc($result))
           {
               $hashedpwdcheck=password_verify($pwd,$rows['u_pwd']);
               if($hashedpwdcheck==false)
               {
                    header("Location: index.php?login=error");
                     exit();
               }
               elseif($hashedpwdcheck==true)
               {
                   $_SESSION['u_id']=$rows['u_id'];
                   $_SESSION['u_first']=$rows['u_first'];
                   $_SESSION['u_last']=$rows['u_last'];
                   $_SESSION['u_uid']=$rows['u_uid'];
                   $_SESSION['u_pwd']=$rows['u_pwd'];
                   header("Location: index.php?login=success");
                   exit();
               }
           }
       }
    }
}
  else
{
    header("Location: index.php?login=somethingerror");
    exit();
}
?>