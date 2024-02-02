@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
  
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-6">
              <div class="row">
                <div class="col-6">
                  <!-- small box -->
                  <div class="small-box bg-info">
                    <div class="inner">
                      <h3><a href="{{ url('/overview/ALL/ALL') }}" target="_blank" style="color:rgb(255, 255, 183)">{{ getTotalProposal() }}</a></h3>
      
                      <p>Project Proposal<br>R&D : <b><a href="{{ url('/overview/RD/ALL') }}" target="_blank" style="color:rgb(255, 255, 183)">{{ getTotalProposal('RD')}}</a></b><br>Non-R&D : <b><a href="{{ url('/overview/NONRD/ALL') }}" style="color:rgb(255, 255, 183)" target="_blank">{{ getTotalProposal('NONRD') }}</a></b></p>
                    </div>
                    <div class="icon">
                      <i class="fas fa-folder"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-6">
                  <!-- small box -->
                  <div class="small-box bg-warning">
                    <div class="inner">
                      <h3><a href="{{ url('/overview/RD/ALL') }}" target="_blank" style="color:rgb(18, 128, 192)">{{ number_format(getTotalProjCost(2024)) }}</a></h3>
                      <p>Total Propose Budget for 2024<br>R&D : <b><a href="{{ url('/overview/RD/ALL') }}" target="_blank" style="color:rgb(18, 128, 192)">{{ number_format(getTotalProposalBudget('RD')) }}</a></b><br>Non-R&D : <b><a href="{{ url('/overview/NONRD/ALL') }}" target="_blank" style="color:rgb(18, 128, 192)">{{ number_format(getTotalProposalBudget('NONRD')) }}</a></b></p>
                      </p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped table-valign-middle">
                    <thead>
                    <tr>
                      <th rowspan="2" style="border: 1px solid #DDD"><center>DIVISION</center></th>
                      <th colspan = "3" style="border: 1px solid #DDD"><center># OF BP202 PROPOSALS INPUTTED</center></th>
                      <th rowspan="2" style="border: 1px solid #DDD"><center>TOTAL 2024 BUDGET</center></th>
                    </tr>
                    <tr>
                      <th style="border: 1px solid #DDD"><center>R&D</center></th>
                      <th style="border: 1px solid #DDD"><center>Non-R&D</center></th>
                      <th style="border: 1px solid #DDD"><center>TOTAL</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach (getDivision() as $item)
                        <tr>
                          <td>
                            {{ $item->acronym }}
                          </td>
                          <td align="center">
                            <a href="{{ url('/overview/RD/'.$item->division_id) }}" target="_blank">{{ formatNum(getDivisionProposalType('RD',$item->division_id )) }}</a>
                          </td>
                          <td align="center">
                            <a href="{{ url('/overview/NONRD/'.$item->division_id) }}" target="_blank">{{ formatNum(getDivisionProposalType('NONRD',$item->division_id )) }}</a>
                          </td>
                          <td align="center">
                            <a href="{{ url('/overview/ALL/'.$item->division_id) }}" target="_blank">{{ formatNum(getDivisionProposal($item->division_id )) }}</a>
                          </td>
                          <td align="right">
                            {{ formatNum(number_format(getDivisionProposalBudget($item->division_id))) }}
                          </td>
                        </tr>
                    @endforeach
                    
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-6">
              
            </div>


          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->    
@endsection