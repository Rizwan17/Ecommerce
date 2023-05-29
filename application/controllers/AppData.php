<?php
loadController('Api');
class AppData extends Api {
    public $cartModel = null;
    
    public function __construct(){
        parent::__construct();
        loadModel('Cart_Model');
        $this->cartModel = new Cart_Model();
    }

    public function fetchAppData(){
        $data = [];
        if(isset($_SESSION['uid'])){
            $uid = $_SESSION['uid'];
            $cartResult = $this->cartModel->getCartCounts($uid);

            if($cartResult['status'] === 200){
                $data['cart'] = $cartResult['data'];
            }

            $this->response(['status' => 200, 'data' => $data]);
            
        }
    }
}

?>