<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Skeleton Screen Example</title>
<style>
  .skeleton {
    display: inline-block;
    height: 20px;
    background-color: #e0e0e0;
    border-radius: 4px;
    margin-bottom: 10px;
    width: 100%;
    animation: pulse 1.5s infinite;
  }

  .skeleton.image {
    height: 200px;
    width: 100%;
    margin-bottom: 20px;
  }

  @keyframes pulse {
    0% {
      background-color: #e0e0e0;
    }
    50% {
      background-color: #f0f0f0;
    }
    100% {
      background-color: #e0e0e0;
    }
  }

  .content {
    display: none;
  }
</style>
</head>
<body>

  <div class="skeleton image"></div>
  <div class="skeleton"></div>
  <div class="skeleton"></div>
  <div class="skeleton"></div>

  <div class="content">
    <img src="image.jpg" alt="Loaded Image" width="100%">
    <p>Loaded content goes here.</p>
    <p>More content loaded.</p>
    <p>And even more content.</p>
  </div>

  <script>
    // Simulate content loading
    setTimeout(function() {
      document.querySelectorAll('.skeleton').forEach(s => s.style.display = 'none');
      document.querySelector('.content').style.display = 'block';
    }, 2000); // Simulates a 2-second load time
  </script>

</body>
</html>
