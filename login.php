<?php
session_start();
//接收变量
$username = $_POST['username'];
$pwd = $_POST['pwd'];
//链接数据库
$host = '127.0.0.1';
$port = 3306;
$user = 'root';
$pass = 'root';
$db = 'ajx';
$mysqli = new mysqli($host, $user, $pass, $db, $port);
//查询用户是否存在
$sql = "select * from user where account='$username' || mobile = '$username' || email = '$username'";
$res = $mysqli->query($sql);
$data = $res->fetch_assoc();
if (!empty($data)) {
    //验证密码
    if (password_verify($pwd, $data['pwd'])) {       //密码正确 登录成功
        //发送cookie
        setcookie('username', $data['account'], time() + 86400 * 7);
        setcookie('uid', $data['id'], time() + 86400 * 7);

        //设置session
        $_SESSION['username'] = $data['account'];
        $_SESSION['uid'] = $data['id'];

        //更新最后登录时间
        $now = time();
        $sql = "update p_users set last_login={$now} where user_id={$data['user_id']}";
        $pdo->exec($sql);

        //跳转至 个人中心 my.html
        header("location:index.php");
        exit;

        $response = [
            'errnu' => 0,
            'meg' => '登录成功'
        ];
        die(json_encode($response));
    } else {  //密码不正确 登录失败
        $response = [
            'errnu' => 4002,
            'meg' => '密码错误'
        ];
        die(json_encode($response));
    }
} else {
    $response = [
        'errnu' => 4001,
        'meg' => '用户不存在'
    ];
    die(json_encode($response));
}
