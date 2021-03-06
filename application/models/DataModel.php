<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class DataModel extends CI_Model
{
    function __construct()
    {
        parent::__construct(); // construct the Model class
    }


    //Saludo de Bienvenida -- Home!
    public function saludo(){
        $data = array(
            'titulo'=> 'WebService',
            'mensaje'=> 'Gestión de servicios',
            'fecha' => date("Y-m-d H:i:s")
        );
        return $data;
    }

    //login
    public function sesionLocal($user,$pass){
        $query = $this->db->query("SELECT * FROM TB_USUARIOS WHERE email='$user' AND pws='$pass' AND estado=1  LIMIT 1");
        if($query->num_rows() == 0){
        return null;
        }else{
            //genera tokenDinamico
            $token=$this->generatePass(20);
        
            //inserta tokenDinamico y recupera info sesion Json
            foreach ($query->result() as $row){
                $this->db->query("update TB_USUARIOS set dinamico='$token' where id='$row->id' ");
                $data = array(
                  'id' => $row->id,
                  'username'  => $row->nombres,
                  'token' => $token
                );
            }
            return $data;
        } 
    }

    public function veryfyPermission($cargo,$controlador){
        $query = $this->db->query("SELECT COUNT(*) FROM TB_CARGO_PERMISO WHERE idCargo='$cargo' AND idPermiso='$controlador' ");
        return $query->result();
    }

    public function logout($id,$token){
        $query = $this->db->query("UPDATE TB_USUARIOS SET dinamico=null WHERE id='$id' AND dinamico='$token' ");
        return $query->result();
    }

    //usuario
    public function listarTrabajadores($idLocal){
        $query = $this->db->query("SELECT usr.id, usr.nombres  FROM TB_USUARIOS usr WHERE usr.idLocal='$idLocal' AND usr.id > 1  ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }  
    }


    
    //panel
    public function obtenerCargo($id,$token){
        $cargo=0;
        $query = $this->db->query("SELECT idCargo FROM TB_USUARIOS WHERE id='$id' AND dinamico='$token' LIMIT 1");
        if($query->num_rows() == 0){
            return null;
        }else{
            $cargo= $query->result();
            return $cargo[0]->idCargo;
        }  
    }

    public function obtenerPermisos($cargo){
        $query = $this->db->query("SELECT pr.icono,pr.descripcion,pr.controlador FROM TB_CARGO_PERMISO cgpr INNER JOIN TB_PERMISOS pr on pr.id=cgpr.idPermiso WHERE cgpr.idCargo='$cargo' ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }  
    }

    //locales
    public function LocalGroupList(){
        $query = $this->db->query("SELECT id,nombres,direccion,telefono, (CASE WHEN estado = 1 THEN 'Activo' ELSE 'Inactivo'END) AS 'estado' FROM TB_LOCALES");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }  
    }

    public function LocalSelectList(){
        $query = $this->db->query("SELECT id,nombres,direccion,telefono FROM TB_LOCALES WHERE estado='1' ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }  
    }

    public function insertaLocal($datos){
        $query = $this->db->insert('TB_LOCALES',$datos);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function buscaLoca($id){
        $query = $this->db->query("SELECT id,nombres,direccion,telefono,estado as 'idEstado',(CASE WHEN estado = 1 THEN 'Activo' ELSE 'Inactivo'END) AS 'estado' FROM TB_LOCALES WHERE id='$id' ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }  
    }

    public function actualizaLocal($id,$datos){
        $this->db->where('id',$id);
        return $this->db->update('TB_LOCALES',$datos);
    }

    //insumos
    public function insumoGroupList(){
        $query = $this->db->query("SELECT id,nombre,descripcion, (CASE WHEN estado = 1 THEN 'Activo' ELSE 'Inactivo'END) AS 'estado' FROM TB_INSUMOS");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }  
    }
    public function insumoSelectList(){
        $query = $this->db->query("SELECT id,nombre,descripcion FROM TB_INSUMOS WHERE estado='1' ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }  
    }
    public function insertaInsumo($datos){
        $query = $this->db->insert('TB_INSUMOS',$datos);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }
    public function buscaInsumo($id){
        $query = $this->db->query("SELECT id,nombre,descripcion,estado as 'idEstado',(CASE WHEN estado = 1 THEN 'Activo' ELSE 'Inactivo'END) AS 'estado' FROM TB_INSUMOS WHERE id='$id' ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }  
    }
    public function actualizaInsumo($id,$datos){
        $this->db->where('id',$id);
        return $this->db->update('TB_INSUMOS',$datos);
    }


    //Cargos
    public function cargosGroupList(){
        $query = $this->db->query("SELECT id,descripcion, (CASE WHEN estado = 1 THEN 'Activo' ELSE 'Inactivo'END) AS 'estado' FROM TB_CARGOS WHERE id > 2");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }  
    }
    public function cargosSelectList(){
        $query = $this->db->query("SELECT id,descripcion FROM TB_CARGOS WHERE estado='1' ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }  
    }
    public function insertacargo($datos){
        $query = $this->db->insert('TB_CARGOS',$datos);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }
    public function buscacargo($id){
        $query = $this->db->query("SELECT id,descripcion,estado as 'idEstado',(CASE WHEN estado = 1 THEN 'Activo' ELSE 'Inactivo'END) AS 'estado' FROM TB_CARGOS WHERE id='$id' ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }  
    }
    public function actualizacargo($id,$datos){
        $this->db->where('id',$id);
        return $this->db->update('TB_CARGOS',$datos);
    }


    //Permisos
    public function listarPermisos(){
        $query = $this->db->query("SELECT id,descripcion FROM TB_PERMISOS");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        } 
    }
    
    public function listaPermisosById($id){
        $query = $this->db->query("SELECT p.id,p.descripcion FROM TB_CARGO_PERMISO cp INNER JOIN TB_PERMISOS p on cp.idPermiso=p.id WHERE cp.idCargo='$id' ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        } 
    }

    public function insertaPermiso($datos){
        $query = $this->db->insert('TB_CARGO_PERMISO',$datos);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function buscaPermiso($idCargo,$idPermiso){
        $query = $this->db->query("SELECT count(*) as 'result' FROM TB_CARGO_PERMISO WHERE idCargo='$idCargo' AND idPermiso='$idPermiso' ");
        $rslt = $query->result();
        return $rslt[0]->result;
        
    }

    public function eliminaPermiso($idCargo,$idPermiso){
        $query = $this->db->query("DELETE FROM TB_CARGO_PERMISO WHERE idCargo='$idCargo' AND idPermiso='$idPermiso' ");
        return $query;
    }




    //Personal
    public function listaPersonal(){
        $query = $this->db->query("SELECT u.id,u.nombres,c.descripcion as 'cargo',l.nombres 
                                    as 'local',u.email,u.telefono,(CASE WHEN u.estado = 1 
                                                                    THEN 'Activo' ELSE 'Inactivo'END) AS 'estado' 
                                    FROM TB_USUARIOS u 
                                    INNER JOIN TB_CARGOS c on u.idCargo=c.id 
                                    INNER JOIN TB_LOCALES l on u.idLocal=l.id
                                    WHERE u.id > 1");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        } 
    }

    public function agregarUsuario($datos){
        $query = $this->db->insert('TB_USUARIOS',$datos);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function listaPersonalByLocal($local){
        $query = $this->db->query("SELECT u.id,u.nombres,c.descripcion as 'cargo'
                                    FROM TB_USUARIOS u 
                                    INNER JOIN TB_CARGOS c on u.idCargo=c.id 
                                    INNER JOIN TB_LOCALES l on u.idLocal=l.id
                                    WHERE u.idLocal='$local' AND u.id > 1");
        $result =[];
        $hoy=date("Y-m-d");
        foreach ($query->result() as $row){
            $datos = array(
                'id' => $row->id,
                'nombres'  => $row->nombres,
                'cargo' => $row->cargo,
                'reporte'=>$this->minRepoAsistencia($row->id,$hoy)
            );
            array_push($result,$datos);
        return $result;
        }
    }

    public function minRepoAsistencia($id,$date){
        $respuesta="";
        $query = $this->db->query("SELECT count(*) as 'result' FROM TB_ASISTENCIAS WHERE idUsuario='$id' AND fecha='$date' ");
        $rslt = $query->result();
        if($rslt[0]->result==0){
            $respuesta="Inasistencia";
        }else{
            $respuesta="Asistencia";
        }
        return $respuesta;
    }

    public function listaUsuarioById($id){
        $query = $this->db->query("SELECT u.id,u.nombres,u.idCargo,c.descripcion,u.idLocal,l.nombres as 'local',
                                          u.email,u.telefono,u.estado as 'idEstado',
                                          (CASE WHEN u.estado = 1 THEN 'Activo' ELSE'Inactivo'END) AS 'estado' 
                                    FROM TB_USUARIOS u 
                                    INNER JOIN TB_CARGOS c on u.idCargo=c.id 
                                    INNER JOIN TB_LOCALES l on u.idLocal=l.id
                                    WHERE u.id='$id' ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        } 
    }

    public function buscaUsuario($mail){
        $query = $this->db->query("SELECT count(*) as 'result' FROM TB_USUARIOS WHERE email='$mail' ");
        $rslt = $query->result();
        return $rslt[0]->result;
    }

    public function actualizaUsuario($id,$datos){
        $this->db->where('id',$id);
        return $this->db->update('TB_USUARIOS',$datos);
    }

    //clientes
    public function listGroupCliente(){
        $query = $this->db->query("SELECT id,nombres,email,telefono FROM TB_CLIENTES");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        } 
    }

    public function listSelectCliente(){
        $query = $this->db->query("SELECT id,nombres FROM TB_CLIENTES");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        } 
    }

    public function insertaCliente($datos){
        $query = $this->db->insert('TB_CLIENTES',$datos);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function buscaClienteById($id){
        $query = $this->db->query("SELECT id,nombres,email,telefono FROM TB_CLIENTES WHERE id='$id' ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        } 
    }

    public function actualizaClienteById($id,$datos){
        $this->db->where('id',$id);
        return $this->db->update('TB_CLIENTES',$datos);
    }

    public function existeCliente($mail){
        $query = $this->db->query("SELECT count(*) as 'result' FROM TB_CLIENTES WHERE email='$mail' ");
        $rslt = $query->result();
        return $rslt[0]->result;
    }

    //Tareas
    public function listarTareas($date){
        $query = $this->db->query("SELECT trs.id,lcl.nombres as 'local',cl.nombres as 'cliente',
                                    trs.fecha,
                                    (CASE 
                                        WHEN trs.estado = 1 THEN 'Ingresada' 
                                        WHEN trs.estado = 2 THEN 'Finalizada'
                                        ELSE'Cancelado'
                                    END) AS 'estado' 
                                    FROM TB_TAREAS trs 
                                    INNER JOIN TB_LOCALES lcl on trs.idLocal=lcl.id 
                                    INNER JOIN TB_CLIENTES cl on trs.idCliente=cl.id
                                    WHERE trs.fecha='$date' ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        } 
    }

    public function insertaTarea($datos){
        $query = $this->db->insert('TB_TAREAS',$datos);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function buscaestadoTarea($idTarea){
        $estado=0;
        $query = $this->db->query("SELECT estado FROM TB_TAREAS WHERE id='$idTarea' ");
        if($query->num_rows() == 0){
            return null;
        }else{
            $estado= $query->result();
            return $estado[0]->estado;
        } 
    }

    public function updateTarea($id,$datos){
        $this->db->where('id',$id);
        return $this->db->update('TB_TAREAS',$datos);
    }

    public function buscaTarea($fecha,$hora,$local,$cliente){
        $estado=0;
        $query = $this->db->query("SELECT id as 'result' FROM TB_TAREAS WHERE idLocal='$local' AND idCliente='$cliente' AND fecha='$fecha' AND hora='$hora'  ");
        if($query->num_rows() == 0){
            return null;
        }else{
            $estado= $query->result();
            return $estado[0]->result;
        } 
    }

    //servicios

    public function insertaServiciosTarea($datos){
        $query = $this->db->insert('TB_TAREA_SERVICIO',$datos);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function obtenerValorServicio($idServicio){
        $valor=0;
        $query = $this->db->query(" SELECT costo FROM TB_SERVICIOS where id='$idServicio' ");
        if($query->num_rows() == 0){
            return $valor;
        }else{
            $valor= $query->result();
            return $valor[0]->costo;
        }  
    }

    public function buscaTareaById($id){
        $query = $this->db->query(" SELECT id,idLocal,idCliente,fecha,estado FROM TB_TAREAS WHERE id='$id'  ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }
    }

    public function buscaServiciosTareaById($idTarea){
        $query = $this->db->query(" SELECT trSr.idTarea as 'idTarea',trSr.idServicio  as 'idServicio' ,srv.descripcion FROM TB_TAREA_SERVICIO trSr INNER JOIN TB_SERVICIOS srv ON trSr.idServicio=srv.id WHERE idTarea='$idTarea'  ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }
    }

    public function eliminaServicioTarea($idTarea,$idServicio){
        $query = $this->db->query("DELETE FROM TB_TAREA_SERVICIO WHERE idTarea='$idTarea' AND idServicio='$idServicio' ");
        return $query;
    }

    public function obtenerLocal($id){
        $cargo=0;
        $query = $this->db->query("SELECT idLocal FROM TB_USUARIOS WHERE id='$id' ");
        if($query->num_rows() == 0){
            return null;
        }else{
            $cargo= $query->result();
            return $cargo[0]->idLocal;
        }  
    }

    public function resumenTotalTarea($idTarea){
        $query = $this->db->query("SELECT sr.descripcion as 'servicio',cat.descripcion as 'categoria',sr.costo 
                                    FROM TB_TAREA_SERVICIO trSr INNER JOIN TB_SERVICIOS sr on sr.id=trSr.idServicio 
                                    INNER JOIN TB_CATEGORIA_PRECIO_SERVICIO cat ON cat.id=sr.idCategoriaPrecio 
                                    WHERE idTarea='$idTarea' ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }
    }

    public function montoTotalTarea($idTarea){
        $total=0;
        $subTotal=0;
        $igv=0.18;
        $query = $this->db->query("SELECT trSr.valor 
                                    FROM TB_TAREA_SERVICIO trSr 
                                    WHERE trSr.idTarea = '$idTarea' ");
        foreach ($query->result() as $row){
            $total=$total+$row->valor;
        }
        $igv=($total * $igv);
        $subTotal=($total - $igv);
        $data=array(
            'total'=>$total,
            'subtotal'=>$subTotal,
            'igv'=>number_format($igv,2)
        );
        return $data;
    }

    public function agregaTrabajadorToTarea($datos){
        $query = $this->db->insert('TB_USUARIO_TAREA',$datos);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function listarTrabajadoresDeTarea($idTarea){
        $query = $this->db->query(" SELECT ustr.idTarea as 'tarea',us.id as 'idUser',us.nombres 
                                    FROM TB_USUARIO_TAREA usTr INNER JOIN TB_USUARIOS us 
                                    ON us.id=ustr.idUsuario  
                                    WHERE ustr.idTarea='$idTarea'  ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }
    }

    public function eliminaTrabajadorDeTarea($idTarea,$idTrabajador){
        $query = $this->db->query("DELETE FROM TB_USUARIO_TAREA WHERE idTarea='$idTarea' AND idUsuario='$idTrabajador' ");
        return $query;
    }

    public function buscarDatosBoleta($idTarea){
        $query = $this->db->query(" SELECT serie,numero,fechaRegistro FROM TB_COMPROBANTE WHERE idTarea='$idTarea'  ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }
    }

    public function insertaBoleta($datos){
        $query = $this->db->insert('TB_COMPROBANTE',$datos);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }
    public function buscaBoleta($idTarea){
        $query = $this->db->query("SELECT COUNT(*) as 'result' FROM TB_COMPROBANTE WHERE idTarea='$idTarea' ");
        $rslt = $query->result();
        return $rslt[0]->result;
    }

    

    //Servicios

    public function listaTipoPrecio(){
        $query = $this->db->query("SELECT id,descripcion FROM TB_CATEGORIA_PRECIO_SERVICIO");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        } 
    }

    public function listarServicios(){
        $query = $this->db->query("SELECT srv.id,srv.descripcion,cat.descripcion as 'categoria',
                                srv.costo,
                                (CASE WHEN srv.estado = 1 THEN 'Activo' 
                                      WHEN srv.estado= 0 THEN 'Cancelado' 
                                ELSE'Finalizado'END) AS 'estado'
                                FROM TB_SERVICIOS srv INNER JOIN TB_CATEGORIA_PRECIO_SERVICIO 
                                cat on srv.idCategoriaPrecio=cat.id ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        } 
    }

    public function selectListServicio(){
        $query = $this->db->query("SELECT srv.id,srv.descripcion as 'servicio',cat.descripcion as 'categoria',srv.costo 
                                    FROM TB_SERVICIOS srv INNER JOIN TB_CATEGORIA_PRECIO_SERVICIO cat on 
                                    srv.idCategoriaPrecio=cat.id WHERE estado > 0");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        } 
    }

    public function insertaServicio($datos){
        $query = $this->db->insert('TB_SERVICIOS',$datos);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function buscaServicioById($id){
        $query = $this->db->query("SELECT id,descripcion,idCategoriaPrecio,costo,estado FROM TB_SERVICIOS WHERE id='$id' ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        } 
    }

    public function actualizaServicio($id,$datos){
        $this->db->where('id',$id);
        return $this->db->update('TB_SERVICIOS',$datos);
    }

    public function agregarInsumoServicio($datos){
        $query = $this->db->insert('TB_SERVICIO_INSUMO',$datos);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function eliminaInsumoServicio($idServicio,$idInsumo){
        $query = $this->db->query("DELETE FROM TB_SERVICIO_INSUMO WHERE idServicio='$idServicio' AND idInsumo='$idInsumo' ");
        return $query;
    }

    public function listarInsmoServicio($idServicio){
        $query = $this->db->query("SELECT srIn.idServicio as 'idServicio',ins.id as 'idInsumo',ins.nombre,ins.descripcion  
                                  FROM TB_SERVICIO_INSUMO srIn INNER JOIN TB_INSUMOS ins on ins.id=srIn.idInsumo 
                                  WHERE srIn.idServicio='$idServicio' ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        } 
    }

    //asistencia
    public function listarAsistenciadelDia($fecha){
        $query = $this->db->query(" SELECT us.nombres,cr.descripcion as 'cargo',
                                            lc.nombres as 'local',
                                            asis.fecha, asis.entrada, asis.salida 
                                    FROM TB_ASISTENCIAS as asis 
                                    INNER JOIN TB_USUARIOS us ON asis.idUsuario = us.id
                                    INNER JOIN TB_LOCALES lc ON lc.id=us.idLocal
                                    INNER JOIN TB_CARGOS cr ON us.idCargo=cr.id 
                                    WHERE asis.fecha='$fecha' ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }
    }

    public function buscaAsistencia($idUser,$date){
        $query = $this->db->query("SELECT count(*) as 'result' FROM TB_ASISTENCIAS WHERE idUsuario='$idUser' AND fecha='$date'");
        $rslt = $query->result();
        return $rslt[0]->result;
    }

    public function registrarAsistencia($datos){
        $query = $this->db->insert('TB_ASISTENCIAS',$datos);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function actualizaAsistencia($idUser,$date,$datos){      
        $this->db->where('idUsuario',$idUser);
        $this->db->where('fecha',$date);
        return $this->db->update('TB_ASISTENCIAS',$datos);
    }

    //reportes
    public function listaTrabajadorReporte($mes){
        $result=[];
        $query = $this->db->query("SELECT usr.id, usr.nombres as 'usuario', lc.nombres as 'local',
                                    cr.descripcion as 'cargo' 
                                    FROM TB_USUARIOS usr
                                    INNER JOIN TB_LOCALES lc ON lc.id=usr.idLocal
                                    INNER JOIN TB_CARGOS cr ON cr.id=usr.idCargo
                                    WHERE usr.id > 1  ");
        foreach ($query->result() as $row){
            $data=array(
                'usuario' => $row->usuario,
                'local'=> $row->local,
                'cargo'=>$row->cargo,
                'actividad'=>$this->reporteActividadTrabajador($row->id,$mes)
            );
            array_push($result,$data);
        }
        return $result;
    }
    public function reporteActividadTrabajador($idUser,$mes){
        $query = $this->db->query("SELECT count(*) as 'result' FROM TB_USUARIO_TAREA usTr
                                    INNER JOIN TB_TAREAS tr ON tr.id=usTr.idTarea
                                    WHERE usTr.idUsuario='$idUser' 
                                    AND MONTH(tr.fecha) ='$mes'
                                    AND tr.estado='2' ");
        $rslt = $query->result();
        return $rslt[0]->result;
    }
    public function listaLocalesReporte($mes){
        $result=[];
        $query = $this->db->query(" SELECT lc.id,lc.nombres,lc.direccion 
                                    FROM TB_LOCALES lc 
                                    WHERE estado = 1 ");
        foreach ($query->result() as $row){
            $data=array(
                'id' => $row->id,
                'nombre'=> $row->nombres,
                'direccion'=>$row->direccion,
                'actividad'=>$this->reporteActividadLocal($row->id,$mes)
            );
            array_push($result,$data);
        }
        return $result;
    }
    public function reporteActividadLocal($idLocal,$mes){
        $query = $this->db->query("SELECT count(*) as 'result' FROM TB_TAREAS tr 
                                    WHERE idLocal='$idLocal' AND tr.estado='2' 
                                    AND MONTH(tr.fecha)='$mes' ");
        $rslt = $query->result();
        return $rslt[0]->result;
    }

    //reservas
    public function listarReservas(){
        $query = $this->db->query(" SELECT rs.id,cl.nombres,cl.email,cl.telefono,lc.nombres as 'local',
                                    rs.fechaAtencion,rs.horaAtencion,fechaRegistro 
                                    FROM TB_RESERVAS rs 
                                    INNER JOIN TB_CLIENTES cl on rs.idCliente=cl.id 
                                    INNER JOIN TB_LOCALES lc ON lc.id=rs.idLocal 
                                    WHERE rs.estado=1 ");
        if($query->num_rows() == 0){
        return null;
        }else{
        return $query->result();
        }
    }

    public function agregarReserva(){
        $query = $this->db->insert('TB_RESERVAS',$datos);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function agregaServiciosReseva(){
        $query = $this->db->insert('TB_SERVICIO_RESERVA',$datos);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function updateReserva($id,$data){
        $this->db->where('id',$id);
        return $this->db->update('TB_RESERVAS',$data);
    }

    public function aceptaReserva($id){
        try {
            //inserta cabecera(reserva a tarea)
            $query = $this->db->query(" SELECT rs.idLocal as 'local',rs.idCliente as 'cliente', rs.fechaAtencion,
                                        rs.horaAtencion  
                                        FROM TB_RESERVAS rs 
                                        WHERE rs.id='$id' AND estado = 1");
            foreach ($query->result() as $row){
                $cabecera=array(
                'idLocal'=>$row->local,
                'idCliente'=>$row->cliente,
                'fecha'=>$row->fechaAtencion,
                'hora'=>$row->horaAtencion
                );    
            }
            $this->insertaTarea($cabecera);
            //busca idTarea
            $idTarea=$this->buscaTarea($cabecera['fecha'],$cabecera['hora'],$cabecera['idLocal'],$cabecera['idCliente']);
            
            //inserta servicios
            $query = $this->db->query(" SELECT idServicio FROM TB_SERVICIO_RESERVA WHERE idReserva='$id' ");
            foreach ($query->result() as $row){
            $data=array(
            'idServicio'=>$row->idServicio,
            'idTarea'=>$idTarea,
            'valor' =>$this->obtenerValorServicio($row->idServicio)
            );
            $this->insertaServiciosTarea($data);
            }
            //actualiza reserva
            $estRes=array(
            'estado'=>'2'
            );
            $this->updateReserva($id,$estRes);
            return true;
        }catch(Exception $e){
            return $e;
        }
    }
    
    //web
    public function infoWeb(){
        $query = $this->db->query(" SELECT id,titulo,descripcion,orden FROM TB_WEB_INFO ORDER BY orden ");
        return $query->result(); 
    }
    
    public function agregarInfoWeb($datos){
        $query = $this->db->insert('TB_WEB_INFO',$datos);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function inforWebById($id){
        $query = $this->db->query(" SELECT id,titulo,descripcion,orden FROM TB_WEB_INFO WHERE id='$id' ");
        return $query->result(); 
    }
    
    public function  updateInfoWeb($id,$datos){
        $this->db->where('id',$id);
        return $this->db->update('TB_WEB_INFO',$datos);
    }
    
    public function deleteInfoWeb($id){
        $this->db->where('id', $id);
        $this->db->delete('TB_WEB_INFO');
    }
    
    public function contactoWeb($id){
        $query = $this->db->query(" SELECT numero,mail,facebook,instagram FROM TB_WEB_CONTACTO WHERE id='$id' ");
        return $query->result(); 
    }
    
    public function  updateContactoWeb($id,$datos){
        $this->db->where('id',$id);
        return $this->db->update('TB_WEB_CONTACTO',$datos);
    }

    /*
    $result=[];
        $query = $this->db->query(" SELECT lc.id,lc.nombres,lc.direccion 
                                    FROM TB_LOCALES lc 
                                    WHERE estado = 1 ");
        foreach ($query->result() as $row){
            $data=array(
                'id' => $row->id,
                'nombre'=> $row->nombres,
                'direccion'=>$row->direccion,
                'actividad'=>$this->reporteActividadLocal($row->id,$mes)
            );
            array_push($result,$data);
        }
        return $result;
    */
   

    

    /*
    foreach ($query->result() as $row){
                $this->db->query("update TB_USUARIOS set dinamico='$token' where id='$row->id' ");
                $data = array(
                  'id' => $row->id,
                  'username'  => $row->nombres,
                  'token' => $token
                );
            }
            return $data;
    */









    //generarTextos
    public function generatePass($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}
