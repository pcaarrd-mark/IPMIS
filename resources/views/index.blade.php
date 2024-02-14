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
            <div class="col-12">
              <div class="card">
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped table-valign-middle">
                    <thead>
                    <tr>
                        <th rowspan="3" style="border: 1px solid #DDD"><center>DIVISION</center></th>
                        <th colspan = "4" style="border: 1px solid #DDD"><center>YEAR 1</center></th>
                        <th style="border: 1px solid #DDD"><center>YEAR 2</center></th>
                        <th  style="border: 1px solid #DDD"><center>YEAR 3</center></th>
                    </tr>
                    <tr>
                      <th colspan = "3" style="border: 1px solid #DDD"><center># OF BP202 PROPOSALS INPUTTED</center></th>
                      <th rowspan="2" style="border: 1px solid #DDD"><center>TOTAL 2024 BUDGET</center></th>
                      <th rowspan="2" style="border: 1px solid #DDD"><center>TOTAL 2025</center></th>
                      <th rowspan="2" style="border: 1px solid #DDD"><center>TOTAL 2026</center></th>
                    </tr>
                    <tr>
                      <th style="border: 1px solid #DDD" rowspan="3"><center>R&D</center></th>
                      <th style="border: 1px solid #DDD" rowspan="3"><center>Non-R&D</center></th>
                      <th style="border: 1px solid #DDD" rowspan="3"><center>TOTAL</center></th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                          $total_rd = 0;
                          $total_nonrd = 0;
                          $total_proposal = 0;
                        ?>
                    @foreach (getDivision() as $item)
                      <?php
                        $rd = getDivisionProposalType('RD',$item->division_id );
                        $nonrd = getDivisionProposalType('NONRD',$item->division_id );
                        $totalproposal = getDivisionProposal($item->division_id );

                        $total_rd += $rd;
                        $total_nonrd += $nonrd;
                        $total_proposal += $totalproposal;
                      ?>
                        <tr>
                          <td>
                            {{ $item->acronym }}
                          </td>
                          <td align="center">
                            <a href="{{ url('/overview/RD/'.$item->division_id.'/0') }}" target="_blank">{{ formatNum($rd) }}</a>
                          </td>
                          <td align="center">
                            <a href="{{ url('/overview/NONRD/'.$item->division_id.'/0') }}" target="_blank">{{ formatNum($nonrd) }}</a>
                          </td>
                          <td align="center">
                            <a href="{{ url('/overview/ALL/'.$item->division_id.'/0') }}" target="_blank">{{ formatNum($totalproposal) }}</a>
                          </td>
                          <td align="right">
                            {{ formatNum(number_format(getDivisionProposalBudget($item->division_id,2025))) }}
                          </td>
                          <td align="right">
                            {{ formatNum(number_format(getDivisionProposalBudget($item->division_id,2026))) }}
                          </td>
                          <td align="right">
                            {{ formatNum(number_format(getDivisionProposalBudget($item->division_id,2027))) }}
                          </td>
                        </tr>
                    @endforeach
                    <tr style="font-size: 20px">
                      <td style="border: 1px solid #DDD"><b>GRAND TOTAL</b></td>
                      <td style="border: 1px solid #DDD"><center><b><a href="{{ url('/overview/RD/ALL/0') }}" target="_blank">{{ formatNum($total_rd ) }}</a></b></center></td>
                      <td style="border: 1px solid #DDD"><center><b><a href="{{ url('/overview/NONRD/ALL/0') }}" target="_blank">{{ formatNum($total_nonrd ) }}</a></b></center></td>
                      <td style="border: 1px solid #DDD"><center><b><a href="{{ url('/overview/ALL/ALL/0') }}" target="_blank">{{ formatNum($total_proposal ) }}</a></b></center></td>
                      <td style="border: 1px solid #DDD" align="right"><b><a href="{{ url('/overview/ALL/ALL/2024') }}" target="_blank">{{ number_format(getTotalProjCost(2025)) }}</a></b></td>
                      <td style="border: 1px solid #DDD" align="right"><b>{{ number_format(getTotalProjCost(2026)) }}</b></td>
                      <td style="border: 1px solid #DDD" align="right"><b>{{ number_format(getTotalProjCost(2027)) }}</b></td>
                    </tr>
                    
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            {{-- <div class="col-lg-3 col-6">
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
            </div> --}}
            <!-- ./col -->
            {{-- <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>{{ ave(115291311,getTotalProjCost()) }}<sup style="font-size: 20px">%</sup></h3>
  
                  <p>Budget Allocation for 2024
                    <br>
                    <br>
                    <br>
                  </p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div> --}}
            <!-- ./col -->
            {{-- <div class="col-lg-3 col-6">
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
            </div> --}}
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->    
@endsection