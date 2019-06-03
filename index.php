<?php
//Include GP config file && User class
include_once 'gpConfig.php';
include_once 'User.php';

if(isset($_GET['code'])){
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
	$gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
	//Get user profile data from google
	$gpUserProfile = $google_oauthV2->userinfo->get();
	
	//Initialize User class
	$user = new User();
	
	//Insert or update user data to the database
   
    $gpUserData = array(
        'oauth_provider'=> 'google',
        'oauth_uid'     => isset($gpUserProfile['id']) ? $gpUserProfile['id'] : '',
        'first_name'    => isset($gpUserProfile['given_name']) ? $gpUserProfile['given_name'] : '',
        'last_name'     => isset($gpUserProfile['family_name']) ? $gpUserProfile['family_name'] : '',
        'email'         => isset($gpUserProfile['email']) ? $gpUserProfile['email'] : '',
        'gender'        => isset($gpUserProfile['gender']) ? $gpUserProfile['gender'] : '',
        'locale'        => isset($gpUserProfile['locale']) ? $gpUserProfile['locale'] : '',
        'picture'       => isset($gpUserProfile['picture']) ? $gpUserProfile['picture'] : '',
        'link'          => isset($gpUserProfile['link']) ? $gpUserProfile['link'] : ''
    );
    $userData = $user->checkUser($gpUserData);
	
	//Storing user data into session
	$_SESSION['userData'] = $userData;
	
	//Render facebook profile data
    
}else {
	$authUrl = $gClient->createAuthUrl();
	$output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><button class="btn btn-info" style="margin:100px; border-radius:0px">Login With Google</button></a>';
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login with Google using PHP</title>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<style type="text/css">
h1{font-family:Arial, Helvetica, sans-serif;color:#999999;}
</style>
</head>
<body>
<div><?php echo isset($output) ? $output : " "; 

if(!empty($userData)){
?>
<div class='container-fluid'>
    <table class="table table-sm table-bordered table-responsive">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">oauth_provider</th>
      <th scope="col">oauth_uid</th>
      <th scope="col">first_name</th>
      <th scope="col">last_name</th>
      <th scope="col">email</th>
      <th scope="col">gender</th>
      <th scope="col">locale</th>
      <th scope="col">picture</th>
      <th scope="col">link</th>
      <th scope="col">created</th>
      <th scope="col">modified</th>
    </tr>
  </thead>
  <tbody>
    <tr>
     
      <td><?php echo $userData['id']; ?></td>
      <td><?php echo $userData['oauth_provider']; ?></td>
      <td><?php echo $userData['oauth_uid']; ?></td>
      <td><?php echo $userData['first_name']; ?></td>
      <td><?php echo $userData['last_name']; ?></td>
      <td><?php echo $userData['email']; ?></td>
      <td><?php echo $userData['gender']; ?></td>
      <td><?php echo $userData['locale']; ?></td>
      <td><?php echo $userData['picture']; ?></td>
      <td><?php echo $userData['link']; ?></td>
      <td><?php echo $userData['created']; ?></td>
      <td><?php echo $userData['modified']; ?></td>
    </tr>
  </tbody>
</table>
<br/>Logout from <a href="logout.php">Google</a>
</div>

<?php

    }else{
       $output = '<h3 style="color:red">Some problem occurred, please try again</h3>';
    }




?>
    



</div>
</body>
</html>