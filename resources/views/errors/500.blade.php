<html>
  <head>
    <title>{{ config('backpack.base.project_name') }} Error 500</title>

    <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

    <style>
      body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        color: #B0BEC5;
        display: table;
        font-weight: 100;
        font-family: 'Lato';
      }

      .container {
        text-align: center;
        display: table-cell;
        vertical-align: middle;
      }

      .content {
        text-align: center;
        display: inline-block;
      }

      .title {
        font-size: 156px;
      }

      .quote {
        font-size: 36px;
      }

      .explanation {
        font-size: 24px;
      }
      .form-btn{
        background-color: #E565F3;
        color: #FFFFFF;
        text-transform: uppercase;
        border-radius: 30px;
        border: 2px solid #E565F3;
        height: 45px;
        width: 190px;
        font-size: 22px;
      }
      .form-btn:hover{
        background-color: transparent;
        color: #E565F3;
        border:2px solid #E565F3;
        cursor: pointer;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="content">
        <div class="title">500</div>
        <div class="quote">Sorry Page not found</div>
        <div class="explanation">
          <br>
          <small>
            <center>
              <a href="/dashboard"><img src="/images/mapleebooks_logo.svg" alt="Logo"></a>
            </center>
            <br>
           <a href="/"><button type="button" class="btn form-btn">Go to Home</button></a>
         </small>
       </div>
      </div>
    </div>
  </body>
</html>
