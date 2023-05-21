<?php
//Establecemos el nombre de espacio donde se trabaja
namespace Models;
//Requerimos la conexion
require_once "Conexion.php";
//Usamos las clases de conexion
use Models\Conexion;
//Creamos la clase y lo extendemos a la Conexion
class Producto extends Conexion{
    //Definimos sus atributos de la clase
    private int $id;
    private int $idBodega;
    private int $idMarca;
    private string $idCategorias;
    private string $nombre;
    private string $descripcion;
    private float $stock;
    private float $stockMinimo;
    private float $precioCompra;
    private float $precioVenta;
    private float $descuento;
    private string $img;
    private int $estado;
    //Definimos su método agregar
    public function agregar()
    {
        //Obtenemos la conexión
        $cn = $this->conectar();
        //Llamamos a nuestro SP
        $stmt = $cn->prepare("CALL SP_C_T_PRODUCTOS (?,?,?,?,?,?,?,?,?,?,?)");
        //Establecemos los parametros
        $stmt->bind_param('iissdddddss',$this->idBodega,$this->idMarca,$this->nombre,$this->descripcion,$this->stock,$this->stockMinimo,$this->precioCompra,$this->precioVenta,$this->descuento,$this->img,$this->idCategorias);
        //Ejecutamos nuestro SP
        $stmt->execute();
        //Definimos si nos a dado error
        $response = $stmt->error == '' ? ['success' => 'producto agregado correctamente'] : ['error' => 'el producto no se agrego'];
        //Cerremos la consulta
        $stmt->close();
        //Retornamos la variable de respuesta
        return $response;
    }
    //Definimos su método mostrar
    public function mostrar()
    {
        //Obtenemos la conexión
        $cn = $this->conectar();
        //Llamamos a nuestro SP
        $stmt = $cn->prepare("CALL SP_R_T_PRODUCTOS()");
        //Ejecutamos nuestro SP
        $stmt->execute();
        //Como es un SELECT obtenemos los resultados
        $rs = $stmt->get_result();
        //Definimos la variable en donde se retornaran los datos
        $result = [];
        //Recorremos los resultados
        while ($result[] = $rs->fetch_assoc());
        //Eliminamos la ultima posición del arreglo ya que es nula
        array_pop($result);
        //Cerremos la consulta
        $stmt->close();
        //Retornamos los datos
        return $result;
    }
    //Definimos su método eliminar
    public function eliminar()
    {
        //Obtenemos la conexión
        $cn = $this->conectar();
        //Llamamos a nuestro SP
        $stmt = $cn->prepare("CALL SP_D_T_PRODUCTOS(?,?)");
        //Establecemos los parametros
        $stmt->bind_param("ii",$this->id,$this->idBodega);
        //Ejecutamos nuestro SP
        $stmt->execute();
        //Definimos si nos a dado error
        $response = $stmt->error == '' ? ['success' => 'Producto eliminado correctamente'] : ['error' => 'El producto no se eliminó'];
        //Cerremos la consulta
        $stmt->close();
        //Retornamos la variable de respuesta
        return $response;
    }
    //Definimos su método actualizar
    public function actualizar()
    {
        //Obtenemos la conexión
        $cn = $this->conectar();
        //Llamamos a nuestro SP
        $stmt = $cn->prepare("CALL SP_D_T_PRODUCTOS(?,?,?,?,?,?,?,?,?,?,?,?)");
        //Establecemos los parametros
        $stmt->bind_param("iiissdddddss",$this->id,$this->idBodega, $this->idMarca, $this->nombre, $this->descripcion, $this->stock, $this->stockMinimo, $this->precioCompra, $this->precioVenta, $this->descuento, $this->img, $this->idCategorias);
        //Ejecutamos nuestro SP
        $stmt->execute();
        //Definimos si nos a dado error
        $response = $stmt->error == '' ? ['success' => 'Producto actualizado correctamente'] : ['error' => 'El producto no se actualizó'];
        //Cerremos la consulta
        $stmt->close();
        //Retornamos la variable de respuesta
        return $response;
    }
    public function verProductosClientes(string $producto,string $categorias,string $marcas,string $ordenar)
    {
        $cn = $this->conectar();
        $stmt = $cn->prepare("CALL SP_R_T_PRODUCTOS_COMPRAS(?,?,?,?)");
        $stmt->bind_param("ssss",$producto,$ordenar,$categorias,$marcas);
        $stmt->execute();
        $rs = $stmt->get_result();
        $result = [];
        while ($result[] = $rs->fetch_assoc());
        array_pop($result);
        $stmt->close();
        return $result;
    }
    public function verProductosClientesCarrito(string $idProductos)
    {
        $cn = $this->conectar();
        $stmt = $cn->prepare("CALL SP_R_T_PRODUCTOS_COMPRAS_CARRITO(?)");
        $stmt->bind_param("s",$idProductos);
        $stmt->execute();
        $rs = $stmt->get_result();
        $result = [];
        while ($result[] = $rs->fetch_assoc());
        array_pop($result);
        $stmt->close();
        return $result;
    }
    public function setId(int $idProducto)
    {
        $this->id = $idProducto;
    }
    public function setIdCategoriasJson(string $idCategorias)
    {
        $this->idCategorias = $idCategorias;
    }
    public function setIdBodega(int $idBodega)
    {
        $this->idBodega = $idBodega;
    }
    public function setIdMarca(int $idMarca)
    {
        $this->idMarca = $idMarca;
    }
    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }
    public function setDescripcion(string $descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function setStock(float $stock)
    {
        $this->stock = $stock;
    }
    public function setStockMinimo(float $stockMinimo)
    {
        $this->stockMinimo = $stockMinimo;
    }
    public function setPrecioCompra(float $precioCompra)
    {
        $this->precioCompra = $precioCompra;
    }
    public function setPrecioVenta(float $precioVenta)
    {
        $this->precioVenta = $precioVenta;
    }
    public function setDescuento(float $descuento)
    {
        $this->descuento = $descuento;
    }
    public function setImg(string $img)
    {
        $this->img = $img;
    }

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of idBodega
     */
    public function getIdBodega(): int
    {
        return $this->idBodega;
    }
}

?>