<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Registro</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<link rel="icon" type="image/png" href="{{asset('propuesta/img/favicon.ico')}}" />

	<!--     Fonts and icons     -->
	<!-- <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" /> -->
	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

	<!-- CSS Files -->
    <link rel="stylesheet" href="{!! asset('propuesta/css/bootstrap.min.css') !!}?{{ substr(time(), -5) }}" />
    <link rel="stylesheet" href="{!! asset('propuesta/css/material-bootstrap-wizard.css') !!}?{{ substr(time(), -5) }}" />
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
	                <img src="{{asset('propuesta/img/tfhka-co.png')}}" style="width: 12%;">
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
		                        <form id="cliente" method="post" enctype="multipart/form-data">
		                        	<div class="col-sm-12">
			                        	<div class="pull-left">
			                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' id="previous" value='Anterior' />
			                            </div>
			                        	<div class="pull-right">
					                        <input src="{{asset('propuesta/img/icon/Icono-help.png')}}" type="image" class='btn-help' name='help' id="help"/>
					                    </div>
		                            </div>
        						{{csrf_field()}}
		                    	<div class="wizard-header">

		                        	<h3 class="wizard-title">
		                        	   The Factory HKA
		                        	</h3>
									<h5>Solicitud de Registro y Certificado Digital.</h5>
		                    	</div>

								<div class="wizard-navigation">
									<ul>
			                            <li><a class="tab" href="#start" data-toggle="tab">Inicio</a></li>
			                            <li><a class="tab" href="#enterprise" data-toggle="tab">Empresa</a></li>
			                            <li><a class="tab" href="#representative" data-toggle="tab">Representante</a></li>
			                            <li><a class="tab" href="#address" data-toggle="tab">Ubicación</a></li>
			                            <li><a class="tab" href="#commercial" data-toggle="tab">Comercial</a></li>
			                            <li><a class="tab" id="doc" href="#documents" data-toggle="tab"> Documentos</a></li>
			                            <li id="pre_document"><a href="#docPrevious" data-toggle="tab">Vista Previa</a></li>
			                        </ul>
								</div>

		                        <div class="tab-content">
		                        	@include('propuesta.start')
		                            @include('propuesta.enterprise')
		                            @include('propuesta.representative')
		                            @include('propuesta.address')
		                            @include('propuesta.commercial')
		                            @include('propuesta.documents')
		                            @include('propuesta.previous')
		                        </div>
		                        <div class="wizard-footer">
		                            <div class="pull-right">
		                                <input type='button' class='btn btn-next btn-fill btn-success btn-wd' name='next' id="next" value='Siguiente' />
		                                <input type='button' class='btn btn-info btn-fill btn-success btn-wd' id="valid_vendor" name='valid_vendor' value='Validar' />
		                                <input type='button' class='btn btn-info btn-fill btn-success btn-wd' id="valid" name='valid' value='Validar' />
		                                <input type='button' class='btn btn-finish btn-fill btn-success btn-wd' id="enviar" name='enviar' value='Enviar' />
		                                <input type='button' class='btn btn-finish btn-fill btn-success btn-wd' id="finish" name='finish' value='Finalizar' />
		                                <input type='button' class='btn btn-finish btn-fill btn-success btn-wd' id="finish_attorney" name='finish_attorney' value='Finalizar' />
									<a id="download" href="" target="_blank" class="btn btn-fill btn-success  btn-wd">Descargar</a>

		                            </div>

		                            <div class="pull-left">
		                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' id="previous" value='Anterior' />
		                            </div>
		                            <div class="clearfix"></div>
		                        </div>
		                        @include('layouts.partials.loading')
		                        <div id="modal-conf" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
									  <div class="modal-dialog modal-lg">
									    <div class="modal-content">
									      <div class="modal-header">
									       <!-- <h4 class="modal-title" id="myModalLabel">Requisitos</h4> -->
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modal-btn-close"><span aria-hidden="true">&times;</span></button>
									      </div>
									      <div class="modal-body" style="padding: 17px 0 0 50px">
									        <!--<ul class="list-unstyled">
									            <li><b>Error en lectura de RUT.</b> Debe adjuntarse el PDF descargado de la DIAN y sin clave.</li> <br>
									            <li>Para realizar la descarga del documento desde la DIAN, realice los siguientes pasos:<br>
									                <ul>
									                    <li>Paso 1. Ingrese al Portal MUISCA:<a href="https://muisca.dian.gov.co"  target="_blank"> www.muisca.dian.gov.co</a> www.muisca.dian.gov.co</li>
									                    <li>Paso 2.  Inicie sesión con sus datos</li>
									                    <li>Paso 3. Haga clic en “Obtener copia RUT”  ubicado en la ventana principal</li>
									                    <li>Paso 4. Cargue nuevamente el documento en nuestro Portal de Registro</li>
									                </ul>
									            </li>
									        </ul> -->
									        <div class="modal-body-1"></div>
									        @include('propuesta.edit')
									      </div>
									      <div class="wizard-footer">
									        <div class="pull-right">
									            <button type="button" class="btn btn-fill btn-default btn-wd" id="conf-btn-no">Cerrar</button>
									            <button type="button" class="btn btn-fill btn-success btn-wd" id="conf-btn-si" style="margin-right: 10px;">Validar</button>
									        </div>
									      </div>
									    </div>
									  </div>
									</div>
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
    <script src="{!! asset('propuesta/js/fileinput.js') !!}?{{ substr(time(), -5) }}"></script>
    <script src="{!! asset('propuesta/js/locales/es.js') !!}?{{ substr(time(), -5) }}"></script>
    <script src="{!! asset('propuesta/js/explorer-fas/theme.js') !!}?{{ substr(time(), -5) }}"></script>
    <!--  Plugin for the Wizard -->
    <script src="{!! asset('propuesta/detalle/js/material-bootstrap-wizard.js') !!}?{{ substr(time(), -5) }}"></script>
    <!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
    <script src="{!! asset('propuesta/js/jquery.validate.min.js') !!}?{{ substr(time(), -5) }}"></script>

</html>
