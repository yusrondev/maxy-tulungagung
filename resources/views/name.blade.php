<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enter Your Name</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>
  <div class="name-entry">
    <h1>Enter Your Name</h1>
    <form action="/set-name" method="POST">
      @csrf
      <input type="text" name="name" placeholder="Your Name" required>
      <button type="submit">Submit</button>
    </form>
  </div>
</body>
</html>
