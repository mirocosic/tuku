<?php class Order extends AppModel {
    
    
    var $belongsTo = array(
        'User'=>array(
            'foreignKey' => 'user_id',
        ),
        'OrderStatus'=>array(
            'foreignKey'=>'status_id'
        )
    );
    
    var $hasMany = array(
         'OrderStatusLog' => array(
            'className' => 'OrderStatusLog',
            'foreignKey' => 'order_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    
    
    var $validate = array(
        'address'   => array('rule'=>'notBlank','required'=>true),
        'name'      => array('rule'=>'notBlank'),
        'floor'     => array('rule'=>'notBlank'),
        'phone'     => array('rule'=>'notBlank'),
    );
    
    
    
    
     function afterSave($created, $options = array()) {
        
        if(empty($this->data['Order']['status_id'])){
            $this->data['Order']['status_id'] = 0;
        }
        
        $user = CakeSession::read('Auth.User');
        if(empty($user)){
            $user['id'] = 0;
        }
        
        $statusLogData['OrderStatusLog']['order_id'] = $this->id;
        $statusLogData['OrderStatusLog']['new_status'] = $this->data['Order']['status_id'];
        $statusLogData['OrderStatusLog']['user_id'] = $user['id'];            
        
        $this->OrderStatusLog->clear();
        $this->OrderStatusLog->save($statusLogData);
    }
    
}