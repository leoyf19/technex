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
  <main id="main">

    <div class="d-flex justify-content-center align-items-center p-5">
        <div class="card mb-3">
            <img src="assets/img/parcial.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Parcial</h5>
                <p class="card-text">Para ver el resultado presionar F12, ir a consola y presionar ejecutar algoritmo</p>
                <button id="launch" class="btn btn-primary">Ejecutar algoritmo</button>
                <a href="assets/pdf/diagrama-1.pdf" class="btn btn-primary">Clic para ver el diagrama</a>
            </div>
        </div>
    </div>

  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include_once('components/footer.php') ?>
  <!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

</body>

</html>
<script>
const universo = Array.from({ length: 128 }, (_, index) => index + 1);
const universoGrupos4 = separarUniversoEnArreglos4(universo);
const boletos = [];

function generarTodasLasCombinaciones(numeros) {
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

function juntarElementosTabla (tabla){
    tablaJunta = [];
    for (var i = 0; i < tabla.length; i++) {
        tablaJunta.push(tabla[i].join(''));
    }

    return tablaJunta;
}

function verificarCoincidencia(tablaGenerada, TablaGuardada) {
    let tablaGeneradaJunta = juntarElementosTabla(tablaGenerada);
    let tablaGuardadaJunta = juntarElementosTabla(TablaGuardada);

    let coincidencia = 0;
    let stop = false;
    for (let indiceGenerada = 0; indiceGenerada < tablaGeneradaJunta.length; indiceGenerada++) {
        for (let indiceGuardada = 0; indiceGuardada < tablaGuardadaJunta.length; indiceGuardada++) {
            if (tablaGeneradaJunta[indiceGenerada] === tablaGuardadaJunta[indiceGuardada]) {
                coincidencia++;
            }
        }

        if (coincidencia > 1) {
            stop = true
            break;
        }
    }

    return stop
}

function separarUniversoEnArreglos4(universo){
    let universoDivido = []
    let arregloParcial = [];
    for (var i = 0; i < universo.length; i++) {
        // universoDivido.push(universo.slice(i, i + maximoEnArreglo));
        arregloParcial.push(universo[i]);

        if (arregloParcial.length == 4) {
            universoDivido.push(arregloParcial);
            arregloParcial = [];
        }


    }

    return universoDivido;
}

function generateTables() {
  const posiblesCombinaciones = generarTodasLasCombinaciones(universoGrupos4);
  for (let i = 0; i < posiblesCombinaciones.length; i++) {
      let nuevoBoleto;
      let stop = false;
      let coincidencia = 0;

      nuevoBoleto = posiblesCombinaciones[i];

      for (let indiceBoletos = 0; indiceBoletos < boletos.length; indiceBoletos++) {

          if(verificarCoincidencia(nuevoBoleto, boletos[indiceBoletos])) {
              stop = true;
              break;
          }

      }

      if (stop) {
          continue;
      }

      boletos.push(nuevoBoleto);
  }

  console.log(boletos);
}

// Selecciona el botón por su ID
var launch = document.getElementById("launch");

//Ejecutamos el evento
launch.onclick = function() {
    generateTables();
};

</script>

<!-- ======= Scripts ======= -->
<?php include_once('assets/js/js.php') ?>
<!-- ============== -->
