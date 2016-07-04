
function _dialogo(mensaje,location) {

    $(document.createElement('div'))
        .attr({title: 'Mensaje', 'class': 'alert'})
        .html(mensaje)
        .dialog({
            buttons: {
                OK: function () {
                    $(this).dialog('close');
                    if(location) {
                        window.location = location;
                    }
                }
            },
            close: function () {
                $(this).remove();
                if(location) {
                    window.location = location;
                }
            },
            draggable: true,
            modal: true,
            resizable: false,
            width: 400
        });
}