@extends('layouts.app')
@section('content')  
<!-- top header -->
<div class="panel-header panel-header-sm">
              
</div>
<!-- end header    -->
<!-- content section -->
  <div class="content">
        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-header">
                <h5 class="title">Add Item</h5>
              </div>
              <div class="card-body">
                <form action="/items/add" method="post" autocomplete="">
                    {{ csrf_field() }}
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" value="{{old('item_name')}}" name="item_name" id="item_name" class="form-control {{ $errors->has('item_name') ? ' is-invalid' : '' }}">
                        <label>Item Name</label>
                        @if ($errors->has('item_name'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('item_name') }}</strong>
                          </span>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="number" name="qty" value="{{old('qty')}}" id="qty" class="form-control">
                        <label>Quantity</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input name="price" type="number" id="price" value="{{old('price')}}" class="form-control">
                        <label>Price</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="number" class="form-control" name="sale" id="sale" value="{{old('sale')}}">
                        <label>Sale</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <textarea name="item_description" id="item_description" rows="4" cols="80" class="form-control"></textarea>
                        <label>Description</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-success">Save</button>
                      <button type="button" class="btn btn-danger">Clear</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- end col -->
          <div class="col-lg-4">
                        <div class="card card-user">
              <div class="image">
                <img src="/public/images/bg.jpg" alt="">
              </div>
              <div class="card-body">
                <div class="author">
                  <a href="#">
                    <img class="avatar border-gray" src="/public/images/icon/user.jpg" alt="Client">
                    <h5 class="title"><span id="first_name"></span></h5>
                  </a>
                  <hr>
                  <div class="client-data" id="client_qty">Quantity : <span id="client_qty_data"></span></div>
                  <div class="client-data" id="client_price">Price : <span id="client_price_data"></span></div>
                  <div class="client-data" id="client_sale">Sale : <span id="client_sale_data"></span></div>
                  <div class="client-data" id="client_item_description">item_description : <span id="client_item_description_data"></span></div>
                  <!-- <p class="description">
                    michael24
                  </p> -->
                </div>
              </div>
              
              <div class="button-container">

              </div>
            </div>
          </div>
          <!-- end col -->
        </div>
      </div>
      <!-- end content section -->


<script type="text/javascript">
///// Client Data Show
$(document).ready(function(){

	$('#item_name').on('keyup', function(){
    var item_name = $(this).val();
    if($('#item_name').val()!=""){
      $('#first_name').text(item_name);
    }else{
      $('#first_name').hide();
    }
   });

	$('#qty').on('keyup', function(){
      var qty = $(this).val();
      if($('#qty').val()!=""){
        $('#client_qty').show();
      	$('#client_qty_data').text(qty);
      }else{
        $('#client_qty').hide();
      }
    });

    $('#price').on('keyup', function(){
    var price = $(this).val();
    if($('#price').val()!=""){
      $('#client_price').show();
      $('#client_price_data').text(price);
    }else{
      $('#client_price').hide();
    }
   });

	$('#sale').on('keyup', function(){
    var sale = $(this).val();
    if($('#sale').val()!=""){
      $('#client_sale').show();
      $('#client_sale_data').text(sale);
    }else{
      $('#client_sale').hide();
    }
   });

    $('#item_description').on('keyup', function(){
      var item_description = $(this).val();
      if($('#item_description').val()!=""){
        $('#client_item_description').show();
        $('#client_item_description_data').text(item_description);
      }else{
        $('#client_item_description').hide();
      }
    });

});
</script>                               
@endsection