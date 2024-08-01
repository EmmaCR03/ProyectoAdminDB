/* Función para limpiar los formularios */
function limpiarForms() {
  $('#modulos_add').trigger('reset');
  $('#modulos_update').trigger('reset');
}

/* Función para cancelación del uso de formulario de modificación */
function cancelarForm() {
  limpiarForms();
  $('#formulario_add').show();
  $('#formulario_update').hide();
}

/* Función para cargar el listado en el Datatable */
function listarMedicamentosTodos() {
    $('#tbllistado').DataTable({
        processing: true,
        serverSide: true,
        dom: 'Bfrtip',
        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf'],
        ajax: {
            url: '../Controller/medicamentosController.php?op=listar_para_tabla',
            type: 'GET',
            dataType: 'json',
            dataSrc: 'aaData', // Asegúrate de que este valor coincide con la estructura del JSON devuelto
            error: function (xhr, error, thrown) {
                console.error('Error al cargar los datos: ', error);
                console.log(xhr.responseText);
            }
        },
        columns: [
            { data: 0, title: "ID" },
            { data: 1, title: "Categoría" },
            { data: 2, title: "Nombre" },
            { data: 3, title: "Precio" },
            { data: 4, title: "Stock" },
            { data: 5, title: "Opciones" }
        ],
        destroy: true,
        pageLength: 5,
    });
}


/* Función Principal */
$(function () {
  $('#formulario_update').hide();
  listarMedicamentosTodos();
});

/* CRUD */

/* Agregar medicamento */
$('#medicamento_add').on('submit', function (event) {
  event.preventDefault();
  $('#btnRegistar').prop('disabled', true);
  var formData = new FormData($('#medicamento_add')[0]);
  $.ajax({
      url: '../Controller/medicamentosController.php?op=insertar',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (datos) {
          switch (datos) {
              case '1':
                  toastr.success('Medicamento registrado');
                  $('#medicamento_add')[0].reset();
                  $('#tbllistado').DataTable().ajax.reload();
                  break;

              case '2':
                  toastr.error('El medicamento ya existe. Corrija e inténtelo nuevamente.');
                  break;

              case '3':
                  toastr.error('Hubo un error al tratar de ingresar los datos.');
                  break;

              default:
                  toastr.error(datos);
                  break;
          }
          $('#btnRegistar').removeAttr('disabled');
      },
  });
});

/* Activar medicamento */
function activar(id) {
  bootbox.confirm('¿Está seguro de activar el medicamento?', function (result) {
      if (result) {
          $.post(
              '../Controller/medicamentosController.php?op=activar',
              { idMedicamento: id },
              function (data) {
                  switch (data) {
                      case '1':
                          toastr.success('Medicamento activado');
                          $('#tbllistado').DataTable().ajax.reload();
                          break;

                      case '0':
                          toastr.error('Error: El medicamento no puede activarse. Consulte con el administrador.');
                          break;

                      default:
                          toastr.error(data);
                          break;
                  }
              }
          );
      }
  });
}

/* Desactivar medicamento */
function desactivar(id) {
  bootbox.confirm('¿Está seguro de desactivar el medicamento?', function (result) {
      if (result) {
          $.post(
              '../Controller/medicamentosController.php?op=desactivar',
              { idMedicamento: id },
              function (data) {
                  switch (data) {
                      case '1':
                          toastr.success('Medicamento desactivado');
                          $('#tbllistado').DataTable().ajax.reload();
                          break;

                      case '0':
                          toastr.error('Error: El medicamento no puede desactivarse. Consulte con el administrador.');
                          break;

                      default:
                          toastr.error(data);
                          break;
                  }
              }
          );
      }
  });
}

/* Habilitación del formulario de modificación al presionar el botón en la tabla */
$('#tbllistado tbody').on('click', 'button[id="modificarMedicamento"]', function () {
  var data = $('#tbllistado').DataTable().row($(this).parents('tr')).data();
  limpiarForms();
  $('#formulario_add').hide();
  $('#formulario_update').show();
  $('#EId').val(data[0]);
  $('#Ecategoria').val(data[1]);
  $('#Enombre').val(data[2]);
  $('#Eprecio').val(data[3]);
  $('#Estock').val(data[4]);
  return false;
});

/* Modificar medicamento */
$('#medicamento_update').on('submit', function (event) {
  event.preventDefault();
  bootbox.confirm('¿Desea modificar los datos?', function (result) {
      if (result) {
          var formData = new FormData($('#medicamento_update')[0]);
          $.ajax({
              url: '../Controller/medicamentosController.php?op=editar',
              type: 'POST',
              data: formData,
              contentType: false,
              processData: false,
              success: function (datos) {
                  switch (datos) {
                      case '0':
                          toastr.error('Error: No se pudieron actualizar los datos');
                          break;
                      case '1':
                          toastr.success('Medicamento actualizado exitosamente');
                          $('#tbllistado').DataTable().ajax.reload();
                          limpiarForms();
                          $('#formulario_update').hide();
                          $('#formulario_add').show();
                          break;
                      case '2':
                          toastr.error('Error: Correo no pertenece al medicamento.');
                          break;
                  }
              },
          });
      }
  });
});
