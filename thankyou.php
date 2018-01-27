<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Waypoints in directions</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="js/mapMaker.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#buttonk").click(function(){
                $.ajax({url: "demo_test.txt",
                    cache: false, success: function(result){
                        $("#div1").html(result);
                    }});
            });
        });
    </script>
</head>
<body>
	
<!--- INITIAL GET CALL -->
<script>
$("scriptGetBtn").click(function(){
    $.ajax({url: "backend/getObstructions.php", success: function(result){
        $("#scriptEcho").html(result);
    }});
});
</script>	
<div id="scriptEcho"></div>	
<button id="scriptGetBtn">Get Obstructions</button>	
	
<div id="div1"><h2>CHANGE ME</h2></div>

<button>Get External Content</button>
<br><br><br>
<button onclick="getLocation()" id="buttonk">Get Coords</button>

<p id="demo"></p>

<script>
    var x = document.getElementById("demo");

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        x.innerHTML = "Latitude: " + position.coords.latitude +
            "<br>Longitude: " + position.coords.longitude;
    }
</script>
<div id="floating-panel">
    <b>Start: </b>
    <select id="start">
        <option value="Tanimura and Antle Family Memorial Library, Seaside, CA 93955">library</option>
    </select>
    <b>End: </b>
    <select id="end">
        <option value="260 Broadway New York NY 10007">City Hall</option>
        <option value="W 49th St & 5th Ave, New York, NY 10020">Rockefeller Center</option>
        <option value="moma, New York, NY">MOMA</option>
        <option value="350 5th Ave, New York, NY, 10118">Empire State Building</option>
        <option value="253 West 125th Street, New York, NY">Apollo Theater</option>
        <option value="1 Wall St, New York, NY">Wall St</option>
    </select>
</div>
<div id="map"></div>
&nbsp;
<div id="warnings-panel"></div>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDZzWdPfvDGrYEnEla1G5MYEz5fDiMs0RI&callback=initMap">
</script>
</body>
</html>