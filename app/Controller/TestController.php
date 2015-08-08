<?php class TestController extends AppController {
 
      public function beforeFilter() {
        $this->Auth->allow();
    }
    
    
    
    function hashpass($password = null){
        
        App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
        
        $this->autoRender = false;
        
        if ($password == null){
            echo 'Enter password as argument in url.';
        } else {
            $passwordHasher = new BlowfishPasswordHasher();
            
            echo 'Hashed pass= '.$passwordHasher->hash($password);
        }
        
    }
}