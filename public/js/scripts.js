
function eliminarInvestigacion(id) {

    if (!confirm('Desee eliminar esta investigacion')) {
        return;
    }
     window.location.href='http://127.0.0.1:8000/inves/remover/'+id ;
}
function eliminarEvento(id) {

    if(!confirm('Desea Eliminar dicho evento!')){
        return;
    }
    window.location.href='http://127.0.0.1:8000/evento/remover/'+id ;

}