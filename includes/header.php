<header>
  <?php
    if($current_page_id == "index") {
      echo "<h1 class='title' id='current_page'><a href='index'>Home</a></h1>";
    }
    else {
      echo "<h1 class='title'><a href='index'>Home</a></h1>";
    }
    ?>

  <!-- <div>
    <input id="search" type="text" placeholder="search"></input>
  </div> -->
  <nav id="menu">
    <div id="nav-right">

      <ul>
      <?php foreach ($pages as $key => $value) {
        if($key != 'index'){

        if ($current_page_id == $key) {
          echo "<li id='current_page'><a href='".$key. ".php'>".$value."</a></li>";
        }
        else if($current_user && $key =='login'){}
          else if(!$current_user && $key=='upload'){}
        else {
          echo "<li><a href='".$key. ".php'>".$value."</a></li>";
      }
      }
    } ?>
    <?php if ($current_user) {
      echo "<div class='dropdown'><a href='#' class='dropbtn'>".$current_user."</a>
        <div class='dropdown-content'><a href='logout.php'>Log out </a>
      </div>";
    }?>
    </ul>
  </div>
  </nav>
</header>
