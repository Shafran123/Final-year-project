<?php 
// if (isset($_SERVER['HTTP_COOKIE']))
// {
//     $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
//     foreach($cookies as $cookie) {
//         $parts = explode('=', $cookie);
//         $name = trim($parts[0]);
//         setcookie($name, '', time()-1000);
//         setcookie($name, '', time()-1000, '/');
//     }
// }
    setcookie("customer_id", null, -1, "/");
    header("Location: index.php"); 
    die("Redirecting to: index.php");
?>
<script type="text/javascript">
	console.log(document.cookie);
</script>