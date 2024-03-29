import * as language from './datatables.spanish.json';

const canCreateNewOrder = $("input[name='can_create_new_order']").val();

$(function () {
    loadServiceOrders();
});

const appendNewServiceOrderButton = function () {
    $("#newServiceOrderButton").append(`
        <a href="ordenes-servicio/crear" class="btn btn-primary mt-2 mt-md-0">
            <i class="typcn icon typcn-plus"></i>
            Nueva orden de servicio
        </a>
    `);
}

const loadServiceOrders = function () {

    const dom = (canCreateNewOrder)
        ? "<'row justify-content-end' <'col-sm-12 col-lg-4' f> <'#newServiceOrderButton.col-sm-12 col-lg-2 px-1 px-md-2'> <'col-12' t> <'row justify-content-center' <'col-12 col-lg-4' p>>>"
        : "<'row' ft> <'row justify-content-center' <'col-md-4'p>>";

    $.ajax({
        url: 'ordenes-servicio/getOrders',
        type: 'get',
        dataType: 'json',
    })
        .done(function (orders) {
            $('#ordersTable').DataTable({
                data: orders.data,
                columns: columnsByUserRole(orders.user_role),
                dom,
                language,
                responsive: true,
            });

            if (canCreateNewOrder) {
                appendNewServiceOrderButton();
            }
        });

};

const columnsByUserRole = function (userRole) {

    if (userRole == 'departmentSupervisor') {
        return [
            { data: 'id', title: 'Id', visible: false },
            { data: 'order_number', title: 'Número de orden' },
            { data: 'created_at', title: 'Fecha y hora de creación' },
            { data: 'status', title: 'Estado' },
            { data: 'technician', title: 'Técnico asignado' },
            {
                data: 'order_number',
                render: (orderNumber) => `
                    <div class="row mx-1">
                        <a href='ordenes-servicio/${orderNumber}' class='btn btn-primary'>Detalles</a>
                    </div>
                `,
                title: 'Acción'
            },
        ]
    } else if (userRole == 'maintenanceSupervisor' || userRole == 'maintenanceManager') {
        return [
            { data: 'id', title: 'Id', visible: false },
            { data: 'order_number', title: 'Número de orden' },
            { data: 'created_at', title: 'Fecha y hora de creación' },
            { data: 'requestor', title: 'Solicitante' },
            { data: 'technician', title: 'Técnico' },
            { data: 'status', title: 'Estado' },
            {
                data: null,
                render: (data) => {

                    const requestedItems = data.items_requested;
                    const orderNumber = data.order_number;
                    const technician = data.technician;
                    const status = data.status;
                    const orderItemsStatus = data.order_items_status;

                    return `
                        <div class="row mx-1 justify-content-around">
                            ${(function () {
                            if (status.toLowerCase() == 'desaprobado' || technician != null)
                                return `<a href='ordenes-servicio/${orderNumber}' class='btn btn-primary'>Detalles</a>`
                            else if (status.toLowerCase() == 'pendiente de asignar tecnico' || technician == null)
                                return `<a href='ordenes-servicio/${orderNumber}' class='btn btn-primary'>Aprobar/Desaprobar</a>`
                            else return ``
                        })()}

                            ${(technician != null && !requestedItems) ? `<a href='ordenes-servicio/${orderNumber}/gestion-materiales' class='btn btn-primary mt-2 mt-md-1'>Gestión de materiales</a>` : ``}
                            
                            ${(requestedItems
                            && userRole == 'maintenanceManager'
                            && orderItemsStatus == 'en espera aprobacion gerente mantenimiento'
                            && technician != null)
                            ? `<a href='ordenes-servicio/${orderNumber}/aprobacion-materiales' class='btn btn-primary mt-2'>Aprobar materiales</a>`
                            : ``
                        }
                        </div>
                    `;
                },
                title: 'Acciones'
            },
        ]
    } else if (userRole == 'maintenanceTechnician') {
        return [
            { data: 'id', title: 'Id', visible: false },
            { data: 'order_number', title: 'Número de orden' },
            { data: 'created_at', title: 'Fecha y hora de creación' },
            { data: 'requestor', title: 'Solicitante' },
            {
                data: 'order_number',
                render: (orderNumber) => `
                    <div class="row mx-1">
                        <a href='ordenes-servicio/${orderNumber}' class='btn btn-primary'>Detalles</a>
                    </div>
                `,
                title: 'Acción'
            },
        ]
    }
}