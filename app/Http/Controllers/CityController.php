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
        // Return view yang digunakan
        // Compact fungsinya untuk membuat ['tab_active' => $tab_active]
        return view('city.index', compact('tab_active'));
    }

    /**
     * AJAX request yang digunakan di view
     */

    /**
     * Get all province list
     */
    public function api_get_province_list()
    {
        // Eloquent model get untuk get semua data dati model Province yagn terhubung dengan tabel province
        return Province::get();
    }

    /**
     * Membuat case untuk handle id yang berhubungan dengan tabel lain
     * Sebenernya kalau pake laravel bisa pake Eloquent relationship, cuma karena querynya rada ribet jadi harus pake ini
     */
    public function create_case()
    {
        $case = '(CASE';
        // Mengambil semua data province
        $province = $this->api_get_province_list();

        // Membuat case untuk setiap province yang ada
        foreach($province as $row) {
            $case .= ' WHEN provinceId = ' . "'" . $row->code . "'" . ' THEN ' . "'" . $row->description . "'";
        }

        // Memberi alias untuk case nya, jangan menggunakan nama yang sama dengan nama kolom yang ada di tabel aslinya (provinceId)
        $case .= ' END) as province';

        // Return case yang sudah dibuat
        return $case;
    }

    /**
     * Read
     */
    public function api_city_list(Request $request)
    {
        // Mengambil semua data yang dikirimkan dari view pada request AJAX
        $request = $request->all();

        // Mendapatkan data dari city yang sudah dikenai oleh semua query
        $list = $this->get_city_query($request);
        $data = array();
        $no = $request['start'];
        // Membuat list data yang akan ditampilkan di datatable
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

        // Jenis output yang diharapkan oleh datatable untuk memproses data menjadi tabel
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

    /**
     * Query yang digunakan untuk mendapatkan data yang dikenai berbagai filter
     */
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
            // Looping untuk mengecek semua kolom yang ada, apakah yang dicari ada di kolom tersebut
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

    /**
     * Query buat pagination
     */
    public function get_city_query($request)
    {
        $city = $this->_get_city_query($request);
        if($request['length'] != -1)
        $city->skip($request['start'])->take($request['length']);
        return $city->get();
    }

    /**
     * Dapeting jumlah data yang terfilter
     */
    public function count_city_filtered($request){
        $city = $this->_get_city_query($request);
        return $city->count();
    }

    /**
     * Dapeting jumlah data total
     */
    public function count_city_all()
    {
        return City::count();
    }

    /**
     * Create city
     */
    public function api_save_city(Request $request){
        // Dapetin data dari data ajax, pake input karena yang dikirimin bentuknya form
        $code = $request->input('code');
        $description = $request->input('description');
        $provinceId = $request->input('provinceId');

        // Eloquent buat create
        if (City::create(compact('code', 'description', 'provinceId'))) {
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
     * Mengambil data yang ingin diubah
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

    /**
     * Mengubah data
     */
    public function api_update_city(Request $request){
        $code = $request->input('code');
        $description = $request->input('description');
        $provinceId = $request->input('provinceId');
        
        if (City::where('code', $code)->update(compact('code', 'description', 'provinceId'))) {
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
     * Menghapus data
     */
    public function api_delete_city(Request $request){
        $code = $request->idhapus;
        
        // Findorfail untuk mendapatkan data yang dicari, namun apabila tidak ada akan return exception
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
