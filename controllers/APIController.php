<?php 

namespace Controllers;

use Model\Cita;
use Model\Servicio;
use Model\CitaServicio;


class APIController{
    public static function index(){
        $servicios=Servicio::all();
        echo json_encode($servicios);
    }


    public static function guardar(){
      //Almacena la cita y devuelve un Id
      $cita=new Cita($_POST);
      $resultado= $cita->guardar();
      
      

      //almacena las citas y el servicio con los id
      $id=$resultado['id'];
      //lo combierte en arreglo y lo separa por comas el string original que viene de la bd
      $idServicios=explode(",", $_POST['servicios']);

    foreach($idServicios as $idServicio){
      $args=[
        'citaId' => $id,
        'servicioId'=>$idServicio
      ];
      $citaServicio = new CitaServicio($args);
      $citaServicio->guardar();
    }

  
      echo json_encode(['resultado'=>$resultado]);
    }


    public static function eliminar(){

      if($_SERVER['REQUEST_METHOD']==='POST'){
        $id=$_POST['id'];
        $cita = Cita::find($id);
        $cita->eliminar();
        header('Location:' . $_SERVER['HTTP_REFERER']);
        
      }


    }

}

?>