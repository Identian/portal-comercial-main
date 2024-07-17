<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Propuesta Comercial</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<link rel="icon" type="image/png" href="{{asset('propuesta/img/favicon.ico')}}" />

	<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

	<!-- CSS Files -->
    <link rel="stylesheet" href="{!! asset('propuesta/css/bootstrap.min.css') !!}?{{ substr(time(), -5) }}" />
    <link rel="stylesheet" href="{!! asset('propuesta/css/material-bootstrap-wizard.css') !!}?{{ substr(time(), -5) }}" />
    <link rel="stylesheet" href="{!! asset('propuesta/css/main.css') !!}?{{ substr(time(), -5) }}" />
    <link rel="stylesheet" href="{!! asset('propuesta/css/fileinput.css') !!}?{{ substr(time(), -5) }}" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">

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
											<img src="{{asset('propuesta/img/icon/Icono-help.png')}}" alt="" class='btn-help' id="help"/>
					                    </div>
		                            </div>
        						{{csrf_field()}}
		                    	<div class="wizard-header">
		                        	<h3 class="wizard-title">
		                        	   The Factory HKA
		                        	</h3>
									<h5>Portal de compras</h5>
		                    	</div>
		                        <div class="tab-content">
                                    @if ($firmado)
    								    <h4 class="info-text" style= "color:#0084CA; font-weight:bold"> La Propuesta Comercial ya esta firmada</h4>
                                    @else
    								    <h4 class="info-text" style= "color:#0084CA; font-weight:bold"> La Propuesta Comercial ha caducado</h4>
                                    @endif
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

</body>


	<!--   Core JS Files   -->
    <script src="{!! asset('propuesta/js/jquery-3.3.1.min.js') !!}"></script>
    <script src="{!! asset('propuesta/js/bootstrap.min.js') !!}"></script>
    <script src="{!! asset('propuesta/js/jquery.bootstrap.js') !!}"></script>
    <script src="{!! asset('propuesta/js/funciones.js') !!}"></script>
    <script src="{!! asset('propuesta/js/fileinput.js') !!}"></script>
    <script src="{!! asset('propuesta/js/locales/es.js') !!}"></script>
    <script src="{!! asset('propuesta/js/explorer-fas/theme.js') !!}"></script>
    <!--  Plugin for the Wizard -->
    <script src="{!! asset('propuesta/js/material-bootstrap-wizard.js') !!}"></script>
    <!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
    <script src="{!! asset('propuesta/js/jquery.validate.min.js') !!}"></script>

</html>
