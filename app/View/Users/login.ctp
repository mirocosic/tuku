<div class="container">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <h3 class="form-signin-heading text-center">Prijava</h3>
        <div class="form-group">
            <label for="UserUsername" class="sr-only">Broj naloga</label>
        <?php echo $this->Form->input('username', ['class'=>'form-control','placeholder'=>'E-mail','label'=>'E-mail']);
            echo $this->Form->input('password', ['class'=>'form-control','placeholder'=>'Lozinka','label'=>'Lozinka']);
       
        ?>
        </div>
    </fieldset>
    <button class="btn btn-lg btn-info btn-block" type="submit">Prijavi se</button>
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->element('sql_dump'); ?>
</div>