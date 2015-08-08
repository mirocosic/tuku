<div class="container">
      <h3 class="form-signin-heading text-center">Popis narudžbi</h3>
<div class="table-responsive">
  <table class="table table-striped table-bordered">
      <tr>
        <td>Id</td>
        <td>Status</td>
        <td>Vrijeme</td>
        <td>Adresa</td>
        <td>Ime</td>
        <td>Telefon</td>
        <td>Napomena</td>
        <td>Korisnik</td>
        <td>Akcije</td>
      </tr>

<?php foreach ($orders as $order):?>
    <tr>
        <td><?=$order['Order']['id'];?></td>
        <td><?=$order['OrderStatus']['name'];?></td>
        <td><?= date('d.m.Y H:i:s', strtotime($order['Order']['modified']));?></td>
        <td><?=$order['Order']['address'];?></td>
        <td><?=$order['Order']['name'];?></td>
        <td><?=$order['Order']['phone'];?></td>
        <td><?=$order['Order']['note'];?></td>
        <td><?=$order['User']['username'];?></td>
        <td>
            <a href="#DeleteModal" data-toggle="modal" id="<?=$order['Order']['id'];?>" data-target="#DeleteModal">DEL</a>, <a href="/orders/edit/<?php echo $order['Order']['id'];?>">EDIT</a> 
        </td>
    </tr>

<?php endforeach; ?>
    </table>
    
    <?php // debug($orders);?>
</div>
</div>

<!-- Delete modal -->
<div id="DeleteModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Jesi li siguran?</h4>
            </div>
            <div class="modal-body">
                <p>Jesi li siguran da želiš otkazati ovu narudžbu?</p>
                <p class="text-warning"><small>Ako otkažeš narudžbu, dostavljač neće doći po nju.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Odustani</button>
                <button type="button" class="btn btn-danger" id="DeleteModalCancelButton" onclick="">OTKAŽI</button>
            </div>
        </div>
    </div>
</div>

<div id="SuccessModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: green; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" >Otkazano!</h4>
            </div>
            <div class="modal-body">
                <p>Narudžba je uspješno otkazana!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
            </div>
        </div>
    </div>
</div>


<script>
    function CancelOrder(orderId){
        $.ajax({
            type: 'POST',
            url: '/orders/cancel_order',
            data: {
              id : orderId  
            },
            success: function(data){
               
                
                $("#DeleteModal").modal('hide');
                $("#SuccessModal").modal('show');
            }
       });
    }
    
        $('#DeleteModal').on('show.bs.modal', function(e) {
            
            var $modal = $(this);
            var OrderId = e.relatedTarget.id;
            $('#DeleteModalCancelButton').attr('onclick','CancelOrder('+OrderId+')');
            

        })
    </script>