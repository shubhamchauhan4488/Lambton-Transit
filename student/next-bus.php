
<?php include 'master-page/left-panel.php' ?>
    <div id="right-panel" class="right-panel">
        <div class="card">
                        <div class="card-header"><strong>Next Availble Bus</strong></div>
                        <div class="card-body card-block">
                            <form  >
                                <div class="form-group">
                                    <label for="Source" class=" form-control-label">Source</label>
                                    <select class="form-control" id="source">
                                        <option value="Lambton">Lambton</option>
                                        <option value="Mississauga">Mississauga</option>
                                        <option value="Brampton">Brampton</option>
                                    </select>    
                                </div>
                                <div class="form-group">
                                    <label for="Destination" class=" form-control-label">Destination</label>
                                    <select class="form-control" id="destination">
                                        <option value="Lambton">Lambton</option>
                                        <option value="Mississauga">Mississauga</option>
                                        <option value="Brampton">Brampton</option>
                                    </select>  
                                </div>
                                <div class="form-group"><button id="nextBus"  class="btn btn-secondary mb-1">Next Bus</button></div>
                            </form>                            
                        </div>
                        <div  class="card-body card-block" >
                            <div id="nextBusError">
                               
                            </div>
                             
                            <div id="nextBusData" class="invisible">                             
                                <div class="form-group row">
                                    <label for="busSource" class="col-sm-2 col-form-label">Source</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext" id="busSource">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="busDestination" class="col-sm-2 col-form-label">Destination</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext" id="busDestination">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="busTime" class="col-sm-2 col-form-label">Timing</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext" id="busTime">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="busAvailability" class="col-sm-2 col-form-label">Availability</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="busAvailability">                            
                                    </div>
                                </div>
                            
                        </div>
                    <div>

    </div>
    <script>
$("#nextBus").on("click", function(e) {
    e.preventDefault();
    var fromAddress = $("#source").val();
    var toAddress = $("#destination").val();
    var urlAdd = "../api/next-bus.php?toAddress="+toAddress+"&fromAddress="+fromAddress;
    //console.log(urlAdd);
    $.ajax({type: "GET",
        url: urlAdd,        
        success:function(result) {
            if(result.length != 0){   
                $("#nextBusData").removeClass("invisible");
                $("#nextBusError").addClass("invisible");         
                $("#busSource").val(result[0].to_address);
                $("#busDestination").val(result[0].from_address);
                $("#busTime").val(result[0].time);
                var daysOfWeek = "";
                if(result[0].is_avail_monday == 1){                    
                    daysOfWeek +="Monday";                                    
                }
                if(result[0].is_avail_tuesday == 1){
                    if(daysOfWeek !=""){
                        daysOfWeek +=" | Tuesday";
                    }
                    else{
                        daysOfWeek +="Tuesday";
                    }                    
                }
                if(result[0].is_avail_wednesday == 1){
                    if(daysOfWeek !=""){
                        daysOfWeek +=" | Wednesday";
                    }
                    else{
                        daysOfWeek +="Wednesday";
                    }                    
                }
                if(result[0].is_avail_thursday == 1){
                    if(daysOfWeek !=""){
                        daysOfWeek +=" | Thursday";
                    }
                    else{
                        daysOfWeek +="Thursday";
                    }                    
                }
                if(result[0].is_avail_friday == 1){
                    if(daysOfWeek !=""){
                        daysOfWeek +=" | Friday";
                    }
                    else{
                        daysOfWeek +="Friday";
                    }
                }
                if(result[0].is_avail_saturday == 1){
                    if(daysOfWeek !=""){
                        daysOfWeek +=" | Saturday";
                    }
                    else{
                        daysOfWeek +="Saturday";
                    }
                }
                $("#busAvailability").val(daysOfWeek);
                
            }
            else{       
                $("#nextBusData").addClass("invisible");         
                $("#nextBusError").removeClass("invisible");         
                $("#nextBusError").html(
                    '<div class="alert alert-danger" role="alert">'+
                    'No data Available'+
                    '</div>'
                );
            }
            
        },
        error:function(result) {
            $("#nextBusError").html(
                    '<div class="alert alert-danger" role="alert">'+
                    'Something went wrong. Please contact admin'+
                    '</div>'
                );
        }
    });
});
</script>
</body>
</html>
 