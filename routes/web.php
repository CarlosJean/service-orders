<?php

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\OrdersSupController;
use App\Http\Controllers\GestionMaterialesController;
use App\Http\Controllers\GestionMaterialesBTNController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ServiceOrdersController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\InventoriesController;
use App\Http\Controllers\MaterialRequestsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\userTechnicianController;

use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RoleController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CanApproveItems;
use App\Http\Middleware\CanCreateServiceOrders;
use App\Http\Middleware\CanDoWarehouseWorks;
use App\Http\Middleware\CanManageEmployees;
use App\Http\Middleware\CanManageItems;
use App\Http\Middleware\CanViewServiceOrder;
use App\Http\Middleware\CanViewServiceOrders;
use App\Http\Middleware\HasPermissionToSubmenu;
use App\Repositories\RolesRepository;

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" smiddleware group. Make something great!
|
*/


Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('registro-empleado/{id?}', [EmployeesController::class, 'index'])
    ->middleware([Authenticate::class, CanManageEmployees::class]);
Route::post('registro-empleado/{id?}', [EmployeesController::class, 'store']);
Route::get('empleados', [EmployeesController::class, 'list'])
    ->middleware([Authenticate::class, HasPermissionToSubmenu::class]);
Route::get('getEmployees', [EmployeesController::class, 'getEmployees']);
Route::get('update-employee/{value}', [EmployeesController::class, 'updateEmpleyee']);


Route::get('registro-empleado', [EmployeesController::class, 'index'])
    ->middleware([Authenticate::class, CanManageEmployees::class]);
Route::get('registro-empleado', [EmployeesController::class, 'index']);
Route::post('registro-empleado', [EmployeesController::class, 'store']);

Route::get('servicios', [ServicesController::class, 'index'])
    ->middleware([Authenticate::class, HasPermissionToSubmenu::class]);
Route::post('register-services', [ServicesController::class, 'store']);
Route::get('getServices', [ServicesController::class, 'getServices']);
Route::get('update-services/{id?}', [ServicesController::class, 'update']);

Route::get('roles', [RoleController::class, 'index'])
    ->middleware([Authenticate::class, HasPermissionToSubmenu::class]);
Route::get('get-roles', [RoleController::class, 'getRoles']);
Route::post('register-role', [RoleController::class, 'store']);
Route::get('update-role/{id?}', [RoleController::class, 'update']);
Route::get('get-menu', [RoleController::class, 'getMenus']);
Route::get('get-submenu-by-menu/{Id?}', [RoleController::class, 'getSubmenuByMenu']);
Route::post('register-roles-submenu', [RoleController::class, 'storeRolSubmenu']);


Route::get('tecnicos', [userTechnicianController::class, 'index'])
    ->middleware([Authenticate::class, HasPermissionToSubmenu::class]);
Route::get('getUsersten', [userTechnicianController::class, 'getServices']);
Route::post('getServicesByIdEmployee', [userTechnicianController::class, 'getServicesByIdEmployee']);
Route::post('setServices', [userTechnicianController::class, 'setServices']);


Route::get('valor_inventario', [InventoriesController::class, 'index'])
    ->middleware([Authenticate::class, CanDoWarehouseWorks::class]);
Route::post('inventory_value', [InventoriesController::class, 'getInventory']);

Route::get('categorias', [CategoriesController::class, 'index'])
    ->middleware([Authenticate::class, HasPermissionToSubmenu::class]);


Route::get('categorias', [CategoriesController::class, 'index'])
    ->middleware([Authenticate::class, HasPermissionToSubmenu::class]);
Route::get('get-categories', [CategoriesController::class, 'getCategories']);
//Route::get('get-categories', [CategoriesController::class, 'getCategories']);

Route::post('register-categories', [CategoriesController::class, 'store']);
Route::get('update-categories/{id?}', [CategoriesController::class, 'update']);

Route::get('reportes', [ReportsController::class, 'index'])
    ->middleware([Authenticate::class, HasPermissionToSubmenu::class]);
Route::post('get-report', [ReportsController::class, 'getReport']);
Route::get('fillSelectReport', [ReportsController::class, 'fillSelectReport']);

Route::get('articulo', [ItemsController::class, 'index'])
    ->middleware([Authenticate::class, HasPermissionToSubmenu::class]);
Route::get('get-items', [ItemsController::class, 'getItems']);
Route::get('getItemsAll', [ItemsController::class, 'getItemsAll']);
Route::post('register-items', [ItemsController::class, 'store']);
Route::get('update-items/{id?}', [ItemsController::class, 'update']);

Route::get('suplidor', [SuppliersController::class, 'index'])
    ->middleware([Authenticate::class, HasPermissionToSubmenu::class]);
Route::get('get-suppliers', [SuppliersController::class, 'getSuppliersAll']);
Route::post('register-suppliers', [SuppliersController::class, 'store']);
Route::get('update-suppliers/{id?}', [SuppliersController::class, 'update']);

Route::get('/orders', [OrdersController::class, 'index']);
Route::get('/ordersSup', [OrdersSupController::class, 'index']);
Route::get('/GestionMateriales', [GestionMaterialesController::class, 'index']);
Route::get('/GestionMaterialesBTN', [GestionMaterialesBTNController::class, 'index']);

Route::get('/departamentos', [DepartmentsController::class, 'index'])
    ->middleware([Authenticate::class, HasPermissionToSubmenu::class]);
Route::get('get-deparments', [DepartmentsController::class, 'getDeparments']);
Route::post('register-deparment', [DepartmentsController::class, 'store']);
Route::get('update-deparment/{id?}', [DepartmentsController::class, 'update']);

Route::prefix('ordenes-servicio')->group(function () {
    Route::get('/', [ServiceOrdersController::class, 'index'])
        ->middleware([Authenticate::class, HasPermissionToSubmenu::class]);
    Route::get('crear', [ServiceOrdersController::class, 'create'])
        ->middleware([Authenticate::class, CanCreateServiceOrders::class]);
    Route::get('getOrders', [ServiceOrdersController::class, 'getOrders']);
    Route::get('get-services', [ServiceOrdersController::class, 'getServices']);
    Route::get('get-deparments', [ServiceOrdersController::class, 'getDeparments']);
    Route::get('get-employees-by-service/{serviceId}', [ServiceOrdersController::class, 'getEmployeesByService']);
    Route::post('orden-servicio', [ServiceOrdersController::class, 'getServiceOrderByNumber']);
    Route::post('materiales', [ServiceOrdersController::class, 'serviceOrderItems'])
        ->name('materiales_orden_servicio');
    Route::get('{orderNumber}/gestion-materiales', [ServiceOrdersController::class, 'materialsManagementCreate'])
        ->middleware([Authenticate::class, CanManageItems::class]);
    Route::get('{orderNumber}/aprobacion-materiales', [ServiceOrdersController::class, 'createItemsRequestApproval'])
        ->middleware([Authenticate::class, CanApproveItems::class]);
    Route::get('{orderNumber}', [ServiceOrdersController::class, 'show'])
        ->middleware([Authenticate::class, CanViewServiceOrder::class]);
    Route::post('{orderNumber}/aprobacion-materiales', [ServiceOrdersController::class, 'updateItemsRequest']);
    Route::post('crear', [ServiceOrdersController::class, 'store']);
    Route::post('asignar-tecnico', [ServiceOrdersController::class, 'assignTechnicianUpdate']);
    Route::post('desaprobar', [ServiceOrdersController::class, 'disapproveUpdate']);
    Route::post('{orderNumber}/gestion-materiales', [ServiceOrdersController::class, 'orderMaterialsStore']);
    Route::post('reporte-tecnico', [ServiceOrdersController::class, 'storeTechnicalReport']);
    Route::post('iniciar', [ServiceOrdersController::class, 'startOrder']);
    Route::post('finalizar', [ServiceOrdersController::class, 'finishOrder']);
});

Route::prefix('cotizaciones')->group(function () {
    Route::get('/', [QuoteController::class, 'index'])
        ->middleware([Authenticate::class, CanDoWarehouseWorks::class]);
    Route::get('crear', [QuoteController::class, 'create'])
        ->middleware([Authenticate::class, CanDoWarehouseWorks::class]);
    Route::get('{quoteNumber}', [QuoteController::class, 'show'])
        ->middleware([Authenticate::class, CanDoWarehouseWorks::class]);
    Route::post('obtener-por-numero', [QuoteController::class, 'getQuoteByNumber']);
    Route::post('crear', [QuoteController::class, 'store']);
    Route::post('activas', [QuoteController::class, 'actives']);
});

Route::prefix('articulos')->group(function () {
    Route::get('/', [ItemsController::class, 'getItems']);
    Route::get('disponibles', [ItemsController::class, 'getAvailableItems']);
    Route::get('despachar/{serviceOrderNumber?}', [ItemsController::class, 'createDispatchMaterials']);
    Route::get('{itemId}', [ItemsController::class, 'getItem']);
    Route::post('despachar', [ItemsController::class, 'storeDispatch'])->name('dispatchItems');
});

Route::prefix('suplidores')->group(function () {
    Route::get('/', [SupplierController::class, 'getSuppliers']);
});

Route::prefix('ordenes-compra')->group(function () {
    Route::get('/', [PurchaseOrderController::class, 'index'])
        ->middleware([Authenticate::class, CanDoWarehouseWorks::class]);
    Route::get('crear/{quoteNumber?}', [PurchaseOrderController::class, 'create'])
        ->middleware([Authenticate::class, CanDoWarehouseWorks::class]);
    Route::get('{number}', [PurchaseOrderController::class, 'show'])
        ->middleware([Authenticate::class, CanDoWarehouseWorks::class]);
    Route::post('/', [PurchaseOrderController::class, 'getPurchaseOrders']);
    Route::post('crear', [PurchaseOrderController::class, 'store'])->name('storePurchaseOrder');
});

Route::prefix('inventario')->group(function () {
    Route::get('/', [InventoriesController::class, 'index'])
        ->middleware([Authenticate::class, CanDoWarehouseWorks::class]);
});

Route::get('/reestablecer-contraseña', [ResetPasswordController::class, 'showSendEmail'])
    ->name('password.request');

Route::get('/reestablecer-contraseña/{token}', [ResetPasswordController::class, 'showResetForm']);


Route::prefix('solicitud-materiales')->group(function () {
    Route::get('/', [MaterialRequestsController::class, 'index'])
        ->middleware([Authenticate::class, HasPermissionToSubmenu::class]);
    Route::post('pendientes', [MaterialRequestsController::class, 'pending']);
});

Route::fallback(function () {
    return view('errors.not_found');
});
