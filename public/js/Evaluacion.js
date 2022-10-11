$("#escondido").hide();
var o=$("#Premio").val();

$("#evaluar").click(function (){
    $("#escondido").show();
})

 function Evaluar(id,o){
      if (!confirm('Esta seguro de esta evaluacion luego no podra ser rectificada'))
          return;

      window.location.href='http://127.0.0.1:8000/evaluar_inve/'+id+'/'+o;
  }



