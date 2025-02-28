<?php

namespace App\Http\Controllers; 
 use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\taikhoan;
use App\Models\User;
use App\Models\sanpham;
use App\Models\chitiet_giohang;
use App\Models\donhang;
use App\Models\hinhanhsanpham;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use stdClass; 

class InfoProductController extends Controller
{
    public function productDetail(Request $request){
        $id = $request->query('id');
        $data_sanpham = sanpham::where('MASP', 'LIKE', "%$id%")->first();
        $data_tungloaisanpham = DB::select("SELECT * FROM sanpham_mausac_sizes WHERE MASP = '$id' ");
        $data_MAMAU = DB::select("SELECT DISTINCT(mausacs.MAMAU), HEX, TENMAU FROM sanpham_mausac_sizes, mausacs WHERE sanpham_mausac_sizes.MAMAU = mausacs.MAMAU AND MASP = '$id' ");
        $data_SIZE = DB::select("SELECT DISTINCT(MASIZE) FROM sanpham_mausac_sizes WHERE MASP = '$id ORDER BY MASIZE DESC'");
        $data_xacDinhSoLuong = DB::select("SELECT MASIZE, MAMAU, SOLUONG FROM sanpham_mausac_sizes WHERE MASP = $id");
        $dataProductDetail_sanpham_mausac_sizes__hinhanhs = DB::select(
            "SELECT imgURL, MAHINHANH 
            from hinhanhsanphams 
            WHERE MASP = $id  
            ORDER BY MAHINHANH DESC"
        );
        return response()->json([
            'data_sanpham' => $data_sanpham,
            'data_tungloaisanpham' => $data_tungloaisanpham,
            'data_mamau' => $data_MAMAU,
            'data_size' => $data_SIZE,
            'data_xacDinhSoLuong' => $data_xacDinhSoLuong,
            'data_hinhanh' => $dataProductDetail_sanpham_mausac_sizes__hinhanhs,
        ]);
    }
    public function addToCart(Request $request){ 
        chitiet_giohang::create([
            'MATK' => $request->matk,
            'MASP' => $request->masp,
            'MASIZE' => $request->masize,
            'MAMAU' => $request->mamau,
            'SOLUONG' => $request->soluong,
            'TONGGIA' => $request->tonggia, 
        ]);
        return response()->json([
            'status_code' => 200,
        ]);
    } 
    public function updateQuantityProperty(Request $request){
        $matk = $request->input('matk');
        $mamau = $request->input('mamau');
        $masize = $request->input('masize');
        $masp = $request->input('masp');
        $soluong = $request->input('soluong');
        $tonggia = $request->input('tonggia');

        DB::update("UPDATE chitiet_giohangs SET SOLUONG = '$soluong', TONGGIA = '$tonggia' WHERE MASP = '$masp' AND MATK = '$matk' AND MAMAU = '$mamau' AND MASIZE = '$masize' ");
        return response()->json([
            'message' => 200,
            'matk' => $matk,
        ]);
    }
    public function updateQuantityProductInCart(Request $request){
        $soluong = $request->input('soluongsp');
        $matk = $request->input('matk');
        $masp = $request->input('masp');
        $masize = $request->input('masize');
        $mamau = $request->input('mamau');

        DB::update("UPDATE chitiet_giohangs SET SOLUONG = SOLUONG + $soluong WHERE MATK = '$matk' 
        AND MASP = '$masp' AND MASIZE = '$masize' AND MAMAU = '$mamau'");
  Log::info('Updated quantity successfully');
        return response()->json([
            'status' => 200, 
            'message' => 'Cập nhật không thành công',
        ]);
    }
    public function getProductReviews(Request $request){
        $masp = strval($request->input('masp'));
        $productReviews = DB::select(
            "SELECT MADANHGIA, NOIDUNG_DANHGIA, SOLUONG_SAO, TEN 
            FROM danhgia_sanphams, taikhoans
            WHERE MASP = ?
            AND danhgia_sanphams.MATK = taikhoans.MATK", [$masp]
        );
        return response()->json([
            'productReviews' =>  $productReviews
        ]);
    }
    public function getRelativeProduct(Request $request){
        $masp = $request->input('masp');

        $dataProduct_masp = DB::select(
            "SELECT MAPL_SP, MAPL_SP2 FROM sanphams WHERE MASP = $masp"
        );

        $MAPL = $dataProduct_masp[0]->MAPL_SP;
        $MADM = $dataProduct_masp[0]->MAPL_SP2;

        $data_relativeProduct = DB::select(
            "SELECT sanphams.MASP, TENSP, GIAGOC, GIABAN, MAPL_SP, imgURL
            FROM sanphams, hinhanhsanphams
            WHERE hinhanhsanphams.masp = sanphams.masp 
            AND MAPL_SP = $MAPL
            AND MAPL_SP2 = $MADM
            AND MAHINHANH LIKE '%thumnail%'  
            ORDER BY created_at ASC 
            LIMIT 10"
        );
        return response()->json([
            'data_relativeProduct' =>  $data_relativeProduct
        ]);
    }
}
