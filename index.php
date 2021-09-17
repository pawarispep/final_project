<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Bloodoxy</title>
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <meta http-equiv="refresh" content="15"; url=" <?php echo $_SERVER['PHP_SELF']; ?>">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

</head>
<style>
    #status{
        border-radius: 7px;
        padding :4px;
        width :4px;
        height: 100px;
        color:white;
    }
    #container1{
        background-color:#DDF2F4;
        border-radius: 15px;
        
    }


</style>

  <body >
    
    <h1 align="center">Inpatient Department</h1>
    <div class="container" id="container1">
        <h2>Ward:1</h2>
        <div class="row">
            <div class="col-3"><b>Bed1</b></div>
            <div class="col-3"><b>Bed2</b></div>
            <div class="col-3"><b>Bed3</b></div>
            <div class="col-3"><b>Bed4</b></div>
            <div class="col-8" class="status">
                <span id="bed1"></span>
            </div>
            <div class="col-8">
                <span id="bed2"></span>
            </div>
            <div class="col-8">
                <span id="bed3"></span>
            </div>
            <div class="col-8">
                <span id="bed4"></span>
            </div>

        </div>
        <!-- สร้างiconบุคคล-->
        <div class="row"> 
            <div class="col-3">
                <i class="glyphicon glyphicon-user" id="pic" style="font-size:60px;"></i>
                
            </div>
            <div class="col-3">
                <i class="glyphicon glyphicon-user" style="font-size:60px;"></i>
                
            </div>
            <div class="col-3">
                <i class="glyphicon glyphicon-user" style="font-size:60px;"></i>
                
            </div>
            <div class="col-3">
                <i class="glyphicon glyphicon-user" style="font-size:60px;"></i>
                
            </div>
            
            
        </div>
        <!--สร้างตำแหน่งแสดงผลของแต่ละคน-->
        <div class="row">
            <div class="col-3">
                <div class="row">
                <div class="col-3"><b>Oxygen</b></div>
                
                <div class="col-3">
                <span id="oxygen"></span>
                </div>

                </div>

                <div class="row">
                    <div class="col-3"><b>HeartRate</b></div>
                    <div class="col-4">
                    <span id="heartRate"></span>
                </div>
                </div>
                <div class="row">
                    <div class="col-3"><b>Status</b></div>
                    
                    <div class="col-4">
                    <span id="status"></span>
                    </div>
    
                </div>
            
            </div>

            <div class="col-3">
                <div class="row">
                <div class="col-4"><b>Oxygen</b></div>
                
                <div class="col-8">
                <span id="oxygen2"></span>
                </div>

                </div>

                <div class="row">
                    <div class="col-4"><b>HeartRate</b></div>
                    <div class="col-8">
                    <span id="heartRate2"></span>
                </div>
                </div>
                <div class="row">
                    <div class="col-4"><b>Status</b></div>
                    
                    <div class="col-8">
                    <span id="status2"></span>
                    </div>
    
                </div>
            
            </div>

            <div class="col-3">
                <div class="row">
                <div class="col-4"><b>Oxygen</b></div>
                
                <div class="col-8">
                <span id="oxygen3"></span>
                </div>

                </div>

                <div class="row">
                    <div class="col-4"><b>HeartRate</b></div>
                    <div class="col-8">
                    <span id="heartRate3"></span>
                </div>
                </div>
                <div class="row">
                    <div class="col-4"><b>Status</b></div>
                    
                    <div class="col-8">
                    <span id="status3"></span>
                    </div>
    
                </div>
            
            </div>

            <div class="col-3">
                <div class="row">
                <div class="col-4"><b>Oxygen</b></div>
                
                <div class="col-8">
                <span id="oxygen4"></span>
                </div>

                </div>

                <div class="row">
                    <div class="col-4"><b>HeartRate</b></div>
                    <div class="col-8">
                    <span id="heartRate4"></span>
                </div>
                </div>
                <div class="row">
                    <div class="col-4"><b>Status</b></div>
                    
                    <div class="col-8">
                    <span id="status4"></span>
                    </div>
    
                </div>
               
            
            </div>
        </div>        
    </div>
  </body>
  <script>
   
      $(()=>{
                  
          let url="https://api.thingspeak.com/channels/1492143/feeds.json?results=2";
          $.getJSON(url)
            .done(function(data){
                let feed=data.feeds;
                let chan=data.chan;
                var oxy=feed[1].field2;
                var heart=feed[1].field1;
                //var oxy=80;
                //ไว้ปรับแบบล็อกค่า
                //เนื่องจากsensorวัดค่าจริงๆได้แค่82ซึ่งผิดต่อหลักความจริงเพราะค่าปกติของมนุษย์จะอยู่ที่96%
                console.log(feed);
        

                
                $("#oxygen").text((oxy)+" %");
                $("#heartRate").text((heart)+" ");
                //สร้างคำสั่งสำหรับการเปลี่ยนสีiconตามเงื่อนไข
                if (oxy>=96){
                    status="Normal";
                    $("#status").text(status).css("background", "#228B22");
                }else if(oxy>90){
                    status="Abnormal";
                    $("#status").text(status).css("background", "#FFCC00");
                }else{
                    status="Emergency";
                    alert("---------------------------go to bed---------------------------");
                    $("#status").text(status).css("background", "#FF0033" );
                    $("#pic").css({"background": "#FF0033" ,
                    "border-radius": "7px" });
                    

                    
                
            }
            })
            .fail(function(error){

            });
      });

      

  </script>
</html>
