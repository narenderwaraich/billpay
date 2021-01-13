<nav class="navbar navbar-expand-lg navbar-dark static-top nav-bottom-border fix-navbar bg-black-color" style="margin-bottom: 0;">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">
      <img src="/public/images/icon/transparent-logo.svg" alt="Logo" class="nav-logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fa fa-bars menu-open-btn" aria-hidden="true"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto nav-m-r">
        <li class="nav-item nav-text {{ (request()->is('/')) ? 'active' : '' }}">
          <a class="nav-link on-hover-color text-up" href="/">Home</a>
        </li>
        <li class="nav-item nav-text {{ (request()->is('about-us')) ? 'active' : '' }}">
          <a class="nav-link on-hover-color text-up" href="/about-us">About Us</a>
        </li>
        <li class="nav-item nav-text {{ (request()->is('contact-us')) ? 'active' : '' }}">
          <a class="nav-link on-hover-color text-up" href="/contact-us">Contact Us</a>
        </li>
        <li class="nav-item nav-text {{ (request()->is('register')) ? 'active' : '' }}">
          <a class="nav-link on-hover-color text-up" href="/register">Register</a>
        </li>
        <li class="nav-item nav-text {{ (request()->is('login')) ? 'active' : '' }}">
          <a class="nav-link on-hover-color text-up" href="/login">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>