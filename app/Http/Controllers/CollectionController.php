<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectionController extends Controller
{
    public function getQuantityCollectionToDevidePage(Request $request){ 
        $fashionType = $request->fashionType; 
        $mapl_sp2 = $request->mapl_sp2;
        $query_data = $request->query_data;
        $quantity = 0;
        if($query_data == null){
            $quantity = DB::select(
                "SELECT COUNT(MASP) AS SL_MASP, MAPL_SP
                FROM sanphams
                WHERE MAPL_SP = $fashionType
                AND MAPL_SP2 = $mapl_sp2
                GROUP BY MAPL_SP"
            ); 
        }
        else{
            $quantity = DB::select(
                "SELECT COUNT(MASP) AS SL_MASP
                FROM sanphams
                WHERE TENSP LIKE '%$query_data%'"
            );
        }

        return response()->json([
            'quantity'=> $quantity, 
        ]); 
    }
    public function getProductCollection(Request $request){ 
        $start = $request->input('start');
        $numberProductEachPage = $request->input('numberProductEachPage');
        $fashionType = $request->input('fashionType');
        $category = $request->input('category');
        $sortBy = $request->input('sortBy');
        $query_data = $request->query_data;
        $quantity = 0;
  
        $productList = [];    
        $data_queryOrMAPL = "";
        if($query_data == null){
            $data_queryOrMAPL =  "AND MAPL_SP = $fashionType
                                AND MAPL_SP2 = $category"; 
        }
        else{
            $data_queryOrMAPL =  "AND TENSP LIKE '%$query_data%'"; 
        }
        $data_query =  
            "SELECT * FROM sanphams, hinhanhsanphams 
            WHERE hinhanhsanphams.masp = sanphams.masp 
            AND MAHINHANH LIKE '%thumnail%'  
            $data_queryOrMAPL";
        
        $data_query2 = "LIMIT $start, $numberProductEachPage";

        if($sortBy == 'moinhat'){
            // $productList = DB::select("SELECT * from sanphams where TENSP LIKE '%$tensp%' ORDER BY created_at DESC");
            $productList = DB::select("$data_query ORDER BY created_at DESC $data_query2"); 
        }
        else if($sortBy == 'banchay'){ 
            $productList_GetQuantity = DB::select( 
                "SELECT sanphams.MASP, TENSP, GIAGOC, GIABAN, imgURL
                from chitiet_donhangs, sanphams, hinhanhsanphams, sanpham_mausac_sizes
                where chitiet_donhangs.MAXDSP = sanpham_mausac_sizes.MAXDSP 
                AND hinhanhsanphams.masp = sanphams.masp
                AND sanpham_mausac_sizes.masp = sanphams.masp
                AND MAHINHANH LIKE '%thumnail%'  
                $data_queryOrMAPL
                group by sanphams.MASP, TENSP, GIAGOC, GIABAN, imgURL
                order by SUM(chitiet_donhangs.SOLUONG) DESC"
            ); 
            $productList = DB::select( 
                "SELECT sanphams.MASP, TENSP, GIAGOC, GIABAN, imgURL
                from chitiet_donhangs, sanphams, hinhanhsanphams, sanpham_mausac_sizes
                where chitiet_donhangs.MAXDSP = sanpham_mausac_sizes.MAXDSP 
                AND hinhanhsanphams.masp = sanphams.masp
                AND sanpham_mausac_sizes.masp = sanphams.masp
                AND MAHINHANH LIKE '%thumnail%'  
                $data_queryOrMAPL
                group by sanphams.MASP, TENSP, GIAGOC, GIABAN, imgURL
                order by SUM(chitiet_donhangs.SOLUONG) DESC
                $data_query2"
            ); 
            $quantity = [
                [
                    'SL_MASP' => count($productList_GetQuantity),
                    'MAPL_SP' => $fashionType
                ]
            ];
        }
        else if($sortBy == 'thapDenCao'){
            $productList = DB::select("$data_query ORDER BY GIABAN ASC $data_query2");
        }
        else if($sortBy == 'caoDenThap'){
            $productList = DB::select("$data_query ORDER BY GIABAN DESC $data_query2");
        } 

        
        if($query_data == null && $quantity == 0){
            $quantity = DB::select(
                "SELECT COUNT(MASP) AS SL_MASP, MAPL_SP
                FROM sanphams
                WHERE MAPL_SP = $fashionType
                AND MAPL_SP2 = $category
                GROUP BY MAPL_SP"
            ); 
        }
        else if($quantity == 0){
            $quantity = DB::select(
                "SELECT COUNT(MASP) AS SL_MASP
                FROM sanphams
                WHERE TENSP LIKE '%$query_data%'"
            );
        }

        return response()->json([
            'productList' => $productList, 
            'quantity' => $quantity,
        ]);
    }
}
