<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicamentos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css">        
    <link rel="stylesheet" href="plugins/toastr/toastr.css">
</head>
<body>
    <div class="container">
       <!-- Formulario de creación de medicamento -->
<div class="row mb-4" id="formulario_add">
    <div class="col-md-12">
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Agregar un Medicamento</h3>
            </div>
            <div class="card-body">
                <form name="medicamento_add" id="medicamento_add" method="POST">
                    <input type="hidden" id="existeModulo" name="existeModulo">
                    <div class="row">  
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="idCategoria">Categoría</label>
                                <input type="text" class="form-control" id="idCategoria" name="idCategoria" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input type="submit" id="btnRegistar" class="btn btn-success" value="Registrar">
                            <input type="reset" class="btn btn-warning" value="Borrar datos">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Formulario de modificación de medicamento -->
<div class="row mb-4" id="formulario_update">
    <div class="col-md-12">
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Modificar un Medicamento</h3>
            </div>
            <div class="card-body">
                <form name="medicamento_update" id="medicamento_update" method="POST" action="path_to_your_php_script.php">
                    <input type="hidden" id="EId" name="id">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="EidCategoria">Categoría</label>
                                <input type="text" class="form-control" id="EidCategoria" name="idCategoria" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Enombre">Nombre</label>
                                <input type="text" class="form-control" id="Enombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Eprecio">Precio</label>
                                <input type="number" step="0.01" class="form-control" id="Eprecio" name="precio" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Estock">Stock</label>
                                <input type="number" class="form-control" id="Estock" name="stock" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input type="submit" class="btn btn-warning" value="Modificar">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="button" class="btn btn-info" value="Cancelar" onclick="cancelarForm()">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        <!-- Listado de medicamentos -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Medicamentos existentes</h3>
                    </div>
                    <div class="card-body p-0">
                        <table id="tbllistado" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Categoría</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Categoría</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Opciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <!-- CSS -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/toastr/toastr.css">
    <!-- JS -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="plugins/DataTables/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/bootbox/bootbox.min.js"></script>
    <script src="plugins/toastr/toastr.js"></script>
    <script src="assets/js/medicamentos.js"></script>
</body>
</html>
