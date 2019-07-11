<?php

ini_set("display_errors","1");
ob_start();
session_name('cadenas');
@session_start();
if(!isset($_SESSION["login"]) or empty($_SESSION["login"])){
    die("No has iniciado sesion <a href=\"logout.php\">Regresar</a>");
}


include("../DB/conexion.php");

$con = conexion();

if($con === FALSE){
  die(print_r(sqlsrv_errors(), TRUE));
}




include "header.php";

?>

  <style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      
      margin: auto;
  }
  </style>


<!--   <div class="btn-floating" id="help-actions">
  <div class="btn-bg"></div>
  <button type="button" class="btn btn-default btn-toggle" data-toggle="toggle" data-target="#help-actions">
    <i class="icon fa fa-plus"></i>
    <span class="help-text">Shortcut</span>
  </button>
  <div class="toggle-content">
    <ul class="actions">
      <li><a href="#">Website</a></li>
      <li><a href="#">Documentation</a></li>
      <li><a href="#">Issues</a></li>
      <li><a href="#">About</a></li>
    </ul>
  </div>
</div> -->

    <!-- INICIO CUERPO DE LA PAGINA -->
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <a class="card card-banner card-green-light">
            <div class="card-body">
              <i class="icon fa fa-shopping-basket fa-4x"></i>
              <div class="content">
                <div class="title">Partincipacion Claro Tiempo Aire</div>
                <?php
                    $sql_participacion = "select round((SUM(ta_claro)/SUM(ta_tigo+ta_claro+ta_movistar+ta_digicel))*100,0) participacion
                    FROM [ENCUESTA_CADENAS].[dbo].[CMC_ENCUESTA_MARKET_SHARE]
                    where CONVERT(varchar(6),fecha,112) = 201701";

                    $rs_participacion = sqlsrv_query($con, $sql_participacion);

                    if($rs_participacion === FALSE){
                        die(print_r(sqlsrv_errors(), TRUE));
                    }


                    $row = sqlsrv_fetch_array($rs_participacion, SQLSRV_FETCH_ASSOC);

                    echo '<div class="value"><span class="sign"></span>'.$row['participacion'].'%</div>';
                ?>
                
              </div>
            </div>
          </a>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <a class="card card-banner card-blue-light">
            <div class="card-body">
              <i class="icon fa fa-home fa-4x"></i>
              <div class="content">
                <div class="title">Más cambio POP</div>
                <?php
                    $sql_estado_pop = "select top 1 Distribuidor, estado, count(*) cantidad 
                    FROM [ENCUESTA_CADENAS].[dbo].[CMC_ENCUESTA_POP] a
                    inner join (SELECT distinct distribuidor, pdv FROM [172.23.8.153].[CMC_ALTAS_PREPAGO].[dbo].[PDVS_CADENAS]) b
                    on a.pdv = b.pdv
                    where estado = 3
                    and convert(varchar(6),fecha,112) = 201701
                    group by Distribuidor, estado
                    order by 2 desc,3 desc";

                    $rs_estado_pop = sqlsrv_query($con, $sql_estado_pop);

                    if($rs_estado_pop === FALSE){
                        die(print_r(sqlsrv_errors(), TRUE));
                    }


                    $row = sqlsrv_fetch_array($rs_estado_pop, SQLSRV_FETCH_ASSOC);

                    echo '<div class="value"><span class="sign"></span>'.$row['Distribuidor'].'</div>';
                ?>
                
              </div>
            </div>
          </a>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-mini">
          <div class="card-header">
            <div class="card-title">Galeria POP</div>
            <ul class="card-action">
              <li>
                <a href="#">
                  <i class="fa fa-refresh"></i>
                </a>
              </li>
            </ul>
          </div>
          <div class="card-body">              
              <div id="carousel-example-generic" class="carousel slides" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">

                  <?php
                    $sql_conteo = "select top 10 b.pdv, a.nombre_foto_pop  
                    FROM [ENCUESTA_CADENAS].[dbo].[CMC_IMAGEN_POP] a
                    inner join [ENCUESTA_CADENAS].[dbo].[CMC_ENCUESTA_POP] b
                    on a.id_encuesta_pop = b.id
                    where convert(varchar(6),b.fecha,112) = 201701";

                    $rs_conteo = sqlsrv_query($con, $sql_conteo);

                    if($rs_conteo === FALSE){
                        die(print_r(sqlsrv_errors(), TRUE));
                    }

                    $i = 0;

                    while($row = sqlsrv_fetch_array($rs_conteo, SQLSRV_FETCH_ASSOC)){

                        if ($i == 0)
                        {
                          echo'<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>';
                        }
                        else
                        {
                          echo'<li data-target="#carousel-example-generic" data-slide-to="'.$i.'"></li>';  
                        }   

                        $i++;

                        
                                           
                    }

                    
                ?>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                  <?php

                    $sql_ = "select top 10 b.pdv, a.nombre_foto_pop  
                    FROM [ENCUESTA_CADENAS].[dbo].[CMC_IMAGEN_POP] a
                    inner join [ENCUESTA_CADENAS].[dbo].[CMC_ENCUESTA_POP] b
                    on a.id_encuesta_pop = b.id
                    where convert(varchar(6),b.fecha,112) = 201701
                    order by newid()";

                    $rs_conteo = sqlsrv_query($con, $sql_conteo);

                    if($rs_conteo === FALSE){
                        die(print_r(sqlsrv_errors(), TRUE));
                    }

                    $i = 0;
                    while($row = sqlsrv_fetch_array($rs_conteo, SQLSRV_FETCH_ASSOC)){

                        if ($i == 0)
                        {
                          echo'<div class="item active">
                                <img src="capturas/'.$row['nombre_foto_pop'].'.jpg" alt="'.$row['nombre_foto_pop'].'">
                                <div class="carousel-caption">
                                  <h4>'.$row['pdv'].'</h4>
                                </div>
                              </div>';
                        }
                        else
                        {
                          echo'<div class="item">
                                <img src="capturas/'.$row['nombre_foto_pop'].'.jpg" alt="'.$row['nombre_foto_pop'].'">
                                <div class="carousel-caption">
                                  <h4>'.$row['pdv'].'</h4>
                                </div>
                              </div>';  
                        }  

                         $i++; 
                                           
                    }

                    ?>
           
                                    
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
          </div>  
        </div>
      </div>
    </div>

     


    <!-- FIN DEL CUERPO DE LA PAGINA -->


<?php
include "footer.php";
?>


<script type="text/javascript">

  $( document ).ready(function() {


        $('.carousel').carousel({
          interval: 4000
        })

});


</script>