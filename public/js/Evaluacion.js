$("#escondido").hide();
var o = $("#Premio").val();
var c = document.getElementById("Catedra").innerHTML;

$(document).ready(function () {
    if (c === "Estudios del pensamiento y la obra de “Fidel Castro Ruz") {
        $("#residencia").text("Vicerrectoría de Extensión y Residencia");
        $("#cambio").text("Promover el estudio del pensamiento filosófico, político, económico, social y pedagógico del Comandante en Jefe Fidel Castro Ruz; así como de su obra revolucionaria.")
    } else if (c === "Julio Antonio Mella") {
        $("#residencia").text("Facultad 2");
        $("#cambio").text("Desarrolla el estudio sobre las ideas filosóficas, políticas, económicas, sociales y educacionales de Julio Antonio Mella; así como del ejemplo de su vida y acción, organiza y propicia las investigaciones y la enseñanza de la vida y obra de esta relevante figura, realiza actividades extensionistas de promoción, propicia actividades con la participación de estudiantes y trabajadores, desarrolla relaciones de colaboración con otras cátedras e instituciones cubanas y del exterior, que persigan el mismo fin.")
    } else if (c === "Antonio Maceo y Grajales") {
        $("#residencia").text("Facultad FICI");
        $("#cambio").text("Crear un ambiente institucional que propicie el conocimiento del pensamiento y la acción de Antonio Maceo que impacte a la comunidad universitaria, a partir de la identificación de esta, con dicha figura, logrando la transformación de valores y modos de actuación.")

    } else if (c === "Ernesto “Che” Guevara") {
        $("#residencia").text("Facultad 3");
        $("#cambio").text("La Cátedra “Che” Guevara, como estructura docente de esta universidad, cumplimenta y complementa la labor político ideológico del futuro profesional de la informática. A partir del estudio y reflexión de los valores que revelaba el Che, contribuirá a la difusión formación de aquellos valores que deben prevalecer en la formación de nuestros egresados y ampliará su Cultura General Integral.");
    } else if (c === "Remberto Fernández González") {
        $("#residencia").text("Deporte");
        $("#cambio").text("Proporciona a los estudiantes y profesores las condiciones necesarias para la práctica del ajedrez de forma tradicional y a través de las nuevas tecnologías, rige de conjunto con el MES las investigaciones relacionadas con el aprendizaje del ajedrez, promueve y organiza campeonatos internos y externos mediante el uso de las TIC y ofrece el ajedrez como asignatura facultativa entre otras tareas.");
    } else if (c === "Pensamiento Bolivariano") {
        $("#residencia").text("Facultad 4");
        $("#cambio").text("Promover el estudio del pensamiento filosófico, político, económico, social y pedagógico de los próceres de la independencia latinoamericana");
    } else if (c === "Vilma Espín Guillois") {
        $("#residencia").text("Facultad 1");
        $("#cambio").text("Promover el estudio del pensamiento humanista, altruista, político, social y pedagógico de Vilma Espín Guillois; así como su obra revolucionaria.");
    } else if (c === "Rosa Elene Simeón Negrín") {
        $("#residencia").text("Facultad CITEC");
        $("#cambio").text("Fomentar la escritura de textos de divulgación y promoción de la ciencia, con énfasis en la informática, las ciencias de la computación y la matemática.");
    } else {
        $("#residencia").text("Facultad 1");
        $("#cambio").text("Promover el estudio del pensamiento filosófico, político, económico, social y pedagógico de José Martí Pérez; así como su obra revolucionaria.");
    }
});

$("#evaluar").click(function () {
    $("#escondido").show();
})

function Evaluar(id, o) {
    if (!confirm('Esta seguro de esta evaluacion luego no podra ser rectificada'))
        return;

    window.location.href = 'http://127.0.0.1:8000/evaluar_inve/' + id + '/' + o;
}



