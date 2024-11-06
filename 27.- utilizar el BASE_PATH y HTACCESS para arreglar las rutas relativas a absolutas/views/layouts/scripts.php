<!-- Required Js -->
<script src="<?= BASE_PATH ?>assets/js/plugins/popper.min.js"></script>
<script src="<?= BASE_PATH ?>assets/js/plugins/simplebar.min.js"></script>
<script src="<?= BASE_PATH ?>assets/js/plugins/bootstrap.min.js"></script>
<script src="<?= BASE_PATH ?>assets/js/fonts/custom-font.js"></script>
<script src="<?= BASE_PATH ?>assets/js/pcoded.js"></script>
<script src="<?= BASE_PATH ?>assets/js/plugins/feather.min.js"></script>


<script>
  layout_change('light');
</script>

<script>
  layout_sidebar_change('light');
</script>

<script>
  change_box_container('false');
</script>

<script>
  layout_caption_change('true');
</script>

<script>
  layout_rtl_change('false');
</script>

<script>
  preset_change('preset-1');
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    let deleteProductButtons = document.querySelectorAll('.deleteProduct');
    deleteProductButtons.forEach(button => {
      button.addEventListener('click', function() {
        // Mostrar la alerta de confirmación
        swal({
            title: "¿Estás seguro?",
            text: "¡Una vez eliminado, no podrás recuperar este producto!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              // Si el usuario confirma la eliminación, se envía el formulario
              let formId = `delete-form-${button.value}`;
              document.getElementById(formId).submit();
              swal("¡El producto ha sido eliminado!", {
                icon: "success",
              });
            }
          });
      });
    });
  });
</script>