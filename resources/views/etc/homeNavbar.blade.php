<nav class="navbar navbar-expand-lg navbar-dark static-top nav-bottom-border fix-navbar bg-black-color">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">
      <img src="/public/images/icon/transparent-logo.svg" alt="Logo" class="nav-logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto nav-m-r">
        <li class="nav-item nav-text">
          <a class="nav-link white-txt on-hover-color" href="/about-us">About Us</a>
        </li>
        <li class="nav-item nav-text">
          <a class="nav-link white-txt on-hover-color" href="/contact-us">Contact Us</a>
        </li>
        @if(request()->is('login'))
        <li class="nav-item nav-text">
          <a class="nav-link white-txt on-hover-color" href="/">Sign Up</a>
        </li>
        @else
        <li class="nav-item nav-text">
          <a class="nav-link white-txt on-hover-color" href="/login">Login</a>
        </li>
        @endif
      </ul>
    </div>
  </div>
</nav>