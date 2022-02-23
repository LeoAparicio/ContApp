

<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cheques;
use App\Http\Controllers\ChequesYTransferenciasController;
?>

<?php $__env->startSection('content'); ?>

    <div class="container" >
        <div class="row justify-content-center">
            <div class="inicio" align="center">
              <?php if(Session::get('tipoU') == '3'): ?>
                    <h4>Esta entrando como contador a la</h4>
                <?php endif; ?>
                <h4>Sesión de:</h4>
                <br>

                <?php

                $rfc = Auth::user()->RFC;
                $tipo = Session::get('tipoU');

                
            ?>


                <h2 id="txtsaludo">Bienvenid@</h2>
                <?php if(!empty(auth()->user()->tipo)): ?>
                <h5>Contador@</h5>
                <?php endif; ?>


                <?php if(Auth::check()): ?>

                <h6><?php echo e(auth()->user()->RFC); ?></h6>
                
                        <?php endif; ?>

                          
                        
                        
            

                       

 
        </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>




<!-- en el @seccion

<div class="row" style="justify-content: center;">
    <div class="col">
        <form action="<?php echo e(url('descargasv2')); ?>">
            
            <input type="hidden" id="user" value="<?php echo e($tipo); ?>">
            <button onclick="fun1();" id="function1" class="btnModulo" type="submit" value="Descargas" style="font-size: 12pt">
                <img style="float:left;" src="img/boton.png" width="25px" height="25px" alt=""> Descargas
            </button>
            <div id="noDis1"></div>
        </form>
    </div>
    <div class="col">
        <form action="<?php echo e(url('consultas')); ?>">
            <input type="hidden" id="user" value="<?php echo e($tipo); ?>">
            <button onclick="fun1();" id="function2" class="btnModulo" type="submit" value="Consultas" style="font-size: 12pt">
                <img style="float:left;" src="img/lupa.png" width="25px" height="25px" alt=""> Consultas
            </button>
            <div id="noDis2"></div>
        </form>
    </div>
    <div class="col">
        <form action="<?php echo e(url('construccion')); ?>">
            <button class="btnModulo" type="submit" value="Expediente Digital" >
                <img style="float:left;" src="img/archivo(1).png" width="25px" height="25px" alt="">
                Expediente Digital
            </button>
        </form>
    </div>
        <div class="col">
            <form action="<?php echo e(url('volumetrico')); ?>">
                <button class="btnModulo" type="submit" value="Expediente Digital"
                    >
                    <img style="float:left;" src="img/estadisticas.png" width="25px" height="25px" alt="">
                    Control Volumétrico
                </button>
            </form>
        </div>

</div>
<br>
<div class="row" style="justify-content: center;">
    <div class="col">
        <form action="<?php echo e(url('cuentasporpagar')); ?>">
            <button class="btnModulo" type="submit" value="Cuentas por pagar" >
                <img style="float:left;" src="img/cuenta.png" width="25px" height="25px" alt=""> Cuentas por
                pagar
            </button>
        </form>
    </div>
    <div class="col">
        <form action="<?php echo e(url('cheques-transferencias')); ?>">
            <button class="btnModulo" type="submit" value="Cheques y Transferencias"
                style="height:55px; font-size: 9pt">
                <img style="float:left;" src="img/cheque.png" width="20px" height="20px" alt=""> Cheques y
                Transferencias
            </button>
        </form>
    </div>
    <div class="col">
        <form action="<?php echo e(url('construccion')); ?>">
            <button class="btnModulo" type="submit" value="Expediente Fiscal" >
                <img style="float:left;" src="img/fiscal.png" width="25px" height="25px" alt=""> Expediente
                Fiscal
            </button>
        </form>
    </div>
    <div class="col">
        <form action="<?php echo e(url('construccion')); ?>">
            <button class="btnModulo" type="submit" value="Nomina" >
                <img style="float:left;" src="img/salario.png" width="25px" height="25px" alt=""> Nómina
            </button>
        </form>
    </div>
</div>
<br>
<div class="row" style="justify-content: center;">
    <div class="col">
        <form action="<?php echo e(url('monitoreo')); ?>">
            <input type="hidden" id="user" value="<?php echo e($tipo); ?>">
            <button onclick="fun1();" id="function3" class="btnModulo" type="submit" value="Nomina" >
                <img style="float:left;" src="img/monitoreo.png" width="25px" height="25px" alt="">
                Monitoreo Facturación
            </button>
            <div id="noDis3"></div>
        </form>
    </div>
    <div class="col">
        <form action="<?php echo e(url('auditoria')); ?>">
            <input type="hidden" id="user" value="<?php echo e($tipo); ?>">
            <button onclick="fun1();" id="function4" class="btnModulo" type="submit" value="Nomina" >
                <img style="float:left;" src="img/searcher.png" width="25px" height="25px" alt="">
                Auditoría
            </button>
            <div id="noDis4"></div>
        </form>
    </div>
</div>
<br><br>



<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="exampleModalLongTitle">Atención:</h4>
&nbsp;<h6>Tienes asuntos pendientes en modulo Cheques y Transferencias  </h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<?php



?>
<h4> <img src="img/warning.png" style="width:30px;">  Tienes: <?php  $p =new ChequesYTransferenciasController();  echo $p->pendientes($rfc); ?> pendientes   </h4><br>
<h4> <img src="img/sin_verificar.png" style="width:30px;">  Tienes: <?php  $verif =new ChequesYTransferenciasController();  echo $verif->verificado($rfc); ?> sin revisar  </h4><br>
<h4> <img src="img/sin_contabilizar.png" style="width:30px;">   Tienes: <?php  $cont =new ChequesYTransferenciasController();  echo $cont->contabilizado($rfc); ?> sin contabilizar  </h4>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
<form action="<?php echo e(url('chequesytransferencias')); ?>">
<button class="btn btn-primary" type="submit" value="Cheques y Transferencias"
>Ir al modulo
</button>
</form>


</div>
</div>
</div>
</div>





<div class="row" style="justify-content: center;">
    <form action="<?php echo e(route('logout')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <input class="cerrarSesion" type="submit" value="Cerrar Sesión"
            style="BORDER: #0055FF 1px solid; FONT-SIZE: 10pt">
    </form>
</div>


-->

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Conta\Contarapp2.0\resources\views/home.blade.php ENDPATH**/ ?>