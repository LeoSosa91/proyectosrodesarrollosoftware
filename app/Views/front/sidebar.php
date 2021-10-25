<!-- offcanvas -->
<div class="offcanvas offcanvas-start sidebar-nav bg-dark" tabindex="-1" id="sidebar" >
      <div class="offcanvas-body p-0">
        <nav class="navbar-dark">
          <ul class="navbar-nav">
            <?php 
            switch (session('group')) {
              case 'Cliente':
                echo $this->include('front/sidebar/sidebar_client');
                break;
              case 'Administrador':
                echo $this->include('front/sidebar/sidebar_admin');  
                break;
              case 'Chef':
                echo $this->include('front/sidebar/sidebar_chef');  
                break;
              default:
                # code...
                break;
            }
            ?>
          </ul>
        </nav>
      </div>
    </div>
    <!-- offcanvas -->