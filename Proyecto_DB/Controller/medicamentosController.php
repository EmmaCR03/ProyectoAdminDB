<?php
require_once '../Model/medicamentosModel.php';

switch ($_GET["op"]) {
    case 'listar_para_tabla':
        $medicamento = new Medicamento(); // Creación correcta de una instancia
        $medicamentos = $medicamento->listarTodosDb(); // Asignación correcta

        $data = array();
        if (is_array($medicamentos) || is_object($medicamentos)) {
            foreach ($medicamentos as $reg) {
                $data[] = array(
                    "0" => $reg->getIdMedicamento(),
                    "1" => $reg->getIdCategoria(),
                    "2" => $reg->getNombre(),
                    "3" => $reg->getPrecio(),
                    "4" => $reg->getStock(),
                    "5" => '<button class="btn btn-warning" id="modificarMedicamento">Modificar</button>'
                );
            }
        }

        $resultados = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($resultados);
        break;

    case 'insertar':
        $idCategoria = isset($_POST["idCategoria"]) ? trim($_POST["idCategoria"]) : "";
        $nombre = isset($_POST["nombre"]) ? trim($_POST["nombre"]) : "";
        $precio = isset($_POST["precio"]) ? trim($_POST["precio"]) : "";
        $stock = isset($_POST["stock"]) ? trim($_POST["stock"]) : "";

        $medicamento = new Medicamento();
        $medicamento->setIdCategoria($idCategoria);
        $medicamento->setNombre($nombre);
        $medicamento->setPrecio($precio);
        $medicamento->setStock($stock);
        $encontrado = $medicamento->verificarExistenciaDb();

        if (!$encontrado) {
            $medicamento->guardarEnDb();
            if ($medicamento->verificarExistenciaDb()) {
                echo 1; // Medicamento registrado exitosamente
            } else {
                echo 3; // Fallo al realizar el registro
            }
        } else {
            echo 2; // El medicamento ya existe
        }
        break;

    case 'activar':
        $medicamento = new Medicamento();
        $medicamento->setIdMedicamento(trim($_POST['id']));
        $rspta = $medicamento->activar();
        echo $rspta;
        break;

    case 'desactivar':
        $medicamento = new Medicamento();
        $medicamento->setIdMedicamento(trim($_POST['id']));
        $rspta = $medicamento->desactivar();
        echo $rspta;
        break;

    case 'mostrar':
        $idMedicamento = isset($_POST["id"]) ? trim($_POST["id"]) : "";
        $medicamento = new Medicamento();
        $medicamento->setIdMedicamento($idMedicamento);
        $encontrado = $medicamento->mostrar();

        if ($encontrado != null) {
            $arr = array(
                "idMedicamento" => $encontrado['IDMEDICAMENTO'],
                "nombre" => $encontrado['NOMBRE'],
                "idCategoria" => $encontrado['IDCATEGORIA']
            );
            echo json_encode($arr);
        } else {
            echo 0;
        }
        break;

    case 'editar':
        $idMedicamento = isset($_POST["idMedicamento"]) ? trim($_POST["idMedicamento"]) : "";
        $idCategoria = isset($_POST["idCategoria"]) ? trim($_POST["idCategoria"]) : "";
        $nombre = isset($_POST["nombre"]) ? trim($_POST["nombre"]) : "";
        $precio = isset($_POST["precio"]) ? trim($_POST["precio"]) : "";
        $stock = isset($_POST["stock"]) ? trim($_POST["stock"]) : "";

        $medicamento = new Medicamento();
        $medicamento->setIdMedicamento($idMedicamento);
        $medicamento->setIdCategoria($idCategoria);
        $medicamento->setNombre($nombre);
        $medicamento->setPrecio($precio);
        $medicamento->setStock($stock);

        $modificados = $medicamento->actualizar();
        if ($modificados > 0) {
            echo 1; // Actualización exitosa
        } else {
            echo 0; // Fallo en la actualización
        }
        break;
}
?>
