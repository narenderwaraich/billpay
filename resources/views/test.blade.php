<!DOCTYPE html>
<html>
<head>
    <title>Laravel 5.7 Autocomplete Search using Bootstrap Typeahead JS - ItSolutionStuff.com</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<!--      
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" /> -->
  <link rel="stylesheet" href="/css/jquery.auto-complete.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="/js/jquery.auto-complete.js"></script>
</head>
<body>
   
<div class="container">
     <h2>Laravel 5 - Dynamic autocomplete search using select2 JS Ajax</h2>
  <br/>
  <select class="itemName form-control" style="width:500px;" name="itemName"></select>

  <br>
    <h1>Laravel 5.7 Autocomplete Search using Bootstrap Typeahead JS - ItSolutionStuff.com</h1>   
    <input class="typeahead form-control" type="text" id="rate">

    <br>
    <br>
    
    <input type='text' class='automplete' placeholder='e.g. Math' value='' required>
    <input type='hidden' name='semester' id='Item_name'>
</div>

 
<script>
    //var path = "{{ route('autocomplete') }}";
    // $('input.typeahead').typeahead({
    //     source:  function (query, process) {
    //     return $.get(path, { query: query }, function (data) {
    //             return process(data);
    //         });
    //     }
    // });

      // $('.itemName').select2({
      //   placeholder: 'Select an item',
      //   ajax: {
      //     url: '/select2-autocomplete-ajax',
      //     dataType: 'json',
      //     delay: 250,
      //     processResults: function (data) {
      //       return {
      //         results:  $.map(data, function (item) {
      //               return {
      //                   text: item.name,
      //                   id: item.id
      //               }
      //           })
      //       };
      //     },
      //     cache: true
      //   }
      // });


let allItems = $(".automplete").siblings("input#Item_name");
    for(let i = 0; i < allItems.length; i++){
        if(allItems[i].value == ''){
            isValid = false;
        }
    }
     // auto complete 
    
    $(function() {
            initAutoComplete(); 
         });

         function initAutoComplete() {
              var allItems = <?php echo json_encode($allItem) ?>; 
              
                var Items = [];
                for (Item in allItems){
                    let subData = {
                        "label" : allItems[Item]['item_name'], 
                        "value": allItems[Item]['item_name'],
                        "rate": allItems[Item]['sale']
                    };
                    Items.push(subData);
                }
                
                $( ".automplete" ).autocomplete({
                    source: Items,
                    select: function(event, ui){
                        $(this).siblings('input').val(ui.item.value);
                        $(this).val(ui.item.label);
                        $('#rate').val(ui.item.rate);
                        return false;
                     }
            });
         }
</script>


</body>
</html>