<div><!-- div contenedor principal-->


    <?php
use App\Models\Cheques;
use App\Http\Controllers\ChequesYTransferenciasController;
?>


        <?php
        $rfc = Auth::user()->RFC;
       $class='';
        if(empty($class)){
           $class="table nowrap dataTable no-footer";

        }



     ?>


          <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
          <div class="content-header row">
          </div>
          <div class="content-body"><!-- invoice list -->
  <section class="invoice-list-wrapper">
    <!-- create invoice button-->
    <div class="invoice-create-btn mb-1">

        <a  data-toggle="modal" data-target="#nuevo-cheque" class="btn btn-primary glow invoice-create"
   wire:click="editar()" >Nuevo Cheque/Transferencia </a>
    </div>
    <!--<form action="<?php echo e(url('vincular-cheque')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <button class="button2">Registrar Cheque/Transferencia</button>
    </form>-->

   <!-- <form  wire:submit.prevent="buscar">
        <?php echo csrf_field(); ?>

    <input wire:model.defer="search" type="text"  name="ajuste" class="form-control">

    <div wire:loading wire:target="buscar" >
        <div style="color: #3CA2DB" class="la-ball-clip-rotate-multiple">
          <div></div>
          <div></div>

      </div>
      Guardando ajuste
      </div>

    <button type="submit"   class="btn btn-primary close-modal">Ajustar</button>

         </form>-->

<?php if(empty(!$empresas)): ?>









<?php echo e($empresa); ?>


<br><br>


            <label for="inputState">Empresa</label>
            <select wire:model="rfcEmpresa" id="inputState1" class=" select form-control"  >
                <option  value="00" >--Selecciona Empresa--</option>
                <?php $rfc=0; $rS=1;foreach($empresas as $fila)
                {

                    echo '<option value="' . $fila[$rfc] . '">'. $fila[$rS] . '</option>';

          }
                ?>
            </select>

            &nbsp;&nbsp;<br>
<?php endif; ?>

            <div class="form-inline mr-auto">
            <input  wire:model.debounce.300ms="search" class="form-control" type="text" placeholder="Filtro" aria-label="Search">
            &nbsp;&nbsp;
            <label for="inputState">Mes</label>
            <select wire:model="mes" id="inputState1" class=" select form-control"  >
                <option  value="00" >Todos</option>
                <?php foreach ($meses as $key => $value) {
                    echo '<option value="' . $key . '">' . $value . '</option>';
                } ?>
            </select>
            &nbsp;&nbsp;
            <label for="inputState">Año</label>
            <select wire:model="anio" id="inputState2" class="select form-control">

                <?php foreach (array_reverse($anios) as $value) {
                    echo '<option value="' . $value . '">' . $value . '</option>';
                } ?>
            </select>
            &nbsp;&nbsp;
            <div class="form-check">
                <input class="form-check-input" type="checkbox" wire:model="todos"  name="stOne" id="stOne"  >
                <label class="form-check-label" for="flexCheckChecked">
                  Todos los registros
                </label>
              </div>
    &nbsp;&nbsp;
   
        <input  wire:model.debounce.300ms="importe" class="form-control"  placeholder="Importe $"  type="number"  step="0.01" aria-label="importe" style="width:110px;" >
        &nbsp;
        <select wire:model="condicion" id="inputState1" class=" select form-control"  >
            <option  value=">=" >--Condición--</option>
            <option value="=" >igual</option>
            <option value=">" >mayor que</option>
            <option value="<" >menor que</option>
        </select>


    
<!-- <input  wire:model.debounce.300ms="search" class="form-control" type="text" placeholder="Search" aria-label="Search">
           -->



        </div>







    <!-- Options and filter dropdown button-->
    <div class="action-dropdown-btn d-none">
      <div class="dropdown invoice-filter-action">
        <button class="btn border dropdown-toggle mr-1" type="button" id="invoice-filter-btn" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          Filter Invoice
        </button>

      </div>

    </div>
    <div class="table-responsive">
      <table id="example" class="<?php echo e($class); ?>" style="width:100%">
        <thead>
          <tr>

            <th>
              <span class="align-middle">fecha </span>
            </th>

            <th>Factura#</th>
            <th>T.operación</th>
            <th>F.pago</th>
            <th>Pagado</th>
            <th>$Cfdi</th>
            <th>comprobar</th>

            <th >...</th>





          </tr>
        </thead>
        <?php $__currentLoopData = $colCheques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php
         $editar = true;
        $id = $i->_id;
        $tipo = $i->tipomov;
        $fecha = $i->fecha;
        $dateValue = strtotime($fecha);
         $anio = date('Y',$dateValue);
        $rutaDescarga = 'storage/contarappv1_descargas/'.$rfc.'/'.$anio.'/Cheques_Transferencias/';
        $numCheque = $i->numcheque;
        $beneficiario = $i->Beneficiario;
        $importeC = $i->importecheque;
        $sumaxml = $i->importexml;
        $ajuste = $i->ajuste;
        $verificado = $i->verificado;
        $faltaxml = $i->faltaxml;
        $contabilizado = $i->conta;
        $pendiente = $i->pendi;
            $tipoO = $i->tipoopera;
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
            $nombreCheque = $i->nombrec;
            if ($nombreCheque == '0') {
                $subirArchivo = true;
                $nombreChequeP = 0;
            } else {
                $subirArchivo = false;
                $nombreChequeP = 1;
            }
            $rutaArchivo = $rutaDescarga . $nombreCheque;
            if (!empty($i->doc_relacionados)) {
                $docAdi = $i->doc_relacionados;
            }
            $revisado_fecha = $i->revisado_fecha;
            $contabilizado_fecha = $i->contabilizado_fecha;
            $poliza = $i->poliza;
            $comentario = $i->comentario;
        ?>
        <tbody>
     
          <tr onclick="showHideRow('hidden_row<?php echo e($id); ?>');">
            
            <td>
                <small class="text-muted">
                <?php if($tipo != 'Efectivo' and ($tipoO == 'Impuestos' || $tipoO == 'Sin CFDI' ? $nombreCheque == '0' : ($faltaxml == 0 or $diferenciaP != 1 or $nombreCheque == '0'))): ?>
                <?php
                    Cheques::find($id)->update(['pendi' => 1]);
                ?>
    
    
                 <a   style="color:red " class=" parpadea fas fa-exclamation"
                  onclick="alertaP(<?php echo e($diferenciaP); ?>,<?php echo e($faltaxml); ?>, <?php echo e($nombreChequeP); ?>)">
                </a>
             <?php endif; ?>
               <?php echo e($fecha); ?></small>
            </td>
            <td>
              <a href="app-invoice.html"><?php echo e(Str::limit($numCheque, 20)); ?></a>
            </td>
            <td><small class="text-muted"><?php echo e($tipoO); ?></small></td>

            <td><span class="invoice-amount"><?php echo e($tipo); ?></span></td>
            <td><span class="invoice-amount">$<?php echo e(number_format($importeC, 2)); ?></span></td>

            <td><span class="invoice-amount">$<?php echo e(number_format($sumaxml, 2)); ?></span></td>
            <td><span class="invoice-amount">$<?php echo e($diferencia); ?></span></td>
            <td><span class="invoice-amount">







          </tr>

          <tr id="hidden_row<?php echo e($id); ?>" class="hidden_row">
            <td colspan=12>
               <?php echo e($numCheque); ?><br>

               <div class="box">
                <?php if( auth()->user()->tipo): ?>
                <div>
                    <div class="tr"> Ajuste</div>



                    <?php if($ajuste!=0): ?>
                    <?php $class="content_true" ?>
                    <?php else: ?>
                   <?php $class="icons" ?>
                 <?php endif; ?>

                   <a class="<?php echo e($class); ?> fas fa-balance-scale"
                    data-toggle="modal" data-target="#ajuste<?php echo e($id); ?>"></a>


                </div>
                <?php endif; ?>
                <div>
                    <div class="tr"> Comentario</div>

               <?php if(!empty($comentario)): ?>

               <?php $class_c="content_true" ?>

               <?php else: ?>

               <?php $class_c="icons" ?>


            <?php endif; ?>

<a  class="<?php echo e($class_c); ?> fas fa-sticky-note"
data-toggle="modal" data-target="#comentarios-<?php echo e($id); ?>"> </a>

                </div>
                <div>
                    <div class="tr"> Pdf</div>
                     <?php if($nombreCheque!="0"): ?>
   <?php $class_p="content_true_pdf" ?>
   <?php else: ?>
   <?php $class_p="icons" ?>
    <?php endif; ?>

       <a id="<?php echo e($id); ?>" class="<?php echo e($class_p); ?> fas fa-file-pdf"
   data-toggle="modal" data-target="#pdfcheque<?php echo e($id); ?>"  onclick="filepondEditCheque(this.id)" > </a>



                </div>
                <div>
                    <div class="tr"> Documentos Adcionales</div>
                    <a class="icons fas fa-upload"
                    data-toggle="modal" data-controls-modal="#uploadRelacionados"  name="<?php echo e($id); ?>"  data-backdrop="static" data-keyboard="false"   onclick="filepond(this.name)"  data-target="#uploadRelacionados">
                   </a>

                    &nbsp; | &nbsp;
                    <?php if(!$docAdi['0'] == ''): ?>

                    <?php $class="content_true" ?>

                    <?php else: ?>

                    <?php $class="icons" ?>


                 <?php endif; ?>

                    <a  class="<?php echo e($class); ?> fas fa-folder-open"
                    data-toggle="modal"     data-target="#relacionados-<?php echo e($id); ?>" >
                   </a>

                </div>

                <div>
                <div class="tr">Vinculadas</div>
                    <?php if($faltaxml != 0): ?>

            <i class="content_true fa-eye " ></i>

        <?php else: ?>

        <i class="icons fas fas fa-eye" ></i>
                <?php endif; ?>


                      </div>

                      <div>
                        <div class="tr">Impresion</div>
                        <i class="icons fas fa-print" ></i>

                          </div>


                <div>
              <div class="tr"> Editar</div>
              <a  class="icons fas fa-edit"
              data-toggle="modal"     data-target="#editar-<?php echo e($id); ?>" >
             </a>

                </div>

                <div>
                    <div class="tr">Eliminar Cheque</div>
                    <?php if($verificado == 0): ?>



            <a onclick="return confirm('¿Seguro que deseas eliminar el cheque/transferencia?')" class="icons fas fa-trash"></a>


                <?php endif; ?>

                      </div>


                      <div>
                        <div class="tr">Cheque Id</div>
                                          <?php echo e($id); ?>


                                               </div>










   </span>
</div>

</div>
            </td>



        </tr>

         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
      <?php echo e($colCheques->links()); ?>



<?php echo \Livewire\Livewire::scripts(); ?>

    </div>
  </section>
          </div>
        </div>
      </div>








      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('uploadrelacionados', [])->html();
} elseif ($_instance->childHasBeenRendered('l425523562-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l425523562-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l425523562-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l425523562-0');
} else {
    $response = \Livewire\Livewire::mount('uploadrelacionados', []);
    $html = $response->html();
    $_instance->logRenderedChild('l425523562-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>



        <?php echo $__env->make('livewire.demo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      
</div><!-- fin div contenedor principal-->

 
            
<?php /**PATH C:\Conta\Contarapp2.0\resources\views/livewire/chequesytransferencias.blade.php ENDPATH**/ ?>