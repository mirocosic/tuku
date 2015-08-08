<div class="container">
    <?php echo $this->Form->create('Order', array('url'=>array('controller'=>'Orders', 'action' => 'take_order'),'class'=>'form-signin')); ?>
    <h3 class="form-signin-heading text-center">Unesi narudžbu</h3>
        <div class="form-group">
            <?php 
                echo $this->Form->input('address', ['class'=>'form-control','placeholder'=>'Adresa','label'=>false]);
                echo $this->Form->input('floor', ['class'=>'form-control','placeholder'=>'Kat','label'=>false]);
                echo $this->Form->input('name', ['class'=>'form-control','placeholder'=>'Prezime i Ime','label'=>false]);
                echo $this->Form->input('phone', ['class'=>'form-control','placeholder'=>'Broj telefona','label'=>false]);
                echo $this->Form->input('note', ['class'=>'form-control','placeholder'=>'Napomena','label'=>false]);
            ?>
        </div>
    <button class="btn btn-lg btn-info btn-block" type="submit">Unesi</button>
    <?php echo $this->Session->flash(); ?>
</div>