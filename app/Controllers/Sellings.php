<?php 
    namespace App\Controllers;

    use App\Models\ProductModel;
    use App\Models\DesignModel;
    use App\Models\LogModel;
    use App\Models\MaterialModel;
    use App\Models\SellingModel;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    
    class Sellings extends BaseController
    {                         
        protected $productModel = "";
        protected $designModel = "";
        protected $logModel = "";
        protected $materialModel = "";
        protected $sellingModel = "";

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
            $this->sellingModel = new SellingModel();
        }

        public function index() {     
            $penjualan = $this->productModel->penjualan();       
            $data = array(
                'title' => 'Penjualan',     
                'sellings' => $penjualan,     
            );
            return view('gudang_lovish/penjualan', $data);      
        }

        public function importSelling() {
            $file = $this->request->getFile('file');        
            $ext = $file->getClientExtension();
            if ($ext == 'xls') {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $render->load($file);
            $data = $spreadsheet->getActiveSheet()->toArray();     
            
            foreach ($data as $idx => $row) {
                if ($idx > 0 && !is_null($row[0])) {
                    $temp = explode(' ', $row[1]);  
                    $modelID = "";
                    $productTypeID = "";
                    $colorID = "";
                    $size = NULL;
                    $hpp = 0;
    
                    $getProductType = $this->productModel->getProductType($temp[0]);
                    if (is_null($getProductType)) {
                        $productTypeID = $this->productModel->saveProductType($temp[0]);                    
                    }  else {
                        $productTypeID = $getProductType->id;
                    }                       
    
                    $getModel = $this->designModel->where(['model_name' => $temp[1]])->first();                                
                    if (is_null($getModel)) {
                        $model = [
                            'model_name' => $temp[1],                        
                        ];
                        $this->designModel->save($model); 
                        $modelID = $this->designModel->getInsertID();
                    } else {
                        $modelID = $getModel['id'];
                        $hpp = $getModel['hpp'];
                    }
                    
                    if (count($temp) == 3) {
                        if (strpos($row[1], 'REG') !== false) {
                            $size = "REG";
                            $color = trim($temp[2], $size);
                        } else if (strpos($row[1], 'JUMBO') !== false || strpos($row[1], 'JUM') !== false) {
                            $size = "JUMBO";
                            $color = trim($temp[2], $size);
                        } else {
                            $color = trim($temp[2]);
                        }
                        
                    } else if (count($temp) > 3) {
                        if (strpos($row[1], 'REG') !== false) {
                            $size = "REG";
                            $color = trim($temp[2]. ' '. $temp[3], $size);
                        } else if (strpos($row[1], 'JUMBO') !== false || strpos($row[1], 'JUM') !== false) {
                            $size = "JUMBO";
                            $color = trim($temp[2]. ' '. $temp[3], $size);
                        } else {
                            $color = trim($temp[2]. ' '. $temp[3]);
                        }                        
                    }
    
                    $getColor = $this->materialModel->getColorByName($color);
                    if (is_null($getColor)) {
                        $colorID = $this->materialModel->saveWarna($color);
                    } else {
                        $colorID = $getColor->id;
                    }
    
    
                    
    
    
                    $this->sellingModel->save([
                        'product_id' => $productTypeID,
                        'model_id' => $modelID,
                        'color_id' => $colorID,                        
                        'qty' => $row[2],
                        'brand' => $row[3],
                        'size' => $size,
                        'status' => 3
                    ]);         
                                     
                }
            }
            return redirect()->back()->with('create', 'Produk berhasil ditambahkan');
        }

        public function updateHPPJual() {            
            $product = $this->request->getVar('product_id');
            $model = $this->request->getVar('model_id');
            $hpp = $this->request->getVar('hpp');
            $size = $this->request->getVar('size');
            $this->productModel->updateHPPJual($product, $model, $size, $hpp);
        }

    }

    

?>