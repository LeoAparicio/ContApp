@extends('layouts.livewire-layout')


<head>
    <title>Cheques y Transferencias Contarapp</title>
</head>
@php
use App\Models\Cheques;
use App\Http\Controllers\ChequesYTransferenciasController;
@endphp


@section('content')


    <div class="container" >
        <div class="float-md-left">
            <a class="b3" href="{{ url('/modules') }}">
                << Regresar</a>
        </div>
        <div class="float-md-right">
            <p class="label2">Cheques y Transferencias</p>
        </div>
        <br>
         <!-- Your application content -->







        <hr style="border-color:black; width:100%;">
        <div class="justify-content-start">
            <label class="label1" style="font-weight: bold"> Sesión de: </label>
            <h1 style="font-weight: bold">{{ Auth::user()->nombre }}</h1>
            <h5 style="font-weight: bold">{{ Auth::user()->RFC }}</h5>
            <hr style="border-color:black; width:100%;">
        </div>
        @php
        $rfc = Auth::user()->RFC;

     @endphp

        <div class="row justify-content-end">
            <div class="col-sm-7">
                <form class="form-inline">
                    <label class="pf" for="mes">Seleccione el periodo: </label>
                    <div class="form-group">
                        <select class="form-control m-2" id="mes" name="mes" >
                            <option value="00">Todos</option>
                            <?php foreach ($meses as $key => $value) {
                                echo '<option value="' . $key . '">' . $value . '</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="anio" name="anio">
                            <?php foreach (array_reverse($anios) as $value) {
                                echo '<option value="' . $value . '">' . $value . '</option>';
                            } ?>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary ml-2">Consultar</button>
                    </div>
                </form>
            </div>
            <div>



                <form action="{{ url('vincular-cheque') }}" method="POST">
                    @csrf
                    <button class="button2">Registrar Cheque/Transferencia</button>
                </form>
            </div>
        </div>

        <form >

            <div  class="mw-100" style="text-align: center; " >
            @php
            $fechamx = new Cheques();
            $mes_actual= date("m");
            @endphp
            @if ((!empty($_GET['filtro_cheques'])))

             <h5 style="font-weight: bold"> @php echo "Busqueda:&nbsp;".$_GET['filtro_cheques'];@endphp </h5>

             @elseif (!empty($_GET['mes']))
             <h5 style="font-weight: bold"> @php echo  $fechamx->fecha_es($_GET['mes']);@endphp </h5>
            @else

            <h5 style="font-weight: bold"> @php echo  $fechamx->fecha_es($mes_actual);@endphp </h5>

          @endif





            </div>


        <div class="input-group">

            <span  style ="display: none;" class="input-group-text" >Buscar</span>

            <a class="btn btn-secondary " style="width: 100px;" href="{{ url('cheques-transferencias') }}" >X Filtro</a>


            <button type="submit" class="btn btn-primary ml-2">Busca</button>
            <input id="" name="filtro_cheques" type="text" class="form-control" placeholder="Filtra por palabra clave fecha/ Num de factura/ etc...	">
              <!-- se deshabilita la funcion busqueda automatica en tabla por script -->
         </div>
        </form>
        <br>
    </div>
    <div class="mx-4" style="overflow: auto" id="table_refresh" >
        <a onclick="limpiar()"> recarga</a>
    <div >
        <table  id="tabla" >
            <thead>
                <tr class="row100 head" >
                   <!-- <th   class="cell100 column1" scope="col">No.</th>-->
                    <th   class="cell100 column1" scope="col">Fecha de pago</th>
                    <th  class="cell100 column1" scope="col">Núm de factura</th>
                    <th   >Beneficiario</th>
                    <th  class="cell100 column1" scope="col">Tipo de operación</th>
                    <th  class="cell100 column1" scope="col">Forma de pago</th>
                    <th  class="cell100 column1" scope="col">Total pagado</th>
                    <th  class="cell100 column1" scope="col">Total CFDI</th>
                    <th  class="cell100 column1" scope="col">Por comprobar</th>
                    <!--if (Session::get('tipoU') == '2')-->
                        <th class="cell100 column1" scope="col">Ajuste</th>
                    <!--endif-->
                    <th  class="cell100 column1" scope="col">PDF cheque o transferencia</th>
                    <th  class="cell100 column1" scope="col">Documentos adicionales</th>
                    <th  class="cell100 column1" scope="col">Acciones</th>
                    @if (Session::get('tipoU') == '2')
                        <th scope="col" colspan="2">Contabilizado</th>
                    @endif
                  <!--  <th  class="cell100 column1" scope="col">Comentarios</th>
                    <th  class="cell100 column1" scope="col">Cheque id</th>
                  -->
                </tr>
            </thead>
            <tbody class="buscar">
                @foreach ($colCheques as $i)
              
                    @php
                       
                        $editar = true;
                        $id = $i['_id'];
                        $tipo = $i['tipomov'];
                        $fecha = $i['fecha'];
                        $numCheque = $i['numcheque'];
                        $beneficiario = $i['Beneficiario'];
                        $importeC = $i['importecheque'];
                        $sumaxml = $i['importexml'];
                        $ajuste = $i['ajuste'];
                        $verificado = $i['verificado'];
                        $faltaxml = $i['faltaxml'];
                        $contabilizado = $i['conta'];
                        $pendiente = $i['pendi'];

                        $tipoO = $i['tipoopera'];
                        if ($tipoO == 'Impuestos' or $tipoO == 'Parcialidad') {
                            $diferencia = 0;
                        } else {
                            $diferencia = $importeC - abs($sumaxml);
                            $diferencia = $diferencia - $ajuste;
                        }
                        if ($diferencia > 1 or $diferencia < -1) {
                            $diferenciaP = 0;
                        } else {
                            $diferenciaP = 1;
                        }
                        $diferencia = number_format($diferencia, 2);

                        $nombreCheque = $i['nombrec'];
                        if ($nombreCheque == '0') {
                            $subirArchivo = true;
                            $nombreChequeP = 0;
                        } else {
                            $subirArchivo = false;
                            $nombreChequeP = 1;
                        }

                        $rutaArchivo = $rutaDescarga . $nombreCheque;
                        if (!empty($i['doc_relacionados'])) {
                            $docAdi = $i['doc_relacionados'];
                        }

                        $revisado_fecha = $i['revisado_fecha'];
                        $contabilizado_fecha = $i['contabilizado_fecha'];
                        $poliza = $i['poliza'];
                        $comentario = $i['comentario'];
                    @endphp
                    <tr class="CellWithComment">
                        <!--<td data-label="No">{{ ++$n }}</td>-->
                        <td data-label="Fecha de pago">
                            {{ $fecha }}
                           <!-- @if (isset($comentario) && $verificado == 0)
                                <span class="CellComment">{{ $comentario }}</span>
                            @endif-->
                        </td>
                        <td data-label="#factura">{{ $numCheque }}</td>
                        <td data-label="Beneficiario">{{ $i->Beneficiario}}</td>

                        <td data-label="Operación">{{ $tipoO }}</td>
                        <td data-label="forma de pago">{{ $tipo }}</td>
                        <td data-label="Total pagado">${{ number_format($importeC, 2) }}</td>
                        <td data-label="Total CFDI">${{ number_format($sumaxml, 2) }}</td>
                        <td data-label="Por Comprobar">${{ $diferencia }}</td>
                        <td class="text-center align-middle CellWithComment">
                            @include('modals')
                        @if (Session::get('tipoU') == '2')


<!-- seccion ajustes -->

<li  style="list-style:none; "  >
    @if ($ajuste == 0)
     <a id="tooltip" href="#" style="text-decoration: none; " class="icons fas fa-balance-scale"
      data-toggle="modal" data-target="#ajuste{{$n}}">
     </a>
     @else
     <a id="tooltip" href="#" style="text-decoration: none; " class="content_true fas fa-balance-scale"
      data-toggle="modal" data-target="#ajuste{{$n}}">
     </a>
     @endif
     <span class="tooltip-content">Ajuste</span>
      </li>
      <hr>
      @endif
           <!--fin  seccion ajustes -->

                    <!---icon seccion comentarios -->

                       <li  style="list-style:none; "  >

                        @if (isset($comentario) && $verificado == 0)
                         <a id="tooltip"  href="#" style="text-decoration: none; " class="content_true fas fa-comments"
                          data-toggle="modal" data-target="#comentarios{{$n}}">
                         </a>
                         @else
                         <a id="tooltip"  href="#" style="text-decoration: none; " class="icons fas fa-comments"
                          data-toggle="modal" data-target="#comentarios{{$n}}">
                         </a>
                         @endif
                         <span class="tooltip-content">Comentarios</span>
                          </li>
                        <!--- fin icon seccion comentarios -->

                            </td>

                        <td data-label="Pdf">
                            @if ($nombreCheque == '0')
                                <i class="far fa-times-circle fa-2x" style="color: rgb(255, 44, 44)"></i>
                            @else
                                <a id="rutArc" href="{{ $rutaArchivo }}" target="_blank">
                                    <i class="fas fa-file-pdf fa-2x" style="color: rgb(202, 19, 19)"></i>
                                </a>
                                <br><br>
                                    <form action="{{ url('borrarArchivo') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button  class="fabutton"  onclick="return confirm('¿Seguro que deseas eliminar el Pdf ?')" type="submit" >
                                            <i class="fas fa-trash-alt fa-lg" style="color: rgb(8, 8, 8)"></i>
                                        </button>
                                    </form>

                            @endif
                        </td>

                        <td data-label="D. adicionales" >
                            @if (empty($i['doc_relacionados']))
                            <a  href="#" style="text-decoration: none; " class="icons fas fa-falder-open"
                            data-toggle="modal"  id="{{$id}}" onclick="filepond(this.id)" data-target="#relacionados-{{$id}}">
                           </a>
                       <hr>
                           <a  href="#" style="text-decoration: none; " class="icons fas fa-upload"
                           data-toggle="modal" id="{{$id}}" onclick="filepond(this.id)"  data-target="#uploadRelacionados">
                          </a>

                           <!--    <a  href="#" style="text-decoration: none; " class="icons fas fa-falder-open"
                            data-toggle="modal"  id="{{$id}}" onclick="filepond(this.id)" data-target="#relacionados-{{$id}}">
                           </a> -->


                            @else

                                @if (!$docAdi['0'] == '')
                                <a  href="#" style="text-decoration: none; " class="content_true fas fa-folder-open"
                                data-toggle="modal"  id="{{$id}}" onclick="filepond(this.id)" data-target="#relacionados-{{$id}}" >
                               </a>

                               <hr>
                               <a  href="#" style="text-decoration: none; " class="icons fas fa-upload"
                               data-toggle="modal" id="{{$id}}" onclick="filepond(this.id)"  data-target="#uploadRelacionados">
                              </a>
                                @else
                                <a  href="#" style="text-decoration: none; " class="icons fas fa-folder-open"
                                data-toggle="modal"  id="{{$id}}" onclick="filepond(this.id)" data-target="#relacionados-{{$id}}" >
                               </a>
                               <hr>
                               <a  href="#" style="text-decoration: none; " class="icons fas fa-upload"
                               data-toggle="modal" id="{{$id}}" onclick="filepond(this.id)"  data-target="#uploadRelacionados">
                             </a>


                                @endif
                            @endif
                        </td>
                        <td data-label="Acciones">
                            <div class="row align-items-center">
                                @if ($faltaxml != 0)
                                    <div class="col align-self-center">
                                        <form action="{{ url('detallesCT') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <input type="hidden" name="verificado" value="{{ $verificado }}">
                                            <button type="submit" class="fabutton">
                                                <i class="fas fa-eye fa-lg mt-3" style="color: rgb(8, 8, 8)"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                                @if ($verificado == 0)
                                    <div class="col align-self-center">
                                        <form action="{{ url('vincular-cheque') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="editar" value="{{ $editar }}">
                                            <input type="hidden" id="id" name="id" value="{{ $id }}">
                                            <input type="hidden" name="tipo" value="{{ $tipo }}">
                                            <input type="hidden" name="numCheque" value="{{ $numCheque }}">
                                            <input type="hidden" name="fechaCheque" value="{{ $fecha }}">
                                            <input type="hidden" name="importeCheque" value="{{ $importeC }}">
                                            <input type="hidden" name="importeT" value="{{ $sumaxml }}">
                                            <input type="hidden" name="beneficiario" value="{{ $beneficiario }}">
                                            <input type="hidden" name="tipoOperacion" value="{{ $tipoO }}">
                                            <input type="hidden" name="subirArchivo" value="{{ $subirArchivo }}">
                                            <input type="hidden" name="nombrec" value="{{ $nombreCheque }}">
                                            <input type="hidden" name="ruta" value="{{ $rutaArchivo }}">

                                            <button type="submit" class="fabutton">
                                                <i   class="fas fa-edit fa-lg" style="color: rgb(8, 8, 8)"></i>
                                            </button>
                                        </form>
                                       <!-- <a class="fas fa-edit fa-lg"   data-toggle="modal" data-target="#editar{{$n}}"> </a>-->


     <!-- MODAL RELACIONADOS-->
     <livewire:relacionados  :filesrelacionados=$i : key="$i->id" >

       <livewire:editar  :editCheque=$i : key="$i->id">
        <!--FIN  MODAL RELACIONADOS-->

                                    </div>
                                @endif
                                @if ($verificado == 0)
                                    <div class="col align-self-center">
                                        <form action="{{ url('delete-cheque') }}" method="POST">
                                            @csrf
                                            <input type="hidden" id="id" name="id" value="{{ $id }}">
                                            <input type="hidden" name="rutaArchivo" value="{{ $rutaArchivo }}">
                                            <button
                                                onclick="return confirm('¿Seguro que deseas eliminar el cheque/transferencia?')"
                                                type="submit" class="fabutton">
                                                <i class="fas fa-trash-alt fa-lg" style="color: rgb(8, 8, 8)"></i>
                                            </button>
                                        </form>
                                    </div>

                                @endif
                            </div>
                        </td>
                        @if (Session::get('tipoU') == '2')
                            <td >
                                <div class="mx-1">
                                    @if ($tipo != 'Efectivo' and ($tipoO == 'Impuestos' || $tipoO == 'Sin CFDI' ? $nombreCheque == '0' : ($faltaxml == 0 or $diferenciaP != 1 or $nombreCheque == '0')))
                                        @php
                                            Cheques::find($id)->update(['pendi' => 1]);
                                        @endphp


                                         <a   style="text-decoration: none; " class="alert parpadea fas fa-exclamation"
                                          onclick="alertaP({{ $diferenciaP }},{{ $faltaxml }}, {{ $nombreChequeP }})">
                                        </a>

                                    @elseif ($verificado == 0 )
                                        <form action="{{ url('cheques-transferencias') }}" method="POST">
                                            @csrf
                                            <input type="hidden" id="id" name="id" value="{{ $id }}">
                                            <input type="checkbox" name="revisado" required class="mb-2">
                                            Revisado
                                            <input type="submit" name="Aceptar" value="Aceptar">
                                        </form>
                                    @else
                                        <i class="far fa-check-circle fa-2x" style="color: green"></i>
                                        @if (isset($revisado_fecha))
                                            <div class="mt-1">{{ $revisado_fecha }}</div>
                                        @endif
                                    @endif
                                </div>
                            </td>
                            <td class="text-center align-middle" style="width: 150px">
                                <div class="mx-1">
                                    @if ($verificado == 1 and $contabilizado == 0)
                                        <form action="{{ url('cheques-transferencias') }}" method="POST">
                                            @csrf
                                            <input type="hidden" id="id" name="id" value="{{ $id }}">
                                            <input type="checkbox" name="conta" required class="mt-4">
                                            Contabilizado
                                            <div>
                                                Póliza:
                                                <input type="text" name="poliza" size="2" required class="mt-1 mb-2">
                                            </div>
                                            <input type="submit" name="Aceptar" value="Aceptar">
                                        </form>
                                    @elseif ($verificado == 1 and $contabilizado == 1)
                                    <a   style="text-decoration: none; " class="icon_basic fas fa-calculator">
                                    </a>
                                        @if (isset($contabilizado_fecha))
                                            <div class="mt-1">{{ $contabilizado_fecha }}</div>
                                        @endif
                                        @if (isset($poliza))
                                            <div class="mt-1">Póliza: {{ $poliza }}</div>
                                        @endif
                                    @else
                                    <a   style="text-decoration: none; " class="alert fas fa-file-invoice-dollar">
                                   </a>

                                    @endif
                                </div>
                            </td>
                        @endif
                        <!--
                        <td data-label="Comentarios">
                            <div class="mx-1">
                                @if ($verificado != 0)
                                    @if (isset($comentario))
                                        {{ $comentario }}
                                    @else
                                        -
                                    @endif
                                @else
                                    <form action="{{ url('cheques-transferencias') }}" method="POST">
                                        @csrf
                                        <input type="hidden" id="id" name="id" value="{{ $id }}">
                                        <textarea name="comentario" cols="20" rows="2" class="mb-2"></textarea>
                                        <input type="submit" value="Aceptar">
                                    </form>
                                @endif
                            </div>
                        </td>
                        <td data-label="cheque id">{{ $id }}</td>
                    se eliminan los campos -->
                    </tr>
                @endforeach
            </tbody>
        </table>

        <livewire:uploadrelacionados  >

    </div><!-- Fin del div refresh tabla-->
    </div>
    <div class="ml-4 mt-3">
        {{ $colCheques->appends(Request::except('page'))->links('pagination::bootstrap-4') }}
    </div>

    <nav class="nav">

        <li class="nav__link" >
        <form >
        <button type="submit" class="alert parpadea fas fa-exclamation" style="width: 60px; height:5px;">

            </button>
            <input type="hidden" name="filtro" value="pendientes" >
            <span class="nav__text">
                @php  $p =new ChequesYTransferenciasController();
                  echo $p->pendientes($rfc);
                @endphp
                    Pendientes</span>
          </form>
        </li>
        <li class="nav__link">
        <form >
            <button type="submit" class="icon_basic fas fa-low-vision" style="width: 60px; height:5px;">
            </button>
          <span class="nav__text">
            <input type="hidden" name="filtro" value="Sin_revisar" >
            @php  $verif =new ChequesYTransferenciasController();
            echo $verif->verificado($rfc);
           @endphp
            Sin Revisar</span>

          </form>
        </li>

        <li class="nav__link">
          <form>
            <button type="submit"class="icon_basic fas fa-calculator" style="width: 60px; height:5px;">
            </button>
          <span class="nav__text">
            <input type="hidden" name="filtro" value="Sin_contabilizar" >
            @php  $cont =new ChequesYTransferenciasController();
             echo $cont->contabilizado($rfc);
            @endphp
         Sin contabilizar</span>

          </form>
        </li>

      </nav>

      




@endsection


