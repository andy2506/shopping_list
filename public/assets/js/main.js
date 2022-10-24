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