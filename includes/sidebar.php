<div class="wrapper">
  <div class="sidebar">
    <button class="toggle-button">&#9776; Toggle Menu</button>
    <ul class="menu">
      <li><a href="#">Item 1</a></li>
      <li><a href="#">Item 2</a></li>
      <li><a href="#">Item 3</a></li>
    </ul>
  </div>
  <div class="content">
    <!-- Your content here -->
  </div>
</div>

<style>
  .wrapper {
    display: flex;
  }

  .sidebar {
    width: 200px;
    height: 100%;
    background-color: #f5f5f5;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 1;
    overflow-x: hidden;
    padding-top: 60px;
    transition: all 0.3s ease;
  }

  .content {
    flex: 1;
    margin-left: 200px;
    padding: 20px;
    transition: all 0.3s ease;
  }

  .sidebar.hide {
    width: 0;
    overflow: hidden;
  }

  .sidebar .menu {
    padding: 0;
    margin: 0;
  }

  .sidebar .menu li {
    list-style-type: none;
    padding: 10px;
  }

  .sidebar .menu a {
    text-decoration: none;
    color: #333;
  }

  .sidebar .toggle-button {
    background-color: #f5f5f5;
    border: none;
    padding: 10px;
    font-size: 16px;
    cursor: pointer;
    position: fixed;
    top: 0;
    left: 200px;
    transition: all 0.3s ease;
  }

  .sidebar.hide .toggle-button {
    left: 0;
  }

  .content.shrink {
    margin-left: 0;
  }

  .content.shrink-full {
    margin-left: 0;
    width: 100%;
  }
</style>

<script>
  var toggleButton = document.querySelector('.toggle-button');
  var sidebar = document.querySelector('.sidebar');
  var content = document.querySelector('.content');

  toggleButton.addEventListener('click', function() {
    sidebar.classList.toggle('hide');
    content.classList.toggle('shrink');
    if (content.classList.contains('shrink')) {
      content.classList.remove('shrink-full');
    } else {
      content.classList.add('shrink-full');
    }
  });
</script>
