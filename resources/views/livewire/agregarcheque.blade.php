<div>{{--- DIV PRINCIPAL--}}
    @php
        $date=date('Y-m-d');
    @endphp

 <!-- Modal -->

 <div wire:ignore.self class="modal fade" id="nuevo-cheque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">  <span style="text-decoration: none;"  class="icons fas fa-plus">&nbsp;Agrega Cheque/Transferencia</span></h6>
                <button id="mdl" type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
<div class="modal-body"><!--modal body -->


    {{--<h2><strong>C</strong></h2>--}}
    <p>llena los campos correspondientes</p>
    <div class="row">
        <div class="col-md-12 mx-0">

                <!-- progressbar -->

                <fieldset>


<!----------------------------------- ---->
<div  ALIGN="center">




    <form  wire:submit.prevent="guardar_nuevo_cheque">
        @csrf
        <div class="form-row">

@if (auth()->user()->tipo)


            <label for="inputState">Empresa</label>
            <select wire:model="rfcEmpresa" id="empresas" class=" select form-control" required >
                <option  value="" >--Selecciona Empresa--</option>
                <?php $rfc=0; $rS=1;foreach($empresas as $fila)
                {

                    echo '<option value="' . $fila[$rfc] . '">'. $fila[$rS] . '</option>';

          }
                ?>
            </select>

            @endif


            {{-- <script>
         $('#empresas').on('change', function() {

//alert('hola');
document.getElementById("tipo").disabled = false;

});


                </script> --}}


          <div class="form-group col-md-6">
              {{---tooltip---}}
              <i id="info" class=" fa fa-info-circle" aria-hidden="true"></i>
              <span id="pago" class="tooltiptext">Como fue que realizó el pago.</span>
              {{----tootip-----}}
            <label for="inputEmail4">Forma de pago</label>

            <select wire:model="Nuevo_tipomov" name="tipo" id="tipo" class="agregarInputs form-control" required >
                <option  value="" >--Selecciona Forma--</option>
                <option>Cheque</option>
                <option>Transferencia</option>
                <option>Domiciliación</option>
                <option>Efectivo</option>
            </select>
          </div>


          <div class="form-group col-md-6">
                {{---tooltip---}}
            <i id="info" class="fa fa-info-circle" aria-hidden="true"></i>
            <span  id="factura" class="tooltiptext">En caso de no tener un número de factura,
            escriba brevemente que es lo que está pagando.
            Si se trata de un cheque, también escriba número de cheque.</span>
              {{---tooltip---}}
            <label for="inputPassword4">#Factura</label>
            <input class="form-control" type=text  name="Nuevo_numCheque"
            placeholder="Describa lo que está pagando" wire:model="Nuevo_numcheque" required>
          </div>
        </div>
        <div class="form-group">
            {{---tooltip---}}
            <i id="info" class="fa fa-info-circle" aria-hidden="true"></i>
         <span id="fecha" class="tooltiptext">Escriba la fecha en que realizó el pago.</span>
         {{---tooltip---}}
          <label for="inputAddress">Fecha de pago</label>
          <input class="form-control" id="fecha" wire:model="Nuevo_fecha"  type=date   min="2014-01-01"
          max={{ $date }}  required >

        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                {{---tooltip---}}
                <i id="info" class="fa fa-info-circle" aria-hidden="true"></i>
                        <span id="pagado" class="tooltiptext">La cantidad que se pagó con pesos y centavos.</span>
                {{----tootip-----}}
              <label for="inputEmail4">Total pagado</label>

              <input class="form-control" wire:model="Nuevo_importecheque" type="number"  step="0.01" placeholder="pesos y centavos Ej. 98.50" name="importeCheque">
            </div>
            <div class="form-group col-md-6">
                  {{---tooltip---}}

                {{---tooltip---}}
              <label for="inputPassword4">Total factura(s):</label>
              <input class="form-control" type=text  readonly name="importeT"
                            value="">
            </div>
          </div>
        <div class="form-row">
          <div class="form-group col-md-6">
              {{---tooltip---}}
            <i id="info" class="fa fa-info-circle" aria-hidden="true"></i>
            <span id="beneficiario" class="tooltiptext"> Razón social a quien realizó el pago.
            </span>
            {{---tooltip---}}
            <label for="inputCity">Beneficiario</label>
            <input class="form-control" wire:model="Nuevo_beneficiario" type=text name="beneficiario"
               placeholder="A quien realizó el pago" required>
          </div>
          <div class="form-group col-md-4">
              {{---tooltip---}}
            <i id="info" class="fa fa-info-circle" aria-hidden="true"></i>
            <span id="operacion" class="tooltiptext"> Seleccione que fue lo que pagó.
            </span>
            {{---tooltip---}}
            <label for="inputState">Tipo de operación</label>
            <select wire:model="Nuevo_tipoopera" class="form-control" name="tipoOperacion" required>
                <option  value="" >--Selecciona tipo--</option>
                <option>Impuestos</option>
                <option>Nómina</option>
                <option>Gasto y/o compra</option>
                <option>Sin CFDI</option>
                <option>Parcialidad</option>
                <option>Otro</option>
            </select>
          </div>



        </div>
        <div class="form-group">
            <div class="form-group col-md-12">
            {{---tooltip---}}
            <i id="info" class="fa fa-info-circle" aria-hidden="true"></i>
            <span id="pdf" class="tooltiptext"> Sube un comprobante del movimiento.
            </span>
         {{---tooltip---}}
          <label for="inputAddress">Comprobante (PDF)</label>
          <div class="custom-file">
            <input type="file"  wire:model="Nuevo_nombrec" class="custom-file-input" id="customFileLang" lang="es">
            <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
          </div>
            </div>
        </div>



        <div id="drop-zone">
            <p class="mt-5 text-center">
                <p class="pf">Archivos Adicionales (solo PDF):</p>
                <label for="attachment">
                    <a class="btn btn-primary text-light " role="button" id="btnupload"  aria-disabled="false">Agregar.. <i class="fa fa-upload"></i></a>

                </label>

                <input  wire:model="pushArchivos"  type="file" accept=".pdf" id="attachment" style="visibility: hidden; position: absolute;" multiple />

            </p>
            <p id="files-area">
                <span id="filesList">
                    <span id="files-names"></span>
                </span>
            </p>
        </div>




        <button type="submit" class="btn btn-primary">Crear Cheque</button>

    </form>






</div>

<!-------------------------------------------- -->


        </div>  <!-- fin modal body -->


    </div>
</div>




</div>





</div>{{----FIN DIV PRINCIPAL----}}
