<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{config('app.name', 'Shopping List')}}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script> -->

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #000;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }
        .full-height {
            height: 100vh;
        }
        .action_btns{
         padding: 5px;
         cursor: pointer;
        }
        .right.aligned{
            text-align: right;
        }
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        .position-ref {
            position: relative;
        }
        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }
        .bg-purple{background-color: #6f42c1; }
        .content {
            text-align: center;
        }
        .title {
            font-size: 64px;
        }
        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
        .m-b-md {
            margin-bottom: 30px;
        }
        .container-wrapper{
            width: 70%; 
            margin: 0 auto;
        }
        .bold{
            font-weight: bold;
        }
        h3.heading {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="container-wrapper">
            @yield('content')
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".item_name").keyup(function() {
                var textlen = $(this).val().length;
                if(textlen > 1){ //disable the add button at least if there is input
                    $('.add_item_btn').removeAttr("disabled");
                }else{
                    $('.add_item_btn').prop("disabled", true);
                }
            });

            //modal input
            $(".up_item_name").keyup(function() {
                var textlen = $(this).val().length;
                if(textlen > 1){ //disable the add button at least if there is input
                    $('.update_item_btn').removeAttr("disabled");
                }else{
                    $('.update_item_btn').prop("disabled", true);
                }
            });

            //add item
            $(".add_item_btn").click(function(){
                $(".ajax_status").html("");
                var item = $(".item_name").val();
                if(item.length > 1){ //do a post request only if there is input
                    $.post( "/add-item", { item })
                    .done(function( data ) {
                        if(data.status === "success"){
                            location.reload();
                        }else{
                            $(".ajax_status").html("Something went wrong.");                            
                        }
                    })
                    .fail(function( err ) {
                        alert( "ERROR: " + err );
                    });
                }else{
                    $(".ajax_status").html("The item name cannot be empty.");
                }
            });

            //delete 
            $(".trash_item").click(function(){
                var item = $(this).attr("item");
                console.log("item ", item);
                if(item){
                    $.post( "/remove-item", { id: item })
                    .done(function( data ) {
                        if(data.status === "success"){
                            location.reload();
                        }else{
                            $(".ajax_status").html("Something went wrong.");                            
                        }
                    })
                    .fail(function( err ) {
                        alert( "ERROR: " + err );
                    });
                }
            });

            //done task
            $(".update_status").click(function(){
                var item = $(this).attr("item");
                var status = $(this).attr("data");
                if(status === "check"){ //only update unchecked items
                    $.post( "/task-done", { id: item, status: status })
                    .done(function( data ) {
                        console.log("data ", data);
                        if(data.status === "success"){
                            location.reload();
                        }else{
                            $(".ajax_status").html("Something went wrong.");
                        }
                    })
                    .fail(function( err ) {
                        alert( "ERROR: " + err );
                    });
                }
            });

            //update item
            $(".update_item").click(function(){
                var item = $(this).attr("item");
                var id = $(this).attr("data-id");
                $(".up_item_name").attr("value", item);
                $(".entry_id").attr("value", id);
            });

            $(".update_item_btn").click(function(){
                $(".ajax_modal_status").html("");
                //can use serialize
                var item = $(".up_item_name").val();
                var entry_id = $(".entry_id").val();
                if(item.length > 1){ //do a post request only if there is input
                    $.post( "/update-item", { id: entry_id, item: item })
                    .done(function( data ) {
                        if(data.status === "success"){
                            location.reload();
                        }else{
                            $(".ajax_status").html("Something went wrong.");                            
                        }
                    })
                    .fail(function( err ) {
                        alert( "ERROR: " + err );
                    });
                }else{
                    $(".ajax_status").html("The item name cannot be empty.");
                }
            });
        });
    </script>
</body>
</html>