<script type="text/javascript">
  $(document).ready(function() {
    $('#Buscar').keyup(function(){
        $(this).val($(this).val().toUpperCase());
    });
  });

  function Buscar(){
      if($("#Buscar").val() != ""){
        if($("p:contains('"+$("#Buscar").val()+"')")){
            $("div").removeClass('sombra');
            $("p:contains('"+$("#Buscar").val()+"')").parents(".texto-busqueda").addClass('sombra');
        }
      }else{
        $("div").removeClass('sombra');
        $("p:contains('"+$("#Buscar").val()+"')").parents(".texto-busqueda").removeClass('sombra');
      }
  }
</script>
