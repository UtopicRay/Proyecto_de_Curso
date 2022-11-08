function eliminarUsuario(id) {

    if (!confirm('Desee eliminar a este usuario')) {
        return;
    }
    window.location.href='http://127.0.0.1:8000/usuario/remover/'+id ;
}
function eliminarCronograma(id) {

    if (!confirm('Desee eliminar esta cronograma')) {
        return;
    }
    window.location.href='http://127.0.0.1:8000/cronograma/remover/'+id ;
}
