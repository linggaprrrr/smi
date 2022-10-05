<?php 
    namespace App\Controllers;

    use App\Models\ProductModel;
    use App\Models\DesignModel;
    use App\Models\LogModel;
    use App\Models\MaterialModel;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    
    class Sellings extends BaseController
    {                         
        protected $productModel = "";
        protected $designModel = "";
        protected $logModel = "";
        protected $materialModel = "";

        public function __construct() { 
            $userId = session()->get('user_id');
            if (is_null($userId)) {            
                header('Location: '.base_url('/'));
                exit(); 
            }
            $this->productModel = new ProductModel();
            $this->designModel = new DesignModel();
            $this->logModel = new LogModel();
            $this->materialModel = new MaterialModel();
    
        }

        public function index() {            
            $data = array(
                'title' => 'Produk',          
            );
            return view('gudang_lovish/penjualan', $data);      
        }
    }

?>