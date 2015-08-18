<?php class TestController extends AppController {
 
    var $uses = array('NjuskaloItem');
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
    
    
    
    function curl_njuskalo(){
        $this->layout = false;
        $this->autoRender = false;
        
        App::import('Vendor', 'phpQuery');
        
        //$Url = 'http://www.njuskalo.hr';
        
        $totalPrice = 0;
        $totalItems = 0;
        
        $existingUrls = $this->NjuskaloItem->find('list',array(
            'fields'=>['NjuskaloItem.url']
        ));
        
       
        
        for ($i=1;$i<=55;$i++){
            
            //$url = "http://www.njuskalo.hr/auti/renault-megane?page=".$i;  
            
            $url = "http://www.njuskalo.hr/auti/vw-passat?page=".$i;  
            
            $doc = phpQuery::newDocument($this->fetch_url($url));
            
            foreach (pq('.entity-title a') as $a) {
                
                $itemUrl = 'http://www.njuskalo.hr' . pq($a)->attr('href');
                
                if (in_array($itemUrl, $existingUrls)){
                    continue;
                }
               
                //if (strpos($itemUrl,'/renault-megane-')){
                if (strpos($itemUrl,'/vw-passat-')){
                  
                    
                    $item = phpQuery::newDocument($this->fetch_url($itemUrl));
                    $price_tmp = pq('.price--hrk')->html();
                    $price = str_replace('kn','',trim(strip_tags($price_tmp)));
                    $price = str_replace('.','', $price);
                    $totalPrice += $price;
                    $totalItems++;
                    
                    
                    $year = pq("th:contains('Godina proizvodnje')")->next()->children()->attr('datetime');
                    
                    $manufacturer = pq("th:contains('Marka automobila')")->next()->html();
                    $model = pq("th:contains('Model automobila')")->next()->html();
                    
                    $saveData = array(
                        'url'=>$itemUrl,
                        'price'=>$price,
                        'year'=>  trim($year),
                        'manufacturer'=>  trim($manufacturer),
                        'model'=>  trim($model),
                        );
                    $this->NjuskaloItem->clear();
                    $this->NjuskaloItem->save($saveData);
                    
                    }
            }
            
           
            
        }
        
    }
    
    function njuskalo(){
        
        $data = $this->NjuskaloItem->find('all',[
            'conditions'=>['NjuskaloItem.manufacturer'=>'VW'],
            'fields'=>['NjuskaloItem.price','NjuskaloItem.year','NjuskaloItem.manufacturer','NjuskaloItem.model'],
            
        ]);
        
        $data2 =  $this->NjuskaloItem->find('all',[
            'conditions'=>['NjuskaloItem.manufacturer'=>'Renault'],
            'fields'=>['NjuskaloItem.price','NjuskaloItem.year','NjuskaloItem.manufacturer','NjuskaloItem.model'],
            
        ]);
        
        $endData1 = $this->prepareData($data);
        $endData2 = $this->prepareData($data2); 
       
        
       // ksort($end_data);
        $this->set('data',$endData1);
        $this->set('data2',$endData2);
        
        $this->set('manufacturer',$data[0]['NjuskaloItem']['manufacturer']);
        $this->set('model',$data[0]['NjuskaloItem']['model']);
    }
    
    private function prepareData($data){
         $newDataArray = array();
        $end_data = array();
        foreach($data as $item) {
            if (empty($newDataArray[$item['NjuskaloItem']['year']])){
              $newDataArray[$item['NjuskaloItem']['year']]  = array();
            } 
            $nekaj = array_push($newDataArray[$item['NjuskaloItem']['year']],$item['NjuskaloItem']['price']);
        }
        
        krsort($newDataArray);
        
        foreach ($newDataArray as $year=>$value){
         
                $totalPricePerYear = 0;
                   
            foreach ($value as $price) {
                $totalPricePerYear += $price; 
            }
            
            $avgPricePerYear = $totalPricePerYear / count($value);
          //  echo 'Year: '.$year.'<br/>';
          //  echo 'Avg price: '.$avgPricePerYear.'<br/>';
          //  echo '<br/>';
            $tmpArray['label'] = $year;
            $tmpArray['y'] = $avgPricePerYear;
            $tmpArray['count'] = count($value);
            
            
            array_push($end_data, $tmpArray);
            
           // $end_data[$year] = $avgPricePerYear;
            
            return $end_data;
            
        }
    }
    
    private function fetch_url($url){
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_output = curl_exec($ch);
        curl_close($ch);
        
        return $curl_output;
        
    } 
}