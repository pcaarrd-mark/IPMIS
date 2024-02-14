<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf_token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="device-width, initial-scale=1">
  <title>IPMIS | Project Monitoring System</title>

     <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admintemplate/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('admintemplate/plugins/bootstrap5/css/bootstrap.min.css') }}">

    <!-- sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('sweetalert2/package/dist/sweetalert2.min.css') }}">

  
  <style>
    body{
        font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
  </style>

  <body class="">
    <div id="overlay"></div>
    <div class="container-fluid p-5">
        
        <div class="sticky-sm-top p-2"><p align="right" class="mt-2">
            <button class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#commentModal"><i class="fas fa-comments"></i> TOTAL COMMENTS {{getAllComments($data['project']['id'])}}</button>
            &nbsp<button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addCommentModal"><i class="fas fa-plus"></i> ADD</button></p></div>

        <table class="table table-bordered">
            <tr>
                <td style="width:30%" class="fw-bold">Program Title: </td>
                <td>{{getProgramDetails($data['project']['program_id'],'title')}}</td>
            </tr>
            <tr>
                <td class="fw-bold">Project Title: </td>
                <td>{{$data['project']['title']}}</td>
            </tr>
            <tr>
                <td>Project Leader/Sex: </td>
                <td></td>
            </tr>
            <tr>
                <td>Project Duration (number of months): </td>
                <td>
                    Project Start Date:
                <br>Project End Date:
                </td>
            </tr>
            <tr>
                <td>Implementing Agency <small>(Name of University-College-Institute, Department/Organization or Company)</small>:</td>
                <td></td>
            </tr>
            <tr>
                <td>Address/Telephone/Fax/Email: </td>
                <td></td>
            </tr>
            <tr>
                <td>Site of Implementation: </td>
                <td></td>
            </tr>
            <tr>
                <td>Type of Research: </td>
                <td></td>
            </tr>
            <tr>
                <td>Sustainable Development Goal (SDG) Addressed: </td>
                <td></td>
            </tr>
            <tr>
                <td>Executive Summary: </td>
                <td></td>
            </tr>
            <tr>
                <td>Executive Summary: </td>
                <td></td>
            </tr>
            <tr>
                <td>Rationale/Significance: </td>
                <td></td>
            </tr>
            <tr>
                <td>Scientific Basis/Theoretical Framework: </td>
                <td></td>
            </tr>
            <tr>
                <td>Objectives: </td>
                <td></td>
            </tr>
            <tr>
                <td>Review Of Literature: </td>
                <td></td>
            </tr>
            <tr>
                <td>Methodology: </td>
                <td></td>
            </tr>
            <tr>
                <td>Technology Roadmap: </td>
                <td></td>
            </tr>
            <tr>
                <td>Expected Outputs (6Ps): </td>
                <td></td>
            </tr>
            <tr>
                <td>Potential Outcomes: </td>
                <td></td>
            </tr>
            <tr>
                <td>Potential Impacts (2Is): </td>
                <td></td>
            </tr>
            <tr>
                <td>Target Beneficiaries: </td>
                <td></td>
            </tr>
            <tr>
                <td>Sustainability Plan <small>(If Applicable)</small>: </td>
                <td></td>
            </tr>
            <tr>
                <td>Gender And Development (Gad) Score <small>(Refer To The Attached Gad Checklist)</small>: </td>
                <td></td>
            </tr>
            <tr>
                <td>Limitations Of The Project: </td>
                <td></td>
            </tr>
            <tr>
                <td>List Of Risks And Assumptions Risk Management Plan <small>(List Possible Risks And Assumptions In Attaining Target Outputs Or Objectives.)</small>: </td>
                <td></td>
            </tr>
            <tr>
                <td>Literature Cited: </td>
                <td></td>
            </tr>
            <tr>
                <td>Personnel Requirement: </td>
                <td></td>
            </tr>
            <tr>
                <td>Personnel Requirement: </td>
                <td></td>
            </tr>
        </table>

        <table class="table table-bordered">
            <tr>
                <td colspan="5" align="center">Budget By Implementing Agency</td>
            </tr>
            <tr align="center">
                <td style="width:20%">YEAR</td>
                <td style="width:20%">PS</td>
                <td style="width:20%">MOOE</td>
                <td style="width:20%">EO</td>
                <td style="width:20%">TOTAL</td>
            </tr>
            <tr>
                <td align="center">TOTAL</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <table class="table table-bordered">
            <tr>
                <td colspan="5" align="center">Other Ongoing Projects Being Handled By The Project Leader: _____ (Number)</td>
            </tr>
            <tr align="center">
                <td style="width:33%">Title of the Project</td>
                <td style="width:33%">Funding Agency</td>
                <td style="width:33%">Involvement in the Project</td>
            </tr>
        </table>

    <table class="table table-bordered">
        <tr>
            <td style="width: 30%">Other Supporting Documents: </td>
            <td></td>
        </tr>
    </table>

   <!-- Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Comments</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">
            <table class="table table-bordered text-sm">
                <thead align="center">
                    <th>Comment</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Date</th> 
                </thead>
                @foreach (getAllComments($data['project']['id'],'list') as $item)
                    <tr>
                        <td style="width: 40%">{{$item->comment}}</td>
                        <td>{{$item->remarks_by}}</td>
                        <td>{{$item->status}}</td>
                        <td>{{$item->created_at}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div> 
  
  <div class="modal fade" id="addCommentModal" tabindex="-1" aria-labelledby="commentModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Comment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" id="frm_comment" enctype="multipart/form-data" role="form" action="{{ url('/project/add-comments') }}">
                @csrf
                <input type="hidden" name="comment_project_id" value="{{$data['project']['id']}}">
                <input type="hidden" name="remarks_for_id" value="{{$data['project']['created_by']}}">
            <div class="mb-3">
                <label for="comments" class="form-label">Comment/s</label>
                <textarea class="form-control" id="comments" name="comments" rows="3"></textarea>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="frmSubmit('frm_comment','{{ url('/project/add-comments') }}','{{ url('project/comments/'.$data['project']['id']) }}')">Save</button>
          {{-- <button type="submit" class="btn btn-primary">Save</button> --}}
            </form>
        </div>
      </div>
    </div>
  </div> 

</div>
    
  </body>

  <script src="{{ asset('admintemplate/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('admintemplate/plugins/bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Sweetalert2 -->
  <script src="{{ asset('sweetalert2/package/dist/sweetalert2.all.min.js') }}"></script>
  <script src="{{ asset('js/post.js') }}"></script>

  <script>

  </script>