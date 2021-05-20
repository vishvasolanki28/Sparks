<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MyController extends Controller
{
    public function index()
    {
        return view("HomePage");
    }
    public static function ShowCustomers()
    {
        $Customers['data']=DB::table('Customers')->orderBy('CusId','desc')->get();
        echo json_encode($Customers);
    }
    public function index1()
    {
        return view("TransferMoney");
    }
    public static function GetCustomers()
    {
        $arr=DB::table('Customers')->select('CusId','CusName')->orderBy('CusName')->get();
        return $arr;
    }
    public static function GetCurrentBalByCusId($CusId)
    {
        $CurBal['data']=DB::table('Customers')->select('CurrentBalance')->where('CusId',$CusId)->get();
        echo json_encode($CurBal);
    }
    public static function SaveTransaction(Request $req)
    {
        if($req->input("sbmtTransfer")!=null)
        {
            $TransType=$req->input('hdnTransType');
            $SenderId=0;
            if($TransType==0)
                $SenderId=$req->input('selSender');
            else if($TransType==1)
                $SenderId=$req->input('hdnSenderId');
            $ReceiverId=$req->input('selReceiver');
            $TransAmount=$req->input('txtTransAmt');
            $SenderCurrentBal=$req->input('txtAvailBal');
            $ReceiverCurrentBal=DB::table("Customers")->select("CurrentBalance")->where("CusId",$ReceiverId)->get();
            foreach($ReceiverCurrentBal as $k=>$v)
            {
                $y=$v->CurrentBalance;
            }
            $UpdateBalToSender=$SenderCurrentBal-$TransAmount;
            $UpdateBalToReceiver=$y+$TransAmount;
            $arrSender=array("CurrentBalance"=>$UpdateBalToSender);
            $arrReceiver=array("CurrentBalance"=>$UpdateBalToReceiver);
            $TransDateTime=Carbon::now();
            $TransDateTime->timezone='Asia/Calcutta';
            $TransDateTime->toDateTimeString();
            $arrTrans=array("SenderId"=>$SenderId, "ReceiverId"=>$ReceiverId, "TransDate"=>$TransDateTime, "TransAmount"=>$TransAmount);
            DB::beginTransaction();
            $affectedRows=DB::table("Customers")->where("CusId",$SenderId)->update($arrSender);
            if($affectedRows>0)
            {
                $affectedRows=DB::table("Customers")->where("CusId",$ReceiverId)->update($arrReceiver);
                if($affectedRows>0)
                {
                    $affectedRows=DB::table("TransactionDetails")->insertGetId($arrTrans);
                    if($affectedRows>0)
                    {
                        DB::commit();
                        return view("ViewCustomers");
                    }
                    else
                        DB::rollBack();
                }
                else
                    DB::rollBack();
            }
            else
                DB::rollBack();
        }
    }
    public static function GetTransactionHistoryData()
    {
        $arr['data']=DB::table('Transactiondetails')
                    ->join('Customers as a','a.CusId','=','Transactiondetails.SenderId')
                    ->join('Customers as b','b.CusId','=','Transactiondetails.ReceiverId')
                    ->select('TransId','a.CusName as Sender','b.CusName as Receiver','TransDate','TransAmount')
                    ->orderBy('TransId','desc')
                    ->get();
        echo json_encode($arr);
    }
}
