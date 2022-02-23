

<?php
use App\Models\MetadataR;
use App\Models\ListaNegra;
?>

<head>
    <title>Cuentas por pagar Contarapp</title>
</head>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="float-md-left">
            <a class="b3" href="<?php echo e(url('/modules')); ?>">
                << Regresar</a>
        </div>
        <div class="float-md-right">
            <p class="label2">Cuentas por pagar</p>
        </div>
        <br>
        <hr style="border-color:black; width:100%;">
        <div class="justify-content-start">
            <label class="label1" style="font-weight: bold"> Sesión de: </label>
            <h1 style="font-weight: bold"><?php echo e(Auth::user()->nombre); ?></h1>
            <h5 style="font-weight: bold"><?php echo e(Auth::user()->RFC); ?></h5>
            <hr style="border-color:black; width:100%;">
        </div>

        <div class="row justify-content-end">
            <form>
                <button class="button2" id="vinpbtn">Vincular Varios Proveedores</button>
            </form>
        </div>

        <div class="input-group">
            
            <span class="input-group-text">Buscar</span>
            <input id="filtrar" type="text" class="form-control" placeholder="Buscar proveedor">
            <a id="vinp" href="#bottom" class="btn btn-primary ml-2">Ir a vincular proveedores</a>
        </div><br>
        <form action="<?php echo e(url('detalles')); ?>" method="GET">
            <div style="overflow: auto">
                <table class="table table-sm table-hover table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th class="text-center align-middle">N°</th>
                            <th id="vinp" class="text-center align-middle">Vincular Proveedores</th>
                            <th class="text-center align-middle">RFC Emisor</th>
                            <th class="text-center align-middle">Razón Social</th>
                            <th class="text-center align-middle">Lista Negra</th>
                            <th class="text-center align-middle">N° de CFDI's</th>
                            <th class="text-center align-middle">Total</th>
                            <th class="text-center align-middle">Detalles</th>
                        </tr>
                    </thead>
                    <tbody class="buscar">
                        <?php $__currentLoopData = $col; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $sum = 0;
                                $nXml = 0;
                                // Consulta para obtener el total de monto y cantidad de CFDI por empresa emisora
                                // Se aplicó un indice para agilizar la velocidad de consulta
                                $colT = DB::collection('metadata_r')
                                    ->select('total', 'efecto')
                                    ->where('receptorRfc', $rfc)
                                    ->where('emisorRfc', $i['emisorRfc'])
                                    ->where('estado', '<>', 'Cancelado')
                                    ->whereNull('cheques_id')
                                    ->get();
                                $nXml = $colT->count();
                                // Convierte el campo total en en float y negativo si es egreso
                                foreach ($colT as $v) {
                                    $var = (float) $v['total'];
                                    if ($v['efecto'] == 'Egreso') {
                                        $var = -1 * abs($var);
                                    }
                                    $sum = $sum + $var;
                                }
                                $tXml = $tXml + $nXml;
                                $tTabla = $tTabla + $sum;
                            ?>
                            
                            <?php if(!$nXml == 0): ?>
                                <tr>
                                    <td class="text-center align-middle"><?php echo e(++$n); ?></td>
                                    <td id="vinp" class="text-center align-middle">
                                        <div id="checkbox-group" class="checkbox-group">
                                            <input class="mis-checkboxes" type="checkbox" id="allcheck" name="allcheck[]"
                                                value="<?php echo e($i['emisorRfc']); ?>" />
                                        </div>
                                    </td>
                                    <td class="text-center align-middle"><?php echo e($i['emisorRfc']); ?></td>
                                    <td class="align-middle"><?php echo e($i['emisorNombre']); ?></td>
                                    
                                    <?php if(!DB::collection('lista_negra')->select('RFC')->where(['RFC' => $i['emisorRfc']])->exists()): ?>
                                        <td class="td1 text-center align-middle"><img src="<?php echo e(asset('img/ima.png')); ?>"
                                                alt="">
                                        </td>
                                    <?php else: ?>
                                        <td class="td1 text-center align-middle"><img src="<?php echo e(asset('img/ima2.png')); ?>"
                                                alt="">
                                        </td>
                                    <?php endif; ?>
                                    <td class="text-center align-middle"><?php echo e($nXml); ?></td>
                                    <td class="text-center align-middle">$<?php echo e(number_format($sum, 2)); ?></td>
                                    <td class="text-center align-middle">
                                        <form action="detalles" method="GET">
                                            <input type="hidden" name="emisorRfc" value="<?php echo e($i['emisorRfc']); ?>">
                                            <input type="hidden" name="emisorNombre" value="<?php echo e($i['emisorNombre']); ?>">
                                            <input type=submit value=Ver>
                                        </form>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td id="vinp"></td>
                            <td class="text-center text-bold">Total:</td>
                            <td class="text-center text-bold"><?php echo e($tXml); ?></td>
                            <td id="bottom" class="text-center text-bold">$<?php echo e(number_format($tTabla, 2)); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                <input id="vinpsub" type="submit" value="Vincular Proveedores"
                    style="color:#0055ff; BORDER: #0055FF 1px solid; FONT-SIZE: 10pt; BACKGROUND-COLOR: #FFFFFF">
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Conta\Contarapp2.0\resources\views/cuentasporpagar.blade.php ENDPATH**/ ?>