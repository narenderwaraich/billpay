<!-- sidebar with menu -->
<div class="sidebar">
  <div class="logo">
    <a href="#" class="logo-mini">
      <img src="/public/images/icon/template-mini-logo.svg" alt="Web Logo" class="template-logo">
    </a>
    <a href="/dashboard" class="logo-normal">
      <img src="/public/images/icon/template-logo.svg" alt="Web Logo" class="template-logo">
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

<!-- Mobile Navbar -->

<nav class="navbar navbar-expand-lg navbar-dark static-top nav-bottom-border fix-navbar bg-red-color mobile-navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">
      <img src="/public/images/icon/template-logo.svg" alt="Logo" class="nav-logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fa fa-bars menu-open-btn" aria-hidden="true"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <hr class="menu-devider">
      <ul class="navbar-nav ml-auto nav-m-r">
        <li class="nav-item nav-text mobile-nav-link {{ (request()->is('dashboard')) ? 'active' : '' }} {{ (request()->is('dashboard/*')) ? 'active' : '' }}">
        <a href="/dashboard" class="nav-link white-txt">
          <i class="menu-icon fa fa-dashboard"></i>
          Dashboard
        </a>
      </li>

      <li class="nav-item nav-text mobile-nav-link {{ (request()->is('client')) ? 'active' : '' }} {{ (request()->is('client/*')) ? 'active' : '' }}">
        <a href="/client/view" class="nav-link white-txt">
          <i class="menu-icon fa fa-users"></i>
          Client
        </a>
      </li>

      <li class="nav-item nav-text mobile-nav-link {{ (request()->is('invoice')) ? 'active' : '' }}{{ (request()->is('invoice/*')) ? 'active' : '' }}">
        <a href="/invoice/view" class="nav-link white-txt">
          <i class="menu-icon fa fa-files-o"></i>
          Invoice
        </a>
      </li>
      <li class="nav-item nav-text mobile-nav-link {{ (request()->is('payment/list')) ? 'active' : '' }}">
        <a href="/payment/list" class="nav-link white-txt">
          <i class="menu-icon fa fa-inr"></i>
          Payment
        </a>
      </li>
      <li class="nav-item nav-text mobile-nav-link {{ (request()->is('items')) ? 'active' : '' }}">
        <a href="/items" class="nav-link white-txt">
          <i class="menu-icon fa fa-book"></i>
          Item
        </a>
      </li>   
      <li class="nav-item nav-text mobile-nav-link {{ (request()->is('profile')) ? 'active' : '' }}{{ (request()->is('profile/*')) ? 'active' : '' }}">
        <a href="/profile" class="nav-link white-txt">
          <i class="menu-icon fa fa-user"></i>
          User
        </a>
      </li>   
      <li class="nav-item nav-text mobile-nav-link ">
        <a href="/logout" class="nav-link white-txt">
          <i class="menu-icon fa fa-power-off"></i>
          LogOut
        </a>
      </li>                   
      </ul>
    </div>
  </div>
</nav>





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

<form action="/find-client" method="post" class="search-nav-form">
  {{ csrf_field() }}
  <div class="input-group">
    <input type="text" name="phone" value="" class="form-control" placeholder="Enter Client Mobile Number" required>
    <div class="input-group-append">
      <button type="submit" class="input-group-text search-nav-btn">
        <i class="fa fa-search"></i>
      </button>
    </div>
  </div>
</form>