<?php

namespace App\Http\Controllers;

use App\City;
use App\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    // Kolom yang digunakan untuk order
    private $column_order_city = array('code', 'description', 'province', null); 
    // Kolom yang digunakan untuk pencarian
    private $column_search_city = array('code', 'description', 'province'); 
    // Kolom yang digunakan untuk default order
    private $order_city = array('provinceId' => 'asc');

    public function __construct()
    {
        // Tidak bisa masuk kalau belum login
        $this->middleware('auth');
    }

    public function index()
    {
        // Tab yang aktif
        $tab_active = 'city';
        return view('city.index', compact('tab_active'));
    }

    // AJAX Request

    /**
     * Get all province list
     */
    public function api_get_province_list()
    {
        return Province::get();
    }

    /**
     * Create Case
     */
    public function create_case()
    {
        $case = '(CASE';
        $province = $this->api_get_province_list();

        foreach($province as $row) {
            $case .= ' WHEN provinceId = ' . "'" . $row->code . "'" . ' THEN ' . "'" . $row->description . "'";
        }

        $case .= ' END) as province';
        
        return $case;
    }

    /**
     * Read
     */
    public function api_city_list(Request $request)
    {
        $request = $request->all();
        
        $list = $this->get_city_query($request);
        $data = array();
        $no = $request['start'];
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $val->province; 
            $row[] = $val->code; 
            $row[] = $val->description; 
            $row[] = '<button class="btn btn-sm btn-primary" alt="Edit" onclick="edit_default('."'".$val->code."'".')"><i class="far fa-edit" aria-hidden="true"></i>Edit</button> 
            <button class="btn btn-sm btn-danger" alt="Hapus" onclick="show_delete('."'".$val->code."','".$val->description."'".')"><i class="fas fa-trash" aria-hidden="true"></i> Delete</button>';
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $request['draw'],
            "recordsTotal" =>$this->count_city_all(),
            "recordsFiltered" => $this->count_city_filtered($request),
            "data" => $data,
            'list' => $list
        );
        //output to json format
        echo json_encode($output);
    }

    public function _get_city_query($request)
    {
        $i = 0;

        // Generate case
        $case = $this->create_case();

        // Select
        $city = City::selectRaw('*, ' . $case);

        // Subquery
        $city = DB::table(DB::raw("({$city->toSql()}) as city"))->mergeBindings($city->getQuery());

        // Query untuk search
        if($request['search']['value']) {
            foreach($this->column_search_city as $item) {
                if($i == 0) {
                    $rawhere = '( LOWER ( CAST ( ' . $item . ' AS CHAR ) ) LIKE ' . "%" . strtolower($request['search']['value']) . "%";
                } else {
                    $rawhere .= ' OR LOWER ( CAST ( ' . $item . ' AS CHAR ) ) LIKE ' . "%" . strtolower($request['search']['value']) . "%";
                }

                $i = 1;
            }
            $rawhere .= ')';
        }

        // Where untuk search
        if(isset($rawhere)) {
            $city->whereRaw($rawhere);
        }

        // Query Order
        if(isset($request['order']))
        {
            $city->orderBy($this->column_order_city[$request['order']['0']['column']], $request['order']['0']['dir']);
        } 
        else if(isset($this->order_city))
        {
            $order = $this->order_city;
            $city->orderBy(key($order), $order[key($order)]);
        }

        return $city;
    }

    public function get_city_query($request)
    {
        $city = $this->_get_city_query($request);
        if($request['length'] != -1)
        $city->skip($request['start'])->take($request['length']);
        return $city->get();
    }

    public function count_city_filtered($request){
        $city = $this->_get_city_query($request);
        return $city->count();
    }

    public function count_city_all()
    {
        return City::count();
    }

    /**
     * Create
     */
    public function api_save_city(Request $request){
        $code = $request->input('code');
        $description = $request->input('description');
        $provinceId = $request->input('provinceId');

        if (City::create([
            'code' => $code,
            'description' => $description,
            'provinceId' => $provinceId,
        ])) {
            $return = array(
				'status' => 'true',
				'message' => 'Berhasil Menyimpan',
				'alert' => 'success'
			);
        } else {
            $return = array(
				'status' => 'false',
				'message' => 'Gagal Menyimpan',
				'alert' => 'error'
            );
        }
		echo json_encode($return);
    }

    /**
     * Update
     */
    public function api_get_city(Request $request)
    {
        $code = $request->code;
        $result = City::find($code);

		if ($result) {
			$return = array(
					'status' => 'true',
					'datas' => $result
				);
		}else{
			$return = array(
					'status' => 'false',
					'messsage' => 'Data Tidak ditemukan'
				);
		}
		echo json_encode($return);
    }

    public function api_update_city(Request $request){
        $code = $request->input('code');
        $description = $request->input('description');
        $provinceId = $request->input('provinceId');
        
        if (City::where('code', $code)->update([
            'code'=> $code,
            'description' => $description,
            'provinceId'  => $provinceId,
        ])) {
            $return = array(
                'status' => 'true',
                'message' => 'Berhasil Update'
            );
        } else {
            $return = array(
                'status' => 'false',
                'message' => 'Gagal Update'
            );
        }
		echo json_encode($return);
    }
    
    /**
     * Delete
     */
    public function api_delete_city(Request $request){
        $code = $request->idhapus;
        
        if (City::findOrFail($code)->delete()) {
            $return = array(
                'status' => 'true',
                'message' => 'Berhasil Hapus'
            );
        } else {
            $return = array(
                'status' => 'false',
                'message' => 'Gagal Hapus'
            );
        }
		echo json_encode($return);
	}
}
