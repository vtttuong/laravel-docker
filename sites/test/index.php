<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baitap</title>
    <style>
        .container {
            margin: 0px auto;
            width: 600px;
        }
    </style>
</head>
<?php
    $res = FALSE;
    $error = array();
    if (isset($_POST["submit"])) {
        $data['username'] = isset($_POST['username']) ? $_POST['username'] : '';
        $data['email'] = isset($_POST['email']) ? $_POST['email'] : '';
        $data['password'] = isset($_POST['password']) ? $_POST['password'] : '';
        $data['fileupload'] = isset($_FILES['fileupload']) ? $_FILES['fileupload'] : '';
        require('./validate.php');
        // print_r( $data['fileupload']);
  
        if (empty($data['username'])){
            $error['username'] = 'Bạn chưa nhập Username';
        }else if (!is_username($data['username'])){
            $error['username'] = 'Username không đúng định dạng';
        }
  
        if (!empty($data['email'])&&!is_email($data['email'])){
            $error['email'] = 'Email không đúng định dạng';
        }
    
        if (empty($data['password'])){
            $error['password'] = 'Bạn chưa nhập password';
        }else if (!is_password($data['password'])){
            $error['password'] = 'Password không đúng định dạng';
        }

        if (empty($data['fileupload'])){
            $error['fileupload'] = 'Bạn chưa nhập upload ảnh';
        }else if (!is_image($data['fileupload'])){
            $error['fileupload'] = 'fileupload không đúng định dạng';
        }

        // Lưu dữ liệu
        if (!$error){
            $res = TRUE;

            if (file_exists('info.csv'))
            {
                $fp = fopen('info.csv', 'a'); 
                $output= array(
                    $data['username'],
                    md5($data['password']),
                    $data['email'],
                    'uploads/' . basename($data['fileupload']['name'])
                );
                fputcsv($fp, $output); 
                fclose($fp); 
            }
            else
            {
                // Tạo file csv mới với header 
                $fp = fopen('info.csv', 'w'); 
                $header= array(
                    'username',
                    'password',
                    'email',
                    'url avatar'
                );
                fputcsv($fp,$header);
                //Thêm row dữ liệu đầu vào
                $output= array(
                    $data['username'],
                    md5($data['password']),
                    $data['email'],
                    'uploads/' . basename($data['fileupload']['name'])
                );
                fputcsv($fp, $output); 
                fclose($fp); 
            }
        }
        else{
            //echo 'Dữ liệu bị lỗi, không thể lưu trữ';
        }
    }
?>
<body>
    <div class="container">   
    <?php
        if (isset($_POST["submit"]))
        {
            if ($res==FALSE){
                echo "<p style='color:red;'> Dữ liệu bị lỗi</p>";
            }

        }
    ?>
    <div class="form">
        <form action="" method="post" enctype="multipart/form-data">
        <p>Username: <input type="text" name="username" id="username">
        <?php
        if (isset($_POST["submit"])&&$res==FALSE&&isset($error['username']))
        {
            echo "<span style='color:red;margin-left:47px;'>".$error['username']."</span>";
        }
        ?>
        </p>
        <p>Password: <input type="password" name="password" id="name" style="margin-left:3px;">
        <?php
        if (isset($_POST["submit"])&&$res==FALSE&&isset($error['password']))
        {
            echo "<span style='color:red;margin-left:47px;'>".$error['password']."</span>";
        }
        ?>
        </p>
        <p>Email: <input type="mail" name="email" id="email" style="margin-left:26px;">
        <?php
        if (isset($_POST["submit"])&&$res==FALSE&&isset($error['email']))
        {
            echo "<span style='color:red;margin-left:47px;'>".$error['email']."</span>";
        }
        ?>
        </p>
        <p>Avatar: <input type="file" name="fileupload" id="fileupload" style="margin-left:22px;">
        <?php
        if (isset($_POST["submit"])&&$res==FALSE&&isset($error['fileupload']))
        {
            echo "<span style='color:red;margin-left:-30px;'>".$error['fileupload']."</span>";
        }
        ?>
        </p>
        <p><input type="submit" name="submit" value="Register"></p>
        </form>
    </div>
    <?php
        if (isset($_POST["submit"]))
        {
            if ($res==TRUE){
                echo "<p style='color:green;'>Register successfully</p>";
           
    ?>
    <table border="2" cellspacing="0" cellpadding="5">
        <tr>
            <th>User Name</th>
            <th>Password</th>
            <th>Email</th>
            <th>Avatar</th>
        </tr>
        <tr>
            <td><?php echo $data['username']?></td>
            <td><?php 
                $s = '';
                for ($i=1;$i<=strlen($data['password']);++$i){
                    $s = $s.'*'; 
                }
                echo $s;?></td>
            <td><?php echo $data['email']?></td>
            <td>
                <img src="<?php 
                   $target_dir    = "uploads/";
                   $target_file   = $target_dir . basename($_FILES["fileupload"]["name"]);
                    echo $target_file?>" style="width;60px;height:80px; " alt="" >
            </td>
        </tr>
    </table>

    <?php
            }
        }
    ?>
    </div>
</body>
</html>