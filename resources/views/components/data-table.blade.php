    <table id="myTable" class="hover h-full w-full " slot="{{ $slot }}">
    </table>

    <script>
        var items = JSON.parse(document.getElementById("myTable").getAttribute('slot'));
        console.log(items);
        let i = 0;
        let data = [];
        data['columns'] = [];
        data['columns'].push('name');
        data['columns'].push('amount');
        data['columns'].push('');
        data['columns'].push('');
        data['data'] = [];
        items.forEach(item => {
            data['data'][i] = []
            data['data'][i].push(item.name);
            data['data'][i].push('');
            data['data'][i].push('');
            data['data'][i].push('');
            i++;
        });
        console.log(data);



        $('#myTable').DataTable({
            "ordering": false,
            dom: 'Bfrtip',
            buttons: [
                'csv', 'pdf', 'excel'
            ],
            "lengthMenu": [25],
            "data": data.data,
            "columns": data.columns,
            "language": {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                "infoEmpty": "Mostrando 0 to 0 of 0 Registros",
                "infoFiltered": "(Filtrado de _MAX_ total registros)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Registros",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            columnDefs: [{
                targets: "_all",
                sortable: false,
                className: "text-center"
            }]
        });
    </script>
