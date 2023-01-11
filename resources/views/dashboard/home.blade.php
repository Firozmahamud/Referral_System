
@extends('layouts.dashboardLayout')

@section('content')



<h1 class="mt-4">Dashboard</h1>
<ol class="breadcrumb mb-4">
    <h6 style="cursor: pointer" data-code="{{ Auth::user()->referral_code }}" class="copy">
        <span class="fa fa-copy mr-1"></span>
        Copy Referral Link
    </h6>
    {{-- <li class="breadcrumb-item active">Dashboard</li> --}}
</ol>
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Total Points</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                {{-- <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div> --}}
                <a>{{ $networkCount*10 }} Points</a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">Warning Card</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">Success Card</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">Danger Card</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="row">
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-area me-1"></i>
                Area Chart Example
            </div>
            <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-bar me-1"></i>
                Bar Chart Example
            </div>
            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
        </div>
    </div>
</div> --}}


                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Verified</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Verified</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            {{-- <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>2011/04/25</td>
                                            <td>$320,800</td> --}}

                                            @if (count($networkData) > 0)
                                                {{-- @foreach ($networkData as $key=>$network)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>

                                                </tr>


                                                @endforeach --}}
                                                @php
                                                    $x=1;
                                                @endphp

                                                @foreach ($networkData as $network)
                                                <tr>
                                                    <td>{{$x++}}</td>
                                                    <td>{{ $network->user->name }}</td>
                                                    <td>{{  $network->user->email }}</td>
                                                    <td>
                                                        @if ( $network->user->is_verified == 0)
                                                        <b style="color: red"> not verified</b>
                                                        @else
                                                        <b style="color:green"> verified</b>

                                                        @endif
                                                    </td>

                                                </tr>


                                                @endforeach

                                            @else
                                            <tr>
                                                <th colspan="4" style="text-align: center">No Referral Found!

                                                </th>
                                            </tr>

                                            @endif
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>


<script>
    $(document).ready(function(){
        $('.copy').click(function(){
            $(this).parent().prepend('<span style="color:blue;" class="copied_text">Coppied</span>');


            var code = $(this).attr('data-code');
            var url = "{{ URL::to('/') }}/referral-register?ref="+code;

            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(url).select();
            document.execCommand("copy");
            $temp.remove();

            setTimeout(() => {
                $('.copied_text').remove();

            }, 800);
        });

    });
</script>


@endsection
