@extends('Layout')
@section('title','Transfer Money')
@section('header')
    @parent
@endsection
@section('content')
    <?php
        $count=0;
    ?>
    @php
        $Customers=App\Http\Controllers\MyController::GetCustomers();
        if(Request::has('CusId'))
        {
            $count=1;
            $CusId=Request::input('CusId');
            $CusName=Request::input('CusName');
            $CurrentBal=Request::input('CurrentBal');
        }
    @endphp
    <script type="text/javascript">
        $(document).ready(function(){
            $('#selSender').on('change', function(){
                if(this.value>0)
                {
                    GetCurrentBal(this.value);
                }
                else
                {
                    document.getElementById("txtAvailBal").value="";
                }
            });
            $('#sbmtTransfer').on('click', function(){
                alert("Transaction Completed Succefullyy!!");
            });
            $('#btnCheck').on('click', function(){
                var strMsg="";
                if(document.getElementById("hdnTransType").value==0)
                    if(document.getElementById("selSender").value<1)
                        strMsg+="Select Sender to Transfer Money!!<br/>";
                if(document.getElementById("selReceiver").value<1)
                    strMsg+="Select Receiver to Transfer Money!!<br/>";
                if(document.getElementById("txtTransAmt").value=="")
                    strMsg+="Transfer Amount Required!!<br/>";
                if(strMsg=="")
                {
                    document.getElementById("lblMsg").innerHTML="";
                    if(parseInt(document.getElementById("txtAvailBal").value,10)<parseInt(document.getElementById("txtTransAmt").value,10))
                    {
                        alert("Insufficient Amount to Transfer!!");
                        document.getElementById("txtTransAmt").value="";
                    }
                    else
                    {
                        var ConfirmTransaction="";
                        var sen=document.getElementById("selSender");
                        var rev=document.getElementById("selReceiver");
                        if(document.getElementById("hdnTransType").value==0)
                            ConfirmTransaction+="Sender: "+sen.options[sen.selectedIndex].text+"\n";
                        else if(document.getElementById("hdnTransType").value==1)
                            ConfirmTransaction+="Sender: "+document.getElementById("txtSender").value+"\n";
                        ConfirmTransaction+="Receiver: "+rev.options[rev.selectedIndex].text+"\n"+"Transfer Amount: "+document.getElementById("txtTransAmt").value;
                        if(confirm(ConfirmTransaction)) 
                            document.getElementById("sbmtTransfer").disabled=false;
                        else 
                            document.getElementById("sbmtTransfer").disabled=true;
                    } 
                }
                else
                    document.getElementById("lblMsg").innerHTML=strMsg;
            });
        });
        function GetCurrentBal(CusId)
        {
            $.ajax({
                url:'GetCurrentBalByCusId/' + CusId,
                type:'get',
                datatype:'json',
                success: function(response)
                {   
                    ShowCurrentBal(JSON.parse(response));
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }
        function ShowCurrentBal(myarray)
        {
            for (var i=0;i<myarray['data'].length;i++)
            {
                document.getElementById("txtAvailBal").value=myarray['data'][i].CurrentBalance;
            }
        }
    </script>
    <form action="/ShowTransaction" method="post">
        @csrf
        <div class="form-group row mt-1 ml-2 mr-2">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <small style="color: red">
                    <label id="lblMsg"></label>
                </small>
            </div>
        </div>
        @if($count==0)
        <div class="form-group row mt-1 ml-2 mr-2" id="senderSel" name="senderSel">
            <label for="selSender" class="col-sm-2 col-form-label">Money Transfer From:</label>
            <div class="col-sm-10">
                <select id="selSender" name="selSender" class="form-control">
                    <option value="0" selected>Select</option>
                    @foreach($Customers as $k=>$v)
                        <option value="{{$v->CusId}}">{{$v->CusName}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @else
        <div class="form-group row mt-1 ml-2 mr-2" id="senderTxt" name="senderTxt">
            <label for="txtSender" class="col-sm-2 col-form-label">Money Transfer From:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="txtSender" id="txtSender" value="{{$CusName}}" readonly>
            </div>
        </div>
        @endif
        <div class="form-group row mt-1 ml-2 mr-2">
            <label for="txtAvailBal" class="col-sm-2 col-form-label">Available Balance To Transfer:</label>
            <div class="col-sm-10">
            @if($count==0)
                <input type="text" class="form-control" name="txtAvailBal" id="txtAvailBal" readonly>
            @else
                <input type="text" class="form-control" name="txtAvailBal" id="txtAvailBal" value="{{$CurrentBal}}" readonly>
            @endif
            </div>
        </div>
        <div class="form-group row mt-1 ml-2 mr-2">
            <label for="selReceiver" class="col-sm-2 col-form-label">Money Transfer To:</label>
            <div class="col-sm-10">
                <select id="selReceiver" name="selReceiver" class="form-control">
                    <option value="0" selected>Select</option>
                    @foreach($Customers as $k=>$v)
                        <option value="{{$v->CusId}}">{{$v->CusName}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row mt-1 ml-2 mr-2">
            <label for="txtTransAmt" class="col-sm-2 col-form-label">Transfer Amount:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="txtTransAmt" id="txtTransAmt">
            </div>
        </div>
        <div class="form-group row mt-1 ml-2 mr-2">
        @if($count==0)
            <div class="col-sm-2"></div>
        @else
            <div class="col-sm-2">
                <input type="hidden" class="form-control" name="hdnSenderId" id="hdnSenderId" value="{{$CusId}}">
            </div>
        @endif
            <div class="col-sm-10">
                <input type="button" class="btn btn-info" name="btnCheck" id="btnCheck" value="Confirm Money Transfer Data">
                <input type="submit" class="btn btn-info" name="sbmtTransfer" id="sbmtTransfer" value="T R A N S F E R" disabled="true">
            </div>
        </div>
        <div class="form-group row mt-1 ml-2 mr-2">
            <div class="col-sm-2">
                <input type="hidden" class="form-control" name="hdnTransType" id="hdnTransType" value="{{$count}}">
            </div>
        </div>
    </form>    
@endsection
@section('footer')
    <div style="height: 25vh"></div>
    @parent
@endsection