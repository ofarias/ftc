<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link rel="icon" href="app/views/images/favicon.ico" type="image/ico">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed|Source+Sans+Pro&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sitema para el control administrativo de flujos">
    <meta name="author" content="Oscar Gabriel Farias Ayala con la colaboracion de Leonel Geovany de Leon">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SAT 2 APP</title>
    <!--Jquery UI-->
    <!-- Bootstrap Core CSS -->
    <link href="app/views/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="app/views/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="app/views/bower_components/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="app/views/dist/css/pegaso.css" rel="stylesheet">
    <!--<link href="app/views/dist/css/datosprov.css" rel="stylesheet">-->
    <!--confim-->
    <link href="app/views/dist/confirm/css/jquery-confirm.css" rel="stylesheet" />
    <!-- Custom Fonts -->
    <!--<link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">-->
    <link rel="stylesheet" href="app/views/bower_components/font-awesome/css/font-awesome.min.css">
    <!--jQuery UI Core-->
    <link rel="stylesheet" href="app/views/bower_components/jquery-ui/themes/smoothness/jquery-ui.css">
    <!--<link rel="stylesheet" href="/resources/demos/style.css">-->
    <!--jQuery time-->
    <!--<link rel="stylesheet" href="app/views/dist/css/bootstrap-timepicker.css" />-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" />
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<div class="container-fluid">
    <!--<div id="wrapper">-->
        <!-- header  -->
        <div id="header">        
           #HEADER#
        </div>
        <!-- end: header  -->       
        <!-- columna izquierda  -->
        <!--<div id="leftcolumn">        
          #MENULEFT#
        </div>-->
        <!-- end: columna izquierda  -->         
        <!-- contenido -->
        <div id="content">      
          #CONTENIDO#        
        </div>
        <!-- end: contenido -->     
    <!--</div>--> 
    <!--<div id="footer">
        #FOOTER#
    </div>-->
</div>
    <!-- jQuery -->
    <!--<script type="text/javascript" language="JavaScript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>-->
    <script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="app/views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="app/views/bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <!-- DataTables JavaScript -->
    <!-- <script type="text/javascript" language="JavaScript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script> -->
    <script type="text/javascript" language="JavaScript" src="app/views/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <!--<script src="app/views/bower_components/DataTables/media/js/jquery.dataTables.js"></script>      
    <script src="app/views/bower_components/DataTables/media/js/dataTables.bootstrap.js"></script>-->    
    <!-- Custom Theme JavaScript -->
    <script src="app/views/dist/js/sb-admin-2.js"></script> 
    <!--confirm-->
    <script src="app/views/dist/confirm/js/jquery-confirm.js"></script>  
    <!--jQuery UI JS-->
    <!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
    <script type="text/javascript" language="JavaScript" src="app/views/dist/js/jquery-ui/jquery-ui.min.js"></script>
    <!--JS Timepicker-->
    <!--<script type="text/javascript" language="JavaScript" src="app/views/dist/js/bootstrap-timepicker.js"></script>-->        
     <!--<script>
          $(function() {
            $( ".datepicker" ).datepicker({ 
                dateFormat: 'dd/mm/yy', 
                monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] }).val();
          });
    </script>-->
    <script>
    //$(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true,
                lengthMenu: [[1000,-1], [1000,"Todo"]],
                columnDefs:[
                    {
                        targets: [0,5],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Filtrar: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });

        $('#dataTables-recnom').DataTable({
                responsive: true,
                lengthMenu: [[100,-1], [100,"Todo"]],
                columnDefs:[
                    {
                        targets: [0],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Filtrar: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });

        $('#dataTables-usuarios-serv').DataTable({
                responsive: true,
                lengthMenu: [[1000,-1], [1000,"Todo"]],
                columnDefs:[
                    {
                        targets: [0],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Filtrar: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });


    $('#dataTables-recibos-nom').DataTable({
                responsive: true, 
                lengthMenu: [[100,-1], [1000,"Todo"]],
                columnDefs:[
                    {
                        targets: [2],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Filtrar: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });

    $('#dataTables-det-nom').DataTable({
        responsive: true, 
        lengthMenu: [[100,-1], [1000,"Todo"]],
        columnDefs:[
            {
                targets: [0,5],
                searchable: false
            }
        ],
        "order": [[ 2, "asc"]],
        language: {
            lengthMenu: "Mostrando _MENU_ por pagina",
            zeroRecords: "No hay dato para mostrar",
            info: "Mostrando página _PAGE_ de _PAGES_",
            sSearch: "Filtrar: ",
            sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
            oPaginate: {
                            "sFirst":    "Primero",
                            "sLast":     "Último",
                            "sNext":     "Siguiente",
                            "sPrevious": "Anterior"
                        }
        }
    });    

    $('#dataTables-detnom').DataTable({
        responsive: true, 
        lengthMenu: [[100,-1], [1000,"Todo"]],
        columnDefs:[
            {
                targets: [2],
                searchable: false
            }
        ],
        "order": [[ 2, "asc"]],
        language: {
            lengthMenu: "Mostrando _MENU_ por pagina",
            zeroRecords: "No hay dato para mostrar",
            info: "Mostrando página _PAGE_ de _PAGES_",
            sSearch: "Filtrar: ",
            sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
            oPaginate: {
                            "sFirst":    "Primero",
                            "sLast":     "Último",
                            "sNext":     "Siguiente",
                            "sPrevious": "Anterior"
                        }
        }
    });    

    $('#dataTables-detStat').DataTable({
                responsive: true,
                lengthMenu: [[1000,-1], [1000,"Todo"]],
                columnDefs:[
                    {
                        targets: [0,5],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Filtrar: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });
///dataTables-repventas
     
     $('#dataTables-repventas').DataTable({
            responsive: true,
            lengthMenu: [[1000,-1], [1000,"Todo"]],
            columnDefs:[
                {
                    targets: [1],
                    searchable: false
                }
            ],
            language: {
                lengthMenu: "Mostrando _MENU_ por pagina",
                zeroRecords: "No hay dato para mostrar",
                info: "Mostrando página _PAGE_ de _PAGES_",
                sSearch: "Filtrar: ",
                sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                oPaginate: {
                                "sFirst":    "Primero",
                                "sLast":     "Último",
                                "sNext":     "Siguiente",
                                "sPrevious": "Anterior"
                            }
            }
    });

/// dataTables-Empresas 
    $('#dataTables-empresas').DataTable({
            responsive: true,
            lengthMenu: [[1000,-1], [1000,"Todo"]],
            columnDefs:[
                {
                    targets: [1],
                    searchable: false
                }
            ],
            language: {
                lengthMenu: "Mostrando _MENU_ por pagina",
                zeroRecords: "No hay dato para mostrar",
                info: "Mostrando página _PAGE_ de _PAGES_",
                sSearch: "Filtrar: ",
                sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                oPaginate: {
                                "sFirst":    "Primero",
                                "sLast":     "Último",
                                "sNext":     "Siguiente",
                                "sPrevious": "Anterior"
                            }
            }
    });

//dataTables-aplicaGasto
    $('#dataTables-aplicaGasto').DataTable({
                responsive: true,
                lengthMenu: [[1000,-1], [1000,"Todo"]],
                columnDefs:[
                    {
                        targets: [6,7,8],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Filtrar: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });

    //dataTables-aplicaFactura

    $('#dataTables-aplicaFactura').DataTable({
        responsive: true,
        lengthMenu: [[1000,-1], [1000,"Todo"]],
        columnDefs:[
            {
                targets: [0,2,6,7,8],
                searchable: false
            }
        ],
        language: {
            lengthMenu: "Mostrando _MENU_ por pagina",
            zeroRecords: "No hay dato para mostrar",
            info: "Mostrando página _PAGE_ de _PAGES_",
            sSearch: "Filtrar: ",
            sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
            oPaginate: {
                            "sFirst":    "Primero",
                            "sLast":     "Último",
                            "sNext":     "Siguiente",
                            "sPrevious": "Anterior"
                        }
        }
    });

    $('#dataTables-RecibirLogistica').DataTable({
            responsive: true,
            lengthMenu: [[500,-1], [500,"Todo"]],
            columnDefs:[
                {
                    targets: [9],
                    searchable: false
                }
            ],
            language: {
                lengthMenu: "Mostrando _MENU_ por pagina",
                zeroRecords: "No hay dato para mostrar",
                info: "Mostrando página _PAGE_ de _PAGES_",
                sSearch: "Buscar: ",
                sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                oPaginate: {
                                "sFirst":    "Primero",
                                "sLast":     "Último",
                                "sNext":     "Siguiente",
                                "sPrevious": "Anterior"
                            }
            }
    });

    $('#dataTables-AsignaUnidadReparto').DataTable({
            responsive: true,
            lengthMenu: [[500,-1], [500,"Todo"]],
            columnDefs:[
                {
                    targets: [10,11],
                    searchable: false
                }
            ],
            language: {
                lengthMenu: "Mostrando _MENU_ por pagina",
                zeroRecords: "No hay dato para mostrar",
                info: "Mostrando página _PAGE_ de _PAGES_",
                sSearch: "Buscar: ",
                sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                oPaginate: {
                                "sFirst":    "Primero",
                                "sLast":     "Último",
                                "sNext":     "Siguiente",
                                "sPrevious": "Anterior"
                            }
            }
    });

  $('#dataTables-facturasxml').DataTable({
                responsive: true,
                lengthMenu: [[500,-1], [500,"Todo"]],
                columnDefs:[
                    {
                        targets: [9],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Buscar: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });

  $('#dataTables-impuestos').DataTable({
                responsive: true,
                lengthMenu: [[100,-1], [100,"Todo"]],
                columnDefs:[
                    {
                        targets: [0,2],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Buscar: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });
           $('#dataTables-calendariocartera').DataTable({
                responsive: true,
                lengthMenu: [[500,-1], [500,"Todo"]],
                columnDefs:[
                    {
                        targets: [5,6],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Buscar: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });

        $('#dataTables-compras').DataTable({
                responsive: true,
                lengthMenu: [[500,-1], [500,"Todo"]],
                columnDefs:[
                    {
                        targets: [5,6,8,9,10],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Buscar Orde de compra o Proveedor: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });

         $('#dataTables-saldos').DataTable({
                responsive: true,
                lengthMenu: [[1000,-1], [1000,"Todo"]],
                columnDefs:[
                    {
                        targets: [0],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Buscar Orde de compra o Proveedor: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });

        $('#dataTables-verCategorias').DataTable({
                responsive: true,
                lengthMenu: [[100,-1], [500,"Todo"]],
                columnDefs:[
                    {
                        targets: [0],
                        searchable: true
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Buscar por Nombre o clave del cliente: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });

        $("#dataTables-pago").DataTable({
        //scrollY:  "400px",
        //scrollCollapse: true,
        paging:         true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [0],
            searchable: true
          }
        ],        
        language: {
            lengthMenu: "Mostrando _MENU_ por pagina",
            zeroRecords: "No hay dato para mostrar",
            info: "Mostrando página _PAGE_ de _PAGES_",
            sSearch: "Filtar por Cliente o Clave: ",
            sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
            oPaginate: {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
            }
        }               
    });


         $('#dataTables-seguimientoCajas').DataTable({
                responsive: true,
                lengthMenu: [[100,-1], [500,"Todo"]],
                columnDefs:[
                    {
                        targets: [0,4],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Buscar por Nombre, Categoria o Responsable: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });


        $('#dataTables-inventarioBodega').DataTable({
                responsive: true,
                lengthMenu: [[1000,-1], [1000,"Todo"]],
                columnDefs:[
                    {
                        targets: [0,4],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay datos para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Buscar por Codigo, Nombre, Categoria, Marca o Proveedor: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });


        $('#dataTables-verCajasAlmacen').DataTable({
                responsive: true,
                lengthMenu: [[500,-1], [500,"Todo"]],
                order: [[ 0, "desc" ]],
                columnDefs:[
                    {
                        targets: [2,3,4],
                        searchable: true
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Buscar por Nombre, Categoria o Responsable: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });
        

        
         $('#dataTables-verCategorias2').DataTable({
                responsive: true,
                lengthMenu: [[100,-1], [500,"Todo"]],
                columnDefs:[
                    {
                        targets: [2,3,4],
                        searchable: true
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Buscar por Nombre, Categoria o Responsable: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });

        $('#dataTables-remisiones').DataTable({
                responsive: true,
                lengthMenu: [[2000,-1], [500,"Todo"]],
                columnDefs:[
                    {
                        targets: [2,3,4],
                        searchable: true
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Buscar por Nombre, Categoria o Responsable: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });


    $('#dataTables-foliofacturas').DataTable({
                responsive: true,
                lengthMenu: [[500,-1], [500,"Todo"]],
                columnDefs:[
                    {
                        targets: [0,1,2,5],
                        searchable: true
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Buscar: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });


        $('#dataTables-ocom').DataTable({
                scrollY:  "400px",
                scrollCollapse: true,
                paging:         true,
                language: {
                                lengthMenu: "Mostrando _MENU_ por pagina",
                                zeroRecords: "No hay dato para mostrar",
                                info: "Mostrando página _PAGE_ de _PAGES_",
                                sSearch: "Buscar: ",
                                sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                                        oPaginate: {
                                                        "sFirst":    "Primero",
                                                        "sLast":     "Último",
                                                        "sNext":     "Siguiente",
                                                        "sPrevious": "Anterior"
                                                   }
                              }
               
            });
////////////// TEST TABLA NUEVA

        $('#dataTables-edocta').DataTable({
                responsive: true,
        lengthMenu: [[2000,-1], [2000,"Todo"]],
        columnDefs:[
          {
            targets: [2,5],
            searchable: false
          }
        ],
                language: {
                                lengthMenu: "Mostrando _MENU_ por pagina",
                                zeroRecords: "No hay dato para mostrar",
                                info: "Mostrando página _PAGE_ de _PAGES_",
                                sSearch: "Buscar: ",
                                sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                                        oPaginate: {
                                                        "sFirst":    "Primero",
                                                        "sLast":     "Último",
                                                        "sNext":     "Siguiente",
                                                        "sPrevious": "Anterior"
                                                   }
                              }
               
            });


    $('#verRevision').DataTable({
                responsive: true,
        lengthMenu: [[2000,-1], [2000,"Todo"]],
        columnDefs:[
          {
            targets: [2,5],
            searchable: false
          }
        ],
                language: {
                                lengthMenu: "Mostrando _MENU_ por pagina",
                                zeroRecords: "No hay dato para mostrar",
                                info: "Mostrando página _PAGE_ de _PAGES_",
                                sSearch: "Buscar: ",
                                sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                                        oPaginate: {
                                                        "sFirst":    "Primero",
                                                        "sLast":     "Último",
                                                        "sNext":     "Siguiente",
                                                        "sPrevious": "Anterior"
                                                   }
                              }
               
            });


        $('#dataTables-remisionesPendientes').DataTable({
                responsive: true,
        lengthMenu: [[2000,-1], [2000,"Todo"]],
        columnDefs:[
          {
            targets: [0,1,2,3],
            searchable: true
          }
        ],
                language: {
                                lengthMenu: "Mostrando _MENU_ por pagina",
                                zeroRecords: "No hay dato para mostrar",
                                info: "Mostrando página _PAGE_ de _PAGES_",
                                sSearch: "Buscar: ",
                                sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                                        oPaginate: {
                                                        "sFirst":    "Primero",
                                                        "sLast":     "Último",
                                                        "sNext":     "Siguiente",
                                                        "sPrevious": "Anterior"
                                                   }
                              }
               
            });




  $('#dataTables-buscaArt').DataTable({
                responsive: true,
        lengthMenu: [[2000,-1], [2000,"Todo"]],
        columnDefs:[
          {
            targets: [2,5],
            searchable: false
          }
        ],
                language: {
                                lengthMenu: "Mostrando _MENU_ por pagina",
                                zeroRecords: "No hay dato para mostrar",
                                info: "Mostrando página _PAGE_ de _PAGES_",
                                sSearch: "Buscar: ",
                                sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                                        oPaginate: {
                                                        "sFirst":    "Primero",
                                                        "sLast":     "Último",
                                                        "sNext":     "Siguiente",
                                                        "sPrevious": "Anterior"
                                                   }
                              }
               
            });



 $("#dataTables-oc-credito-contrarecibo").DataTable({
        //scrollY:  "400px",
        //scrollCollapse: true,
        paging:         true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [2,4],
            searchable: true
          }
        ],        
        language: {
            lengthMenu: "Mostrando _MENU_ por pagina",
            zeroRecords: "No hay dato para mostrar",
            info: "Mostrando página _PAGE_ de _PAGES_",
            sSearch: "Buscar: ",
            sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
            oPaginate: {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
            }
        }               
    });
///// Cobranza ////////
$("#dataTables-RutaCobranza").DataTable({
        //scrollY:  "400px",
        //scrollCollapse: true,
        paging:         true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [1,3,4,5],
            searchable: true
          }
        ],        
        language: {
            lengthMenu: "Mostrando _MENU_ por pagina",
            zeroRecords: "No hay dato para mostrar",
            info: "Mostrando página _PAGE_ de _PAGES_",
            sSearch: "Buscar: ",
            sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
            oPaginate: {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
            }
        }               
    });

$("#dataTables-RutasActivas").DataTable({
        //scrollY:  "400px",
        //scrollCollapse: true,
        paging:         true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [1,6,8],
            searchable: true
          }
        ],        
        language: {
            lengthMenu: "Mostrando _MENU_ por pagina",
            zeroRecords: "No hay dato para mostrar",
            info: "Mostrando página _PAGE_ de _PAGES_",
            sSearch: "Buscar: ",
            sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
            oPaginate: {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
            }
        }               
    });


////

  $("#dataTables-aplicapago").DataTable({
        //scrollY:  "400px",
        //scrollCollapse: true,
        paging:         true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [2,4],
            searchable: true
          }
        ],        
        language: {
            lengthMenu: "Mostrando _MENU_ por pagina",
            zeroRecords: "No hay dato para mostrar",
            info: "Mostrando página _PAGE_ de _PAGES_",
            sSearch: "Buscar: ",
            sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
            oPaginate: {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
            }
        }               
    });

 $("#dataTables-articulo").DataTable({
        //scrollY:  "400px",
        //scrollCollapse: true,
        paging:         true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [2,3,4,5],
            searchable: true
          }
        ],        
        language: {
            lengthMenu: "Mostrando _MENU_ por pagina",
            zeroRecords: "No hay dato para mostrar",
            info: "Mostrando página _PAGE_ de _PAGES_",
            sSearch: "Buscar: ",
            sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
            oPaginate: {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
            }
        }               
    });

    $('#dataTables-oc1').DataTable({
                responsive: true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [11,12],
            searchable: false
          }
        ],
        language: {
          lengthMenu: "Mostrando _MENU_ por pagina",
          zeroRecords: "No hay dato para mostrar",
          info: "Mostrando página _PAGE_ de _PAGES_",
          sSearch: "Buscar: ",
          sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",         
          oPaginate: {
                  "sFirst":    "Primero",
                  "sLast":     "Último",
                  "sNext":     "Siguiente",
                  "sPrevious": "Anterior"
                }
        }, /*aqui termina????*/
        /**/
        /**/
        
        /*Totales*/
    //Cargamos el API para usar funciones de CallBack Data
    
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // si es string lo cambiamos a entero
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // muestra total en todas las paginas la suma es unicamente por pagina
            total = api
                .column( 10 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // total de la pagina actual
            pageTotal = api
                .column( 10, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // actualiza totales en el footer
            $( api.column( 10 ).footer() ).html(
                '$'+pageTotal
            )
        }
    /*Termina totales*/
      
        });

/////tabla para busqueda de clientes /// OFA 28 de Septiembre 2016

$('#dataTables-clientes').DataTable({
                responsive: true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [6,5],
            searchable: false
          }
        ],
        language: {
          lengthMenu: "Mostrando _MENU_ por pagina",
          zeroRecords: "No hay dato para mostrar",
          info: "Mostrando página _PAGE_ de _PAGES_",
          sSearch: "Buscar: ",
          sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",         
          oPaginate: {
                  "sFirst":    "Primero",
                  "sLast":     "Último",
                  "sNext":     "Siguiente",
                  "sPrevious": "Anterior"
                }
        }
        });
    
        $('#dataTables-ocom').DataTable({
                scrollY:  "400px",
                scrollCollapse: true,
                paging:         true,
                language: {
                                lengthMenu: "Mostrando _MENU_ por pagina",
                                zeroRecords: "No hay dato para mostrar",
                                info: "Mostrando página _PAGE_ de _PAGES_",
                                sSearch: "Buscar: ",
                                sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                                        oPaginate: {
                                                        "sFirst":    "Primero",
                                                        "sLast":     "Último",
                                                        "sNext":     "Siguiente",
                                                        "sPrevious": "Anterior"
                                                   }
                              }
               
            });
   
////////////





//// Tabla para la busqueda de cajas /// OFA 11 de Octubre 2016
$('#dataTables-cajas').DataTable({
                responsive: true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [4,5,6,7],
            searchable: false
          }
        ],
        language: {
          lengthMenu: "Mostrando _MENU_ por pagina",
          zeroRecords: "No hay dato para mostrar",
          info: "Mostrando página _PAGE_ de _PAGES_",
          sSearch: "Buscar: ",
          sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",         
          oPaginate: {
                  "sFirst":    "Primero",
                  "sLast":     "Último",
                  "sNext":     "Siguiente",
                  "sPrevious": "Anterior"
                }
        }
        });

$('#dataTables-iva').DataTable({
        responsive: true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [4,5,6,7],
            searchable: false
          }
        ],
        "order": [[ 9, "asc"]],
        language: {
          lengthMenu: "Mostrando _MENU_ por pagina",
          zeroRecords: "No hay dato para mostrar",
          info: "Mostrando página _PAGE_ de _PAGES_",
          sSearch: "Buscar: ",
          sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",         
          oPaginate: {
                  "sFirst":    "Primero",
                  "sLast":     "Último",
                  "sNext":     "Siguiente",
                  "sPrevious": "Anterior"
                }
        }
        });


$('#dataTables-ocf').DataTable({
        responsive: true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [4,5,6],
            searchable: false
          }
        ],
        language: {
          lengthMenu: "Mostrando _MENU_ por pagina",
          zeroRecords: "No hay dato para mostrar",
          info: "Mostrando página _PAGE_ de _PAGES_",
          sSearch: "Buscar: ",
          sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",         
          oPaginate: {
                  "sFirst":    "Primero",
                  "sLast":     "Último",
                  "sNext":     "Siguiente",
                  "sPrevious": "Anterior"
                }
        }
        });


    
        $('#dataTables-ocom').DataTable({
                scrollY:  "400px",
                scrollCollapse: true,
                paging:         true,
                language: {
                                lengthMenu: "Mostrando _MENU_ por pagina",
                                zeroRecords: "No hay dato para mostrar",
                                info: "Mostrando página _PAGE_ de _PAGES_",
                                sSearch: "Buscar: ",
                                sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                                        oPaginate: {
                                                        "sFirst":    "Primero",
                                                        "sLast":     "Último",
                                                        "sNext":     "Siguiente",
                                                        "sPrevious": "Anterior"
                                                   }
                              }
               
            });
   ////// fin de tabla de cajas.

        $('#dataTables-pagos').DataTable({
                responsive: true,
                lengthMenu: [[500,-1], [500,"Todo"]],
                columnDefs:[
                    {
                        targets: [0],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Buscar Orde de compra o Proveedor: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });


        /*Tabla para OC*/
        $('#dataTables-oc').DataTable({
                responsive: true,
                lengthMenu: [[500,-1], [500,"Todo"]],
                columnDefs:[
                    {
                        targets: [1,2,3,4,5,6,7,8,9],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Buscar: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }, /*aqui termina????*/
                /**/
                /**/
                
                /*Totales*/
        //Cargamos el API para usar funciones de CallBack Data
        
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // si es string lo cambiamos a entero
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // muestra total en todas las paginas la suma es unicamente por pagina
            total = api
                .column( 10 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // total de la pagina actual
            pageTotal = api
                .column( 10, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // actualiza totales en el footer
            $( api.column( 10 ).footer() ).html(
                '$'+pageTotal
            )
        }
        /*Termina totales*/
            
        });
/* datatables tablita 3*/       //14062016
        $('#dataTables-table-3').DataTable({
                responsive: true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [2,3],
            searchable: false
          }
        ],
        language: {
          lengthMenu: "Mostrando _MENU_ por pagina",
          zeroRecords: "No hay dato para mostrar",
          info: "Mostrando página _PAGE_ de _PAGES_",
          sSearch: "Buscar: ",
          sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",         
          oPaginate: {
                  "sFirst":    "Primero",
                  "sLast":     "Último",
                  "sNext":     "Siguiente",
                  "sPrevious": "Anterior"
                }
        }
        });
/* datatables tablita 3 fin*/
    $('#dataTables-table-4').DataTable({
                responsive: true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        "order": [[3 , "desc"]], 
        columnDefs:[
          {
            targets: [2,3],
            searchable: false
          }
        ],
        language: {
          lengthMenu: "Mostrando _MENU_ por pagina",
          zeroRecords: "No hay dato para mostrar",
          info: "Mostrando página _PAGE_ de _PAGES_",
          sSearch: "Buscar: ",
          sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",         
          oPaginate: {
                  "sFirst":    "Primero",
                  "sLast":     "Último",
                  "sNext":     "Siguiente",
                  "sPrevious": "Anterior"
                }
        }
        });

   $('#dataTables-facturas-maestro').DataTable({
                responsive: true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [2,3],
            searchable: false
          }
        ],
        language: {
          lengthMenu: "Mostrando _MENU_ por pagina",
          zeroRecords: "No hay dato para mostrar",
          info: "Mostrando página _PAGE_ de _PAGES_",
          sSearch: "Filtrar: ",
          sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",         
          oPaginate: {
                  "sFirst":    "Primero",
                  "sLast":     "Último",
                  "sNext":     "Siguiente",
                  "sPrevious": "Anterior"
                }
            }
        });
      $('#dataTables-maestros').DataTable({
                responsive: true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [3,4,5],
            searchable: false
          }
        ],
        language: {
          lengthMenu: "Mostrando _MENU_ por pagina",
          zeroRecords: "No hay dato para mostrar",
          info: "Mostrando página _PAGE_ de _PAGES_",
          sSearch: "Filtrar: ",
          sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",         
          oPaginate: {
                  "sFirst":    "Primero",
                  "sLast":     "Último",
                  "sNext":     "Siguiente",
                  "sPrevious": "Anterior"
                }
            }
        });
/* datatables tablita verFacturas*/       //14062016
        $('#dataTables-verFacturas').DataTable({
                responsive: true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [9,10,11,12],
            searchable: false
          }
        ],
        language: {
          lengthMenu: "Mostrando _MENU_ por pagina",
          zeroRecords: "No hay dato para mostrar",
          info: "Mostrando página _PAGE_ de _PAGES_",
          sSearch: "Buscar: ",
          sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",         
          oPaginate: {
                  "sFirst":    "Primero",
                  "sLast":     "Último",
                  "sNext":     "Siguiente",
                  "sPrevious": "Anterior"
                }
        }
        });
/* datatables tablita verFacturas fin*/
        $('#dataTables-verProveedores').DataTable({
                responsive: true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [0, 2, 5, 10],
            searchable: true
          }
        ],
        language: {
          lengthMenu: "Mostrando _MENU_ por pagina",
          zeroRecords: "No hay dato para mostrar",
          info: "Mostrando página _PAGE_ de _PAGES_",
          sSearch: "Buscar: ",
          sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",         
          oPaginate: {
                  "sFirst":    "Primero",
                  "sLast":     "Último",
                  "sNext":     "Siguiente",
                  "sPrevious": "Anterior"
                }
        }
        });


  $('#dataTables-verRecibidos').DataTable({
                responsive: true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [9,10,11,12],
            searchable: false
          }
        ],
        language: {
          lengthMenu: "Mostrando _MENU_ por pagina",
          zeroRecords: "No hay dato para mostrar",
          info: "Mostrando página _PAGE_ de _PAGES_",
          sSearch: "Buscar: ",
          sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",         
          oPaginate: {
                  "sFirst":    "Primero",
                  "sLast":     "Último",
                  "sNext":     "Siguiente",
                  "sPrevious": "Anterior"
                }
        }
        });

    //// Ruta Cobranza-
    
        
         $('#dataTables-usuarios').DataTable({
            responsive: true,
            lengthMenu: [[500,-1], [500,"Todo"]],
            columnDefs:[
            {
                targets: [2],
                searchable: false
             }
            ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                            zeroRecords: "No hay dato para mostrar",
                            info: "Mostrando página _PAGE_ de _PAGES_",
                            sSearch: "Buscar: ",
                            sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                            oPaginate: {
                                            "sFirst":    "Primero",
                                            "sLast":     "Último",
                                            "sNext":     "Siguiente",
                                            "sPrevious": "Anterior"
                                        }
                }
            });

//// Reporte de ventas 

         $('#dataTables-ventasvscobrado').DataTable({
            responsive: true,
            lengthMenu: [[500,-1], [500,"Todo"]],
            columnDefs:[
            {
                targets: [2],
                searchable: false
             }
            ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                            zeroRecords: "No hay dato para mostrar",
                            info: "Mostrando página _PAGE_ de _PAGES_",
                            sSearch: "Buscar: ",
                            sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                            oPaginate: {
                                            "sFirst":    "Primero",
                                            "sLast":     "Último",
                                            "sNext":     "Siguiente",
                                            "sPrevious": "Anterior"
                                        }
                }
            });

            

/* datatables tablita 2 fin*/

        $('#dataTables-table-2').DataTable({
                responsive: true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [1],
            searchable: false
          }
        ],
        language: {
          lengthMenu: "Mostrando _MENU_ por pagina",
          zeroRecords: "No hay dato para mostrar",
          info: "Mostrando página _PAGE_ de _PAGES_",
          sSearch: "Buscar: ",
          sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",         
          oPaginate: {
                  "sFirst":    "Primero",
                  "sLast":     "Último",
                  "sNext":     "Siguiente",
                  "sPrevious": "Anterior"
                }
        }
        });
/* datatables tablita 2 fin*/
     $('#dataTables-stat').DataTable({
                responsive: true,
                lengthMenu: [[1000,-1], [1000,"Todo"]],
                "order": [[6 , "desc"]],           
                columnDefs:[
                    {
                        targets: [0,5],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Filtrar: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });

  
/* Data Table Recibir Mercancia */

    $('#dataTables-recmcia').DataTable({
                responsive: true,
        lengthMenu: [[500,-1], [500,"Todo"]],
        columnDefs:[
          {
            targets: [4,5],
            searchable: false
          }
        ],
        language: {
          lengthMenu: "Mostrando _MENU_ por pagina",
          zeroRecords: "No hay dato para mostrar",
          info: "Mostrando página _PAGE_ de _PAGES_",
          sSearch: "Buscar: ",
          sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",         
          oPaginate: {
                  "sFirst":    "Primero",
                  "sLast":     "Último",
                  "sNext":     "Siguiente",
                  "sPrevious": "Anterior"
                }
            }, 
        });
    </script>  
<!--
    <script type="text/javascript">
            $('#time').timepicker();
    </script>
-->
<script>
              
  $(function() {
    $( "#dialog" ).dialog({
      autoOpen: false,
      width: 400,
      height: 200,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#opener" ).click(function() {
      $( "#dialog" ).dialog( "open" );
    });
  });
        </script>
        <script>
              
  $(function() {
    $( "#dialoga" ).dialog({
      autoOpen: false,
      width: 400,
      height: 200,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#openera" ).click(function() {
      $( "#dialoga" ).dialog( "open" );
    });
  });
        </script>
        <script>
              
  $(function() {
    $( "#dialogU" ).dialog({
      autoOpen: false,
      width: 600,
      height: 800,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#openeU" ).click(function() {
      $( "#dialogU" ).dialog( "open" );
    });
  });
        </script>
<script>
              
  $(function() {
    $( "#dialogAP" ).dialog({
      autoOpen: false,
      width: 1200,
      height: 500,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#openeAP" ).click(function() {
      $( "#dialogAP" ).dialog( "open" );
    });
  });
</script>



</body>
</html>