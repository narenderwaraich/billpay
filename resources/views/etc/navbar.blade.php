<!-- sidebar with menu -->
<div class="sidebar">
  <div class="logo">
    <a href="#" class="simple-text logo-mini">
      Mob
    </a>
    <a href="/dashboard" class="simple-text logo-normal">
      Dashboard
    </a>
  </div>
  <div class="sidebar-wrapper" id="sidebar-wrapper">
    <ul class="nav">
      <li class="{{ (request()->is('dashboard')) ? 'active' : '' }} {{ (request()->is('dashboard/*')) ? 'active' : '' }}">
        <a href="/dashboard">
          <i class="menu-icon fa fa-dashboard"></i>
          <p>Dashboard</p>
        </a>
      </li>

      <li class="{{ (request()->is('client')) ? 'active' : '' }} {{ (request()->is('client/*')) ? 'active' : '' }}">
        <a href="/client/view">
          <i class="menu-icon fa fa-users"></i>
          <p>Client</p>
        </a>
      </li>

      <li class="{{ (request()->is('invoice')) ? 'active' : '' }}{{ (request()->is('invoice/*')) ? 'active' : '' }}">
        <a href="/invoice/view">
          <i class="menu-icon fa fa-files-o"></i>
          <p>Invoice</p>
        </a>
      </li>            
      <li>
      <li class="{{ (request()->is('payment/list')) ? 'active' : '' }}">
        <a href="/payment/list">
          <i class="menu-icon fa fa-inr"></i>
          <p>Payment</p>
        </a>
      </li>            
      <li>
        <a href="/items" class="{{ (request()->is('items')) ? 'active' : '' }}">
          <i class="menu-icon fa fa-book"></i>
          <p>Item</p>
        </a>
      </li>
      <li>
        <a href="/profile" class="{{ (request()->is('profile')) ? 'active' : '' }}{{ (request()->is('profile/*')) ? 'active' : '' }}">
          <i class="menu-icon fa fa-user"></i>
          <p>User</p>
        </a>
      </li>
      <li>
        <a href="/logout">
          <i class="menu-icon fa fa-power-off"></i>
          <p>LogOut</p>
        </a>
      </li>
    </ul>
  </div>
</div>
<!-- end sidebar -->

<!-- Navbar -->
            <!-- <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
              <div class="container-fluid">
                <div class="navbar-wrapper">
                  <div class="navbar-toggle">
                    <button type="button" class="navbar-toggler">
                      <span class="navbar-toggler-bar bar1"></span>
                      <span class="navbar-toggler-bar bar2"></span>
                      <span class="navbar-toggler-bar bar3"></span>
                    </button>
                  </div>
                  <a class="navbar-brand" href="#pablo">Dashboard</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-bar navbar-kebab"></span>
                  <span class="navbar-toggler-bar navbar-kebab"></span>
                  <span class="navbar-toggler-bar navbar-kebab"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navigation">
                  <form>
                    <div class="input-group no-border">
                      <input type="text" value="" class="form-control" placeholder="Search...">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <i class="now-ui-icons ui-1_zoom-bold"></i>
                        </div>
                      </div>
                    </div>
                  </form>
                  <ul class="navbar-nav">
                    <li class="nav-item">
                      <a class="nav-link" href="#pablo">
                        <i class="now-ui-icons media-2_sound-wave"></i>
                        <p>
                          <span class="d-lg-none d-md-block">Stats</span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="now-ui-icons location_world"></i>
                        <p>
                          <span class="d-lg-none d-md-block">Some Actions</span>
                        </p>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                      </div>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#pablo">
                        <i class="menu-icon fa fa-user"></i>
                        <p>
                          <span class="d-lg-none d-md-block">Account</span>
                        </p>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </nav> -->
            <!-- End Navbar -->