<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Document</title>
</head>
<body>
   <h1>Login</h1>
   <form method="post" action="/login">
   @csrf


   <div>
       <label for="username">Username</label>
       <input name="username" id="username" type="text" />
   </div>
   <div>
       <label for="password">Password</label>
       <input name="password" id="password" type="password" required />
   </div>
   <button type="submit">Login</button>


</form>


@include('errors')
</body>
</html>