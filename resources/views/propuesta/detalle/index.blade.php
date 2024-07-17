<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Propuesta Comercial</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link rel="icon" type="image/png" href="{{ asset('propuesta/img/favicon.ico') }}" />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="{!! asset('propuesta/css/bootstrap.min.css') !!}?{{ substr(time(), -5) }}" />
    <link rel="stylesheet" href="{!! asset('propuesta/detalle/css/material-bootstrap-wizard.css') !!}?{{ substr(time(), -5) }}" />
    <link rel="stylesheet" href="{!! asset('propuesta/css/main.css') !!}?{{ substr(time(), -5) }}" />
    <link rel="stylesheet" href="{!! asset('propuesta/css/fileinput.css') !!}?{{ substr(time(), -5) }}" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
    {!! htmlScriptTagJsApi() !!}
</head>

<body>

    <div class="set-full-height">
        <a href="https://www.thefactoryhka.com/co/">
            <div class="logo-container">
                <div class="">
                    <img src="{{ asset('propuesta/img/tfhka-co.png') }}" style="width: 12%;">
                </div>
            </div>
        </a>
        <!--   Big container   -->
        <div class="container">

            <div class="row">

                <div class="col-sm-12">

                    <!--      Wizard container        -->
                    <div class="wizard-container">

                        <div class="card wizard-card" data-color="blue" id="wizardProfile">
                            <div id="error_section"></div>
                            <form id="pCliente" method="post" enctype="multipart/form-data">
                                <div class="col-sm-12">
                                    <div class="pull-left">
                                        <input type='button' class='btn btn-previous btn-fill btn-default btn-wd'
                                            name='previous' id="previous" value='Anterior' />
                                    </div>
                                    <div class="pull-right">
                                        <img src="{{ asset('propuesta/img/icon/Icono-help.png') }}" alt=""
                                            class='btn-help' id="help" />
                                    </div>
                                </div>
                                {{ csrf_field() }}
                                <div class="wizard-header">

                                    <h3 class="wizard-title">
                                        The Factory HKA
                                    </h3>
                                    <h5>Portal de compras</h5>
                                </div>

                                <div class="wizard-navigation">
                                    <ul id="lis-tab">
                                        <li><a class="tab tab_1" href="#Propuesta" data-toggle="tab">Propuesta</a></li>
                                        <li><a class="tab tab_edit" href="#enterprise" data-toggle="tab">Empresa</a>
                                        </li>
                                        <li><a class="tab tab_edit" href="#representative" data-toggle="tab">Datos</a>
                                        </li>
                                        <li><a class="tab tab_edit" href="#commercial" data-toggle="tab">Comercial</a>
                                        </li>
                                        <li><a class="tab tab_edit" href="#services" data-toggle="tab">Planes y
                                                Servicios</a></li>
                                        <li id="pre_document"><a href="#docPropuesta" data-toggle="tab">Propuesta</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content">
                                    @include('propuesta.detalle.propuesta')
                                    @include('propuesta.detalle.enterprise')
                                    @include('propuesta.detalle.representative')
                                    @include('propuesta.detalle.commercial')
                                    @include('propuesta.detalle.service')
                                    @include('propuesta.detalle.previous')
                                </div>
                                <div class="wizard-footer">
                                    <div class="pull-right">
                                        <input type='button' class='btn btn-next btn-fill btn-success btn-wd'
                                            id="edit_propuesta" name='edit_propuesta' value='Actualizar' />
                                        <input type='button' class='btn btn-next btn-fill btn-success btn-wd'
                                            name='next' id="next" value='Siguiente' />
                                        <input type='button' class='btn btn-info btn-fill btn-success btn-wd'
                                            name='next_cplan' id="next_cplan" value='Siguiente' />
                                        <input type='button' class='btn btn-info btn-fill btn-success btn-wd'
                                            id="valid_vendor" name='valid_vendor' value='Validar' />
                                        <input type='button' class='btn btn-info btn-fill btn-success btn-wd'
                                            id="valid_opt" name='valid_opt' value='Validar' />
                                        <input type='button' class='btn btn-info btn-fill btn-success btn-wd'
                                            id="search" name='search' value='Consultar' />
                                        <input type='button' class='btn btn-info btn-fill btn-success btn-wd'
                                            id="valid" name='valid' value='Validar' />
                                        <input type='button' class='btn btn-info btn-fill btn-success btn-wd'
                                            id="search_plan" name='search_plan' value='Consultar Plan' />
                                        <input type='button' class='btn btn-finish btn-fill btn-success btn-wd'
                                            id="enviar" name='enviar' value='Firmar' />
                                        <input type='button' class='btn btn-finish btn-fill btn-success btn-wd'
                                            id="update" name='update' value='Actualizar' />
                                        <input type='button' class='btn btn-finish btn-fill btn-success btn-wd'
                                            id="finish_attorney" name='finish_attorney' value='Finalizar' />
                                        <input type='button' class='btn btn-finish btn-fill btn-success btn-wd'
                                            id="firmar" name='firmar' value='Validar' />
                                        <!--<a id="download" href="pdf/{{ $encrypt }}" target="_blank"
                                            class="btn btn-fill btn-success  btn-wd">Descargar</a>
                                        <a id="firmar" href="firmado/{{ $encrypt }}"
                                            class="btn btn-fill btn-success  btn-wd">Validar</a>-->

                                    </div>

                                    <div class="pull-left">
                                        <input type='button' class='btn btn-previous btn-fill btn-default btn-wd'
                                            name='previous' id="previous" value='Anterior' />
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                @include('layouts.partials.loading')
                            </form>
                        </div>
                    </div> <!-- wizard container -->
                </div>
            </div><!-- end row -->
        </div> <!--  big container -->

        <div class="footer">
            <div class="container text-center">
                <a href="https://www.thefactoryhka.com/co/">The Factory HKA Colombia SAS</a>. NIT: 900390126-6 © 2020
            </div>
        </div>
    </div>
    @include('layouts.modals.message')
    @include('layouts.modals.errors')
</body>


<!--   Core JS Files   -->
<script src="{!! asset('propuesta/js/jquery-3.3.1.min.js') !!}?{{ substr(time(), -5) }}"></script>
<script src="{!! asset('propuesta/js/bootstrap.min.js') !!}?{{ substr(time(), -5) }}"></script>
<script src="{!! asset('propuesta/js/jquery.bootstrap.js') !!}?{{ substr(time(), -5) }}"></script>
<script src="{!! asset('propuesta/js/funciones.js') !!}?{{ substr(time(), -5) }}"></script>
<script src="{!! asset('propuesta/detalle/js/detalle.js') !!}?{{ substr(time(), -5) }}"></script>
<script src="{!! asset('propuesta/js/fileinput.js') !!}?{{ substr(time(), -5) }}"></script>
<script src="{!! asset('propuesta/js/locales/es.js') !!}?{{ substr(time(), -5) }}"></script>
<script src="{!! asset('propuesta/js/explorer-fas/theme.js') !!}?{{ substr(time(), -5) }}"></script>

<!--  Plugin for the Wizard -->
<script src="{!! asset('propuesta/detalle/js/material-bootstrap-wizard.js') !!}?{{ substr(time(), -5) }}"></script>
<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
<script src="{!! asset('propuesta/js/jquery.validate.min.js') !!}?{{ substr(time(), -5) }}"></script>

</html>
