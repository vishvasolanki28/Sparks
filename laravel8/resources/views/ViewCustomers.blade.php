@extends('Layout')
@section('title','Customers')
@section('header')
    @parent
@endsection
@section('content')
    <script type="text/javascript">
        $(document).ready(function(){
            ViewCustomers();
        });
        function ViewCustomers()
        {
            $.ajax({
                url: 'ShowCustomers/',
                type: 'get',
                dataType: 'json',
                success: function(response){
                    var len=0;
                    $('#CustomersTable thead').empty();
                    $('#CustomersTable tbody').empty();
                    if(response['data']!=null)
                    {
                        len=response['data'].length;
                        if(len>0)
                        {
                            $('#CustomersTable thead').append("<tr><th>Customer</th><th>Email ID</th><th>Current Balance</th><th></th></tr>");
                            $.each(response.data,function(i,v){
                                $('#CustomersTable tbody').append("<tr><td>"+v.CusName+"</td><td>"+v.Email+"</td><td>"+v.CurrentBalance+"</td><td><a href=\"TransferMoney?CusId="+v.CusId+"&CusName="+v.CusName+"&CurrentBal="+v.CurrentBalance+"\" class=\"btn btn-info txt1\">Transfer Money</a></td></tr>");
                            })
                        }
                        else
                        {
                            $('#CustomersTable tbody').append("<tr><th>No Customer Data Available...</th></tr>");
                        }
                    }
                },
                error: function(xhr)
                {
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
    <table class="table" id="CustomersTable" name="CustomersTable">
        <thead></thead>
        <tbody></tbody>
    </table>
@endsection
@section('footer')
    @parent
@endsection