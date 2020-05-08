<?php 
if (isset($_SESSION['user_id'])) {

echo "<nav class='navbar navbar-expand-lg navbar-light' style='background-color: #c00000; border-radius: 3px;'>
<a class='navbar-brand' style='color:whitesmoke' href='dashboard.php'>Dashboard</a>
<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarText' aria-controls='navbarText' aria-expanded='false' aria-label='Toggle navigation'>
  <span class='navbar-toggler-icon'></span>
</button>
<div class='collapse navbar-collapse' id='navbarText'>
  <ul class='navbar-nav mr-auto'>
    <li class='nav-item'>
      <a class='nav-link' style='color:whitesmoke' href='przelewy.php'>Przelewy </a>
    </li>
    <li class='nav-item'>
      <a class='nav-link' style='color:whitesmoke' href='history.php'>Historia</a>
    </li>
  </ul>
  <ul class='nav navbar-nav navbar-right'>
    <li> <a href='settings.php' class='nav-link' style='color:whitesmoke'> Ustawienia <img src='imgs/settings.png' width='24px' height='24px'> </a> </li>
    <li><a href='logout.php' class='nav-link' style='color:whitesmoke'> wyloguj sie</a></li>
  </ul>
</div>
</nav>";
}

else {
  echo "<nav class='navbar navbar-expand-lg navbar-light' style='background-color: #c00000; border-radius: 3px;'>
  <a class='navbar-brand' style='color:whitesmoke' href='dashboard.php'>Strona główna</a>
  <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarText' aria-controls='navbarText' aria-expanded='false' aria-label='Toggle navigation'>
    <span class='navbar-toggler-icon'></span>
  </button>
  <div class='collapse navbar-collapse' id='navbarText'>
    <ul class='navbar-nav mr-auto'>
      <li class='nav-item'>
       <!-- <a class='nav-link' style='color:whitesmoke' href='przelewy.php'>Przelewy </a> --> 
      </li>

    </ul>
    <ul class='nav navbar-nav navbar-right'>

      <li><a href='register.php' class='nav-link' style='color:whitesmoke'> zarejestruj sie</a></li>
    </ul>
  </div>
  </nav>";
}
