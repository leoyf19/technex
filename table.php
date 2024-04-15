<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Technex</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon-1.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- ======= Css ======= -->
  <?php include_once('assets/css/css.php') ?>
  <!-- ============== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <?php include_once('components/header.php') ?>
  <!-- End Header -->

  <!-- ======= Projects ======= -->
  <?php include_once('components/projects.php') ?>
  <!-- End Projects -->

    <!-- ======= Main ======= -->
    <div class="row p-5 justify-content-center align-items-center">
        <div id="top"></div>
        <div class="col-md-12 p-3 my-3 d-flex justify-content-center align-items-center">
            <h1>Loteria Technex</h1>
        </div>


        <div class="col-md-12 d-flex flex-column justify-content-center align-items-center" id="screenNumber">

        </div>


        <div class="col-md-12 p-3" id="tableSelected">
            
        </div>

        <div class="col-md-12 d-flex justify-content-center initial-game p-5">
            <button type="button" class="btn btn-success initial-game" id="play">JUGAR</button>
        </div>

        <div class="col-md-12 d-flex justify-content-center align-items-center initial-game">
            <h3 class="initial-game">Presione una tabla para poder jugar</h3>
        </div>

        <div class="col-md-12 initial-game">
            <div class="row p-2 justify-content-center gap-3" id="tablesForPlay">
            </div>
        </div>

    </div>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include_once('components/footer.php') ?>
  <!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

</body>

</html>
  <!-- ======= Scripts ======= -->
  <?php include_once('assets/js/js.php') ?>
  <!-- ============== -->
<script>
function shuffleArray(array) {
    for (var i = array.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1)); // Genera un índice aleatorio entre 0 y i
        var temp = array[i]; // Intercambia los elementos en las posiciones i y j
        array[i] = array[j];
        array[j] = temp;
    }
    return array; // Devuelve el arreglo mezclado aleatoriamente
}

const universe = shuffleArray(Array.from({ length: 128 }, (_, index) => index + 1));


const universeInGroups4 = splitUniverseInGroups4(universe);
const tickets = [];

function generateAllTables(numeros) {
    let todasCombinaciones = [];
    const longitudNumeros = numeros.length;

    for (let i = 0; i < longitudNumeros; i++) { 
        for (let j = i + 1; j < longitudNumeros; j++) {
            for (let k = j + 1; k < longitudNumeros; k++) {
                for (let l = k + 1; l < longitudNumeros; l++) {
                    let combinacion = [
                        numeros[i],
                        numeros[j],
                        numeros[k],
                        numeros[l]
                    ];
                    todasCombinaciones.push(combinacion);
                }
            }
        }
    }

    return todasCombinaciones;
}

function addElementsInTable (tabla){
    tablaJunta = [];
    for (var i = 0; i < tabla.length; i++) {
        tablaJunta.push(tabla[i].join(''));
    }

    return tablaJunta;
}

function verifyCoincidence(tablaGenerada, TablaGuardada) {
    let tableGeneratedJoin = addElementsInTable(tablaGenerada);
    let TableSavedJoin = addElementsInTable(TablaGuardada);

    let coincidence = 0;
    let stop = false;
    for (let indexGenerated = 0; indexGenerated < tableGeneratedJoin.length; indexGenerated++) {
        for (let indexSaved = 0; indexSaved < TableSavedJoin.length; indexSaved++) {
            if (tableGeneratedJoin[indexGenerated] === TableSavedJoin[indexSaved]) {
                coincidence++;
            }
        }

        if (coincidence > 1) {
            stop = true
            break;
        }
    }

    return stop
}

function splitUniverseInGroups4(universe){
    let universeDivido = []
    let arregloParcial = [];
    for (var i = 0; i < universe.length; i++) {
        arregloParcial.push(universe[i]);

        if (arregloParcial.length == 4) {
            universeDivido.push(arregloParcial);
            arregloParcial = [];
        }


    }

    return universeDivido;
}

function generateTables() {
  const allTables = generateAllTables(universeInGroups4);
  for (let i = 0; i < allTables.length; i++) {
      let newTicket;
      let stop = false;
      let coincidence = 0;

      newTicket = allTables[i];

      for (let indexTicket = 0; indexTicket < tickets.length; indexTicket++) {

          if(verifyCoincidence(newTicket, tickets[indexTicket])) {
              stop = true;
              break;
          }

      }

      if (stop) {
          continue;
      }

      tickets.push(newTicket);
  }
}

generateTables()

$("#tableSelected").hide();
$("#play").prop("disabled", true);

//Preparar todas las tablas
tickets.forEach((boleto, index) => {

    let ticket = boleto.flat();

    let numbers = '';
    ticket.forEach(number => {
        numbers += `<div class="col-sm-3 col-md-3 p-2 center">${number}</div>`;
    });

    element = `<div class="col-md-3 ticket rounded-3 border bg-dark text-light bg-gradient p-4 tableForPlay" id="${index}">
                    <div class="d-flex justify-content-between p-3">
                        <img src="assets/img/logo-2.png" alt="" width="100" height="30">
                        <h3>#${index+1}</h3>
                    </div>

                    <div class="row p-3 justify-content-center border rounded-3">`+
                    numbers+
                    `</div>
                </div>`;

    $("#tablesForPlay").append(element)
});


var indexGlobal;
$(".tableForPlay").click(function() {

    $('.tableForPlay').removeClass('table-selected');

    $(this).addClass('table-selected')

    $("#tableSelected").empty();

    indexGlobal = $(this).attr('id');

    $("#tableSelected").show();

    let ticket = tickets[indexGlobal].flat();

    let numbers = '';
    ticket.forEach(number => {
        numbers += `<div class="col-sm-3 col-md-3 p-2 center number cursor-pointer">${number}</div>`;
    });    



    let tableSelected = `<div class="row justify-content-center main-table" id="${indexGlobal}">
                            <div class="col-md-4 rounded-3 border bg-dark text-light bg-gradient p-4">
                                <div class="d-flex justify-content-between p-3">
                                    <img src="assets/img/logo-2.png" alt="" width="100" height="30">
                                    <h3>#${parseInt(indexGlobal)+1}</h3>
                                </div>

                                <div class="row p-3 justify-content-center border rounded-3">`+
                                numbers+
                                `</div>

                            </div>

                        </div>`;

    $("#tableSelected").append(tableSelected);

    $("#play").prop("disabled", false);

    $('html, body').animate({
      scrollTop: $('#top').offset().top
    }, 200);


});

/**
 * Método para sacar el número aleatorio y que no se pueda repetir
 */
const universeAux = universe;
function randomNumber(arr) {
    // Si el arreglo está vacío, retorna null
    if (arr.length === 0) return null;
    
    // Escoge un índice aleatorio dentro del rango del arreglo
    var indexRandom = Math.floor(Math.random() * arr.length);
    
    // Extrae y retorna el número correspondiente al índice aleatorio
    var numberRandom = arr[indexRandom];
    
    // Remueve el número seleccionado del arreglo para que no se repita
    universeAux.splice(indexRandom, 1);
    
    return numberRandom;
}

/**
 * Método para mostrar el número aleatorio
 */
var lastNumber;
function play() {
    var interval = setInterval(function(){
            $("#screenNumber").empty();
            lastNumber = randomNumber(universeAux)
            $("#screenNumber").append(`<h2>Ha salido el número ${lastNumber}</h2>`);

            let index;
            $("#tableSelected").children().each(function() {
                index = $(this).attr("id");
            });

            let ticket = tickets[index].flat();

            if (ticket.some(e => e == lastNumber)) {
                clearInterval(interval)
                $("#screenNumber").append(`Tienes el número ${lastNumber} ¡Dale click!`);
            }

            if (universeAux.length === 0) {
                clearInterval(interval)
                $("#screenNumber").empty();
                $("#screenNumber").append(`<h2>Termine</h2>`);
            }
    }, 1000)
}

/**
 * Método para iniciar el juego
 */
let number = '';
$("#play").click(function(){
    Swal.fire({
        title: 'Bienvenido!',
        text: 'Se va iniciar la lotería',
        icon: 'info',
        confirmButtonText: 'Iniciar'
    }).then((result) => {
        play();
        $(".initial-game").hide();

    });
});


/**
 * Método para seleccionar el número aleatorio que haya salido
 */
$("#tableSelected").on("click", ".number", function(){

    var number = this.textContent;
    if (lastNumber == number) {
        $(this).addClass('text-danger');
        play();   
    }

    if ($(`#${indexGlobal} .text-danger`).length == 16) {
        Swal.fire({
            title: 'Felicidades!',
            text: `Has ganado en ${128 - universeAux.length} intentos`,
            icon: 'success',
            confirmButtonText: 'Terminar'
        });
        clearInterval(interval)
        $("#screenNumber").empty();
        $("#screenNumber").append(`<h2>Has ganado en ${128 - universeAux.length} intentos</h2>`)
    }

    
});
</script>
