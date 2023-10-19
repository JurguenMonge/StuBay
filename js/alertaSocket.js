var conn = new WebSocket('ws://192.168.100.240:8088');

conn.onopen = function(e) {
    console.log("Conexión establecida");
};

conn.onmessage = function(e) {
    var message = e.data;
    showToast(message);
};

function sendMessage() {
    // Obtén el elemento seleccionado en el select de clientes
    var monto = document.getElementById("pujaClienteOfertaView").value;
    // Obtén el nombre del cliente seleccionado usando el atributo data-nombre
    var nombreCliente = document.getElementById("clienteNombreView").value;

    // Ahora, puedes enviar el nombre del cliente en el mensaje
    var message = "El cliente " +nombreCliente+ " ha realizado una nueva puja por el monto de "+monto;
    console.log(message);
    conn.send(message);
}

function showToast(message) {
    toastr.options = {
        "positionClass": "toast-top-right",
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    toastr.info(message, "Nuevo mensaje");
}