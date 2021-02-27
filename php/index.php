<?php
require_once('./request.php');

try {
  $redis = new Redis();
  $redis->connect('localhost', 6379);
  $redis->auth('password');

  $key = 'users';

  if (!$redis->get($key)) {
    $source = 'API';
    $request = new SimpleJsonRequest();
    $response = $request->get('https://jsonplaceholder.typicode.com/users');

    $redis->set($key, serialize($response));
    $redis->expire($key, 30);
  } else {
    $source = 'Redis Server';
    $response = unserialize($redis->get($key));
  }
} catch (RedisException $e) {
  print_r($e);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CrossKnowledge - Code challenge</title>
</head>
<body>
  <h1>Caching service test</h1>

  <h2>Source: <?php echo $source; ?></h2>

  <?php $date = new DateTime('NOW'); ?>
  <p class="js-date-format"><?php echo $date->format('d'); ?></p>
  
  <ul>
    <?php foreach ($response as $user) : ?>
      <li class="user">
        <p class="id"><?php echo $user->id; ?></p>
        <p class="name"><?php echo $user->name; ?></p>
        <p class="username"><?php echo $user->username; ?></p>
        <p class="email"><?php echo $user->email; ?></p>
        <p class="phone"><?php echo $user->phone; ?></p>
        <p class="website"><?php echo $user->website; ?></p>
      </li>
    <?php endforeach; ?>
  </ul>
</body>
</html>