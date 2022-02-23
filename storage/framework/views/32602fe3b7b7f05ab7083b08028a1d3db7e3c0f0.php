<div>
 



    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="javascript:void(0);" data-toggle="dropdown"><i class="ficon bx bx-bell bx-tada bx-flip-horizontal"></i><span class="badge badge-pill badge-danger badge-up"><?php echo e(count($notifications)); ?></span></a>
        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
          <li class="dropdown-menu-header">
          

            <div class="dropdown-header px-1 py-75 d-flex justify-content-between"><span class="notification-title"><?php echo e(count($notifications)); ?> Nuevas Notificaciones</span><span class="text-bold-400 cursor-pointer">....</span></div>
          </li>


     
 

<li class="scrollable-container media-list"><a class="d-flex justify-content-between" href="javascript:void(0);">
 
    <?php if(auth()->user()->tipo): ?>           
    <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $noti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  

              <div class="media d-flex align-items-center">
                <div class="media-left pr-0">
                 <!-- <div class="avatar mr-1 m-0"><img src="app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="39" width="39"></div>-->
                </div>
                <div class="media-body">

                  <h6 class="media-heading"><span class="text-bold-500">  <?php echo e($noti->rfc); ?></span> ¡Agrego un nuevo cheque!<br>#Cheque:&nbsp; <?php echo e($noti->numcheque); ?></h6><small class="notification-text">Fecha de pago:&nbsp;<?php echo e($noti->fecha); ?><br><?php echo e($noti->created_at->diffForHumans()); ?></small>
                </div>

                    <h6 class="media-heading mb-0">Cerrar</h6>

              </div></a><a class="d-flex justify-content-between read-notification cursor-pointer" href="javascript:void(0);">


               

                

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



<?php endif; ?>    
</li>

             

              
          <li class="dropdown-menu-footer"><a class="dropdown-item p-50 text-primary justify-content-center" href="javascript:void(0)">....</a></li>
        </ul>
      </li>



    
</div>
<?php /**PATH C:\sistema\resources\views/livewire/notification-secction.blade.php ENDPATH**/ ?>