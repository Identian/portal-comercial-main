<div class="tab-pane" id="address">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="info-text"> Ubicación </h4>
        </div>
        <div class="col-sm-5 col-sm-offset-1">
        	<div class="form-group label-floating">
                <label class="control-label">Departamento<small class="text-danger"> *</small></label>
            	<select name="department" id="department" class="form-control" data-ajax="true" data-url="{{ route('direction.municipality') }}" data-search="#municipality">
					<option disabled="" selected=""></option>
                	@foreach ($cat_department as $code => $description)
                    <option value="{{ $code }}">{{mb_strtoupper($description, 'UTF-8')}}</option>
                    @endforeach
            	</select>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group label-floating">
                <label class="control-label">Municipio<small class="text-danger"> *</small></label>
                <select name="municipality" id="municipality" class="form-control">
                </select>
            </div>
        </div>
        <div class="col-sm-10  col-sm-offset-1">
            <div class="form-group label-floating">
        		<label class="control-label">Dirección<small class="text-danger"> *</small></label>
    			<input name="address_line" id="address_line" type="text" class="form-control"   maxlength="200">
        	</div>
        </div>
    </div>
</div>