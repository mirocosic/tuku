<?php class OrdersController extends AppController{
    
    var $uses = 'Order';
    
    function take_order(){
        
        if (!empty($this->request->data)){
            
            $this->request->data['Order']['user_id'] = $this->Auth->user('id');
            
            $this->Order->save($this->request->data);
        }
        
    }
    
    function edit($id = null){
        if ($id == null){
            $this->redirect('/orders/view');
        }
        
        $order = $this->Order->find('first', ['conditions'=>['Order.id'=>$id]]);
        
        if (!$this->request->data) {
            $this->request->data = $order;
        }
    }
    
    function view(){
        
        if ($this->Auth->user('role') === 'admin'){
            $conditions = array();
        } else {
            $conditions = array('user_id'=>$this->Auth->user('id'));
        }
        
        $orders = $this->Order->find('all', [
            'conditions'=>$conditions
        ]);
        
        $this->set('orders',$orders);
        
    }
    
    function cancel_order(){
        $this->layout = false;
        $this->autoRender = false;
        
        if (!empty($this->request->data['id'])){
            $this->Order->id = $this->request->data['id'];
            if ($this->Order->saveField('status_id',9999)){
                $response['success'] = true;
                $response['message'] = 'Narudžba je uspješno otkazana.';
            } else {
                $response['success'] = false;
                $response['message'] = 'Došlo je do greške prilikom otkazivanja! Kontaktirajte administratora!';
                // add error reporting + admin alerting -> email, view, ....
            }
            
            
        } else {
            $response['success'] = false;
            $response['message'] = 'Narudžba je uspješno otkazana.';
        }
        
        return json_encode($response, true);
    }
}