angular.module('Listado_tianguis', ['ui.bootstrap'])
        .controller("tianguis", function ($scope, $http) {

            $scope.pagina = 1;
            $scope.lineas = [];
            $scope.id_tianguis = 0;
            $scope.datos = [];
            $scope.id_puesto = "";
            $scope.id_zona_global = "";
            $scope.id_nombre_global = "";
            $scope.formulario = {
                dia: "",
                id_linea: 0,
                zona: '',
                busqueda_nom_fol: ''
            }

            $scope.testAllowed = function () {
                var stocks = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace($("#txt_buscador").val()),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: 'nombre_tianguis/%QUERY/%DIA',
                        replace: function (url, query) {
                            var nombre = encodeURIComponent($("#txt_buscador").val());
                            var uri = url.replace('%QUERY', nombre);
                            uri = uri.replace('%DIA', $scope.formulario.dia);
                            return uri;
                        }
                    }


                });

                stocks.initialize();

                $('#txt_buscador').typeahead({
                    minLength: 0
                }, {
                    name: 'nombre',
                    displayKey: 'nombre',
                    source: stocks.ttAdapter(),
                    templates: {
                        empty: [
                            '<div>No existe</div>'
                        ].join('\n'),
                        suggestion: function (data) {
                            stocks.clearRemoteCache();
                            if ($("#txt_buscador").val() == "") {
                                $scope.id_tianguis = 0;
                                $scope.formulario.zona = "";
                                $scope.formulario.id_linea = "";
                                $("#txt_buscador").blur();
                            }
                            else {
                                return '<div>' + data.nombre + '</div>';
                            }
                            $scope.$apply();
                        }
                    }
                }).on('typeahead:selected', function (event, data) {
                    $("#txt_buscador").typeahead('val', data.nombre);
                    $scope.id_tianguis = data.id_cat_tianguis;
                });
                $(".twitter-typeahead").addClass("col-md-12");
                $(".twitter-typeahead").css("padding", "0");
            }

            $scope.testAllowedPersonas = function () {
                var stocks = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace($("#txt_buscador_personas").val()),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: '/nombre_personas/%QUERY/0/1/1',
                        replace: function (url, query) {
                            var nombre = encodeURIComponent($("#txt_buscador_personas").val());
                            var uri = url.replace('%QUERY', nombre);
                            return uri;
                        }
                    }
                });

                stocks.initialize();

                $('#txt_buscador_personas').typeahead({
                    minLength: 0
                }, {
                    name: 'nombre',
                    displayKey: 'nombre',
                    source: stocks.ttAdapter(),
                    templates: {
                        empty: [
                            '<div>No existe</div>'
                        ].join('\n'),
                        suggestion: function (data) {

                            if ($("#txt_buscador_personas").val() == "") {
                                $("#txt_buscador_personas").blur();
                                $scope.datos = [];
                            }
                            else {
                                return '<div>' + data.nombre_completo + '</div>';
                            }
                            $scope.$apply();

                        }
                    }
                }).on('typeahead:selected', function (event, data) {
                    $scope.id_puesto = data.id_puesto;
                    $scope.llenar_info_personas(data.nombre_completo);
                });
                $(".twitter-typeahead").addClass("col-md-12");
                $(".twitter-typeahead").css("padding", "0");
            }

            $scope.testAllowedZona = function () {
                var stocks = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace($("#txt_buscador_zona").val()),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: 'busqueda_zonas_filtro/%DIA/%ID_TIANGUIS/%ZONA',
                        replace: function (url, query) {
                            var nombre = encodeURIComponent($("#txt_buscador_zona").val());
                            var uri = url.replace('%ID_TIANGUIS', $scope.id_tianguis);
                            uri = uri.replace('%DIA', $scope.formulario.dia);
                            uri = uri.replace('%ZONA', nombre);
                            return uri;
                        }
                    }

                });

                stocks.initialize();

                $('#txt_buscador_zona').typeahead({
                    minLength: 0
                }, {
                    name: 'nombre',
                    displayKey: 'nombre',
                    source: stocks.ttAdapter(),
                    templates: {
                        empty: [
                            '<div>No existe</div>'
                        ].join('\n'),
                        suggestion: function (data) {
                            stocks.clearRemoteCache();
                            if ($("#txt_buscador_zona").val() == "") {
                                $scope.datos = [];
                            }
                            else {
                                return '<div>' + data.zona + '</div>';
                            }
                            $scope.$apply();

                        }
                    }
                }).on('typeahead:selected', function (event, data) {
                    $("#txt_buscador_zona").typeahead('val', data.zona);
                    $scope.id_zona_global = data.id_cat_zona;
                    $scope.id_nombre_global = data.zona;
                    $('#txt_buscador_zona').typeahead('close');
                    $scope.llenar_linea();
                });
                $(".twitter-typeahead").addClass("col-md-12");
                $(".twitter-typeahead").css("padding", "0");
            }

            $scope.paginar = function () {
                $scope.pagina += $scope.pagina;
                $scope.llenar_datos();
            }

            $scope.regresaPagina = function () {
                $scope.pagina = $scope.pagina - 1;
                $scope.llenar_datos();
            }

            $scope.resetea1 = function () {
                $scope.nom_tiang = "";
                $scope.formulario.zona = "";
                $scope.formulario.id_linea = "";
            }

            $scope.limpiar_todo = function () {
                $scope.formulario.zona = "";
                $scope.formulario.id_linea = "";
                $scope.formulario.dia = "";
                $scope.formulario.busqueda_nom_fo = "";
                $scope.nom_tiang = "";
                $scope.datos = [];
                $("#txt_buscador_personas").typeahead('val', '');
            }

            $scope.llenar_datos = function () {
                Metronic.blockUI({
                    target: '#cargando',
                    animate: true
                });

                if ($("#txt_buscador").val() == "")
                    $scope.id_tianguis = 0;

                $http({
                    url: '/info_tianguis/' + $scope.formulario.dia + '/a/' + $scope.id_nombre_global + '/' + $scope.formulario.id_linea + '/' + $scope.pagina + '/' + $scope.id_tianguis,
                    method: "GET",
                }).success(function (data, status, headers, config) {
                    if (data.status) {
                        $scope.datos = data.data;
                        Metronic.unblockUI('#cargando');
                    } else {
                        $scope.datos = [];
                        Metronic.unblockUI('#cargando');
                    }
                }).error(function (error, status, headers, config) {
                    console.log(error);
                });
            };

            $scope.llenar_info_personas = function (x) {
                Metronic.blockUI({
                    target: '#cargando',
                    animate: true
                });


                $http({
                    url: '/nombre_personas/a/' + $scope.id_puesto + '/' + 2 + '/' + $scope.pagina,
                    method: "GET",
                }).success(function (data, status, headers, config) {
                    Metronic.unblockUI('#cargando');
                    if (data.status) {
                        $scope.datos = data.data;
                        $("#txt_buscador_personas").typeahead('val', x);
                        $('#txt_buscador_personas').typeahead('close');
                    } else {
                        $scope.datos = [];
                    }
                }).error(function (error, status, headers, config) {
                    console.log(error);
                });

            };

            $scope.llenar_linea = function (pagina_reset, grupo) {
                $http({
                    url: '/busqueda_lineas_filtro/' + $scope.formulario.dia + '/' + $scope.id_tianguis + '/' + $scope.id_zona_global,
                    method: "GET"
                }).success(function (data, status, headers, config) {
                    if (data.status) {
                        $scope.lineas = data.data;
                    } else {
                        $scope.lineas = [];
                    }
                }).error(function (error, status, headers, config) {
                    console.log(error);
                });
            };
        });