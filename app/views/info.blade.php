<!DOCTYPE html>
<head>
<meta charset="utf-8" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">
	// $(function(){
	//    alert("Entrando...");
	// }); 
</script>

</head>
<body>
<script>

 // function onSmartCardChange() {
    //window.location.reload();
   // console.log("Carnet Insertado o Extraido...");
 // }

  //function register() {
   //console.log('adsdadasd'); 
   //console.log(window.crypto);
   //window.crypto.enableSmartCardEvents = true;
   //document.addEventListener("smartcard-insert", onSmartCardChange, false);
   //document.addEventListener("smartcard-remove", onSmartCardChange, false);
 // }

  //function deregister() {
   // document.removeEventListener("smartcard-insert", onSmartCardChange, false);
   // document.removeEventListener("smartcard-remove", onSmartCardChange, false);
 // }
  // document.ready = register;
  //document.body.onunload = deregister;
</script>
<!--<script>
  // function smartcardinsert() {
  //   window.alert("Tarjeta insertada...");
  // }

  // function smartcardremove() {
  //   window.alert("Tarjeta removida...");
  // }

  // function smartcardChangeHandler() {
  // 	window.location.reload();
  // };  

  function onSmartCardChange() {
    //window.location.reload();
    alert("Carnet Insertado o Extraido...");
  }

  // document.addEventListener("smartcard-insert", smartcardChangeHandler );
  // //document.addEventListener("smartcard-insert", function() {window.location.reload()} );
  // document.addEventListener("smartcard-remove", smartcardChangeHandler );

  function register() {
    window.crypto.enableSmartCardEvents = true;
    document.addEventListener("smartcard-insert", onSmartCardChange, false);
    document.addEventListener("smartcard-remove", onSmartCardChange, false);
  }

  function deregister() {
  	window.crypto.enableSmartCardEvents = false;
    document.removeEventListener("smartcard-insert", onSmartCardChange, false);
    document.removeEventListener("smartcard-remove", onSmartCardChange, false);
  }

  document.body.onload = register;
  document.body.onunload = deregister;

</script>
-->

<!-- <button onclick="getNumSerie()">Numero de Serie</button> -->
<!--<button onclick="smartcardChangeHandler()">Prueba botón</button>-->

<p id="campo"> Aquí te muestro el Numero de Serie cuando pulses el botón </p>
<script>
  //function getNumSerie() {
    //document.getElementById("campo").innerHTML = lector.getJsonObject().get("numeroSerie");
   // var numSerie = lector.getJsonObject().get("numeroSerie");
	//document.getElementById("campo").innerHTML = numSerie.trim();
 // }
</script>

<button onclick="getXMLRecibido()">XML</button>
<p id="campo1"> Aquí te muestro el XML recibido: </p>
<script>
 //  function getXMLRecibido() {
 //    var numSerie = lector.getJsonObject().get("numeroSerie");
 //    var xmlResp = $.get("https://sevius.us.es/gicus/serial/xml.php?serie=" + numSerie.trim());
	// document.getElementById("campo1").innerHTML = xmlResp;
 //  }
</script>

<!--<applet id="lector"
  name="SCReader"  
	code="fcom.maviuno.LectorCarnetUniversitario/InfoUI.class" 
	codebase="https://150.214.135.226/reservas/assets/applets" 
	archive="LectorCarnetUniversitario.jar, json-simple-1.1.1.jar" 
	width=500 
	height=400>
</applet>-->

<script>
  // function onSmartCardChange() {
  //   window.location.reload();
  // }
  // function register() {
  //   window.crypto.enableSmartCardEvents = true;
  //   document.addEventListener("smartcard-insert", onSmartCardChange, false);
  //   document.addEventListener("smartcard-remove", onSmartCardChange, false);
  // }
  // function deregister() {
  //   document.removeEventListener("smartcard-insert", onSmartCardChange, false);
  //   document.removeEventListener("smartcard-remove", onSmartCardChange, false);
  // }

  // document.body.onload = register;
  // document.body.onunload = deregister;
</script>

<ul id="test">
  <li>item 1</li>
  <li>item 2</li>
  <li>item 3</li>
</ul>

<script>
  //var test = document.getElementById("test");
  
  // this handler will be executed every time the cursor is moved over a different list item
  //test.addEventListener("mouseover", function( event ) {   
    // highlight the mouseover target
//    event.target.style.color = "orange";

    // reset the color after a short delay
  //  setTimeout(function() {
   //   event.target.style.color = "";
   // }, 500);
 // }, false);
</script>

<script>
 $(document).ready(function() {
// Handler for .ready() called
register();


function onSmartCardChange() {
// window.location.reload();
  console.log('insert-remove');
}
function register() {   
  window.crypto.enableSmartCardEvents = true; 
  document.addEventListener("smartcard-insert", onSmartCardChange, false);
  document.addEventListener("smartcard-remove", onSmartCardChange, false);
  console.log('version='+window.crypto.version);
}
  });
</script>

</body>
</html>