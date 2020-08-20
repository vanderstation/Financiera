<!DOCTYPE html>
<html lang="en">
    <?php include_once './vistas/modulos/head.php'; ?>
    <body>
        <?php 
           include_once './controladores/vistasControlador.php';
           $vistasControlador = new vistasControlador();
           $vistas = $vistasControlador->obtenerVistaControlador();
           if($vistas == "login" || $vistas =="404"){
               require_once "./vistas/contenidos/".$vistas."-view.php";
           }else{
                          
        ?>
        <!-- begin #page-loader -->
        <div id="page-loader" class="fade show">
            <span class="spinner"></span>
        </div>
        <!-- end #page-loader -->

        <!-- begin #page-container -->
        <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
            <!-- begin #header -->
            <?php include_once './vistas/modulos/header.php'; ?>
            <!-- end #header -->
            <!-- begin #sidebar -->
            <?php include_once './vistas/modulos/sidebar.php'; ?>
            <!-- end #sidebar -->

            <!-- begin #content -->
            <div id="content" class="content">
                <!-- begin breadcrumb -->
                <ol class="breadcrumb float-xl-right">
                    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Dashboard <small>header small text goes here...</small></h1>
                <!-- end page-header -->
                <div class="row">
                    <?php include_once $vistas;?>
                </div>
                <!-- end row -->
            </div>
            <!-- end #content -->

            <!-- begin theme-panel -->
            
            <!-- end theme-panel -->

            <!-- begin scroll to top btn -->
            <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
            <!-- end scroll to top btn -->
        </div>
           <?php } ?>
        <!-- end page container -->
           <?php include_once './vistas/modulos/script.php'; ?>
    </body>
</html>


