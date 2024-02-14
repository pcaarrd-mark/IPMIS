<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Auth;

class PrinterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        
    }

    public function workplan($projectID)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('<!DOCTYPE html>
        <html>
        <head>
          <title>WORKPLAN</title>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        </head>
        <style type="text/css">
                @page {
                  margin: 15;
                }
            body
            {
                font-family:DejaVu Sans;
            }
            th,td
            {
                border:1px solid #555;
                font-size:12px;
                page-break-inside: always;

            }
            .tr-space,.td-space
            {
                border:1px solid #FFF;
                font-size:10px;
            }
            .page-break {
                page-break-after: always;
               }
            table
            {
                page-break-inside: always;

            }
        </style>
        <body>
        <center><span style="font-size: 12px;text-align:right"><b>DOST Form 5</b></span></center>
        <center><span style="font-size: 15px"><b>A – PROJECT WORKPLAN</b></span></center>
        <br>
        <table style="width:100%">
            <tr>
                <td colspan="3" style="border:1px solid #FFF;">(1) Program Title:</td>
            </tr>
            <tr>
                <td colspan="3" style="border:1px solid #FFF;">(2) Project Title:</td>
            </tr>
            <tr>
                <td style="border:1px solid #FFF;">(3) Project Duration (number of months): ______________</td>
                <td style="border:1px solid #FFF;">(4) Project Start Date: ________________	</td>
                <td style="border:1px solid #FFF;">(5) Project End Date: _________________ </td>
            </tr>
        </table>
        <br>
        <table style="width:100%;font-size:11px" cellpadding="1" cellspacing="0">
                    <tr>
                        <td style="width: 15%" rowspan="2" valign="middle">
                            <b><center>(6) OBJECTIVES</<center></b>
                        </td>
                        <td style="width: 15%" rowspan="2" valign="middle">
                            <b><center>(7) TARGET ACTIVITIES</<center></b>
                        </td>
                        <td style="width: 15%" rowspan="2" valign="middle">
                            <b><center>(8) TARGET ACCOMPLISHMENTS <small><br/>(quantify, if possible)</small></center></b>
                        </td>
                        <td colspan="5"><b><center>Y1</center></b></td>
                        <td colspan="5"><b><center>Y2</center></b></td>
                        <td colspan="5"><b><center>Y3</center></b></td>
                    </tr>
                    <tr>
                        <td align="center"><b>Q1</b></td>
                        <td align="center"><b>Q2</b></td>
                        <td align="center"><b>Q3</b></td>
                        <td align="center"><b>Q4</b></td>
                        <td align="center"><b>TOTAL</b></td>
                        <td align="center"><b>Q1</b></td>
                        <td align="center"><b>Q2</b></td>
                        <td align="center"><b>Q3</b></td>
                        <td align="center"><b>Q4</b></td>
                        <td align="center"><b>TOTAL</b></td>
                        <td align="center"><b>Q1</b></td>
                        <td align="center"><b>Q2</b></td>
                        <td align="center"><b>Q3</b></td>
                        <td align="center"><b>Q4</b></td>
                        <td align="center"><b>TOTAL</b></td>
                    </tr>
        </table>
        
        <div class="page-break"></div>

        <center><span style="font-size: 12px;text-align:right"><b>DOST Form 5</b></span></center>
        <center><span style="font-size: 15px"><b>B – EXPECTED OUTPUT</b></span></center>
        <br>
        <table style="width:100%">
            <tr>
                <td colspan="3" style="border:1px solid #FFF;">(1) Program Title:</td>
            </tr>
            <tr>
                <td colspan="3" style="border:1px solid #FFF;">(2) Project Title:</td>
            </tr>
            <tr>
                <td style="border:1px solid #FFF;">(3) Project Duration (number of months): ______________</td>
                <td style="border:1px solid #FFF;">(4) Project Start Date: ________________	</td>
                <td style="border:1px solid #FFF;">(5) Project End Date: _________________ </td>
            </tr>
        </table>
        <br>
        <table style="width:100%;font-size:11px" cellpadding="1" cellspacing="0">
                    <tr>
                        <td style="width: 20%" rowspan="2" valign="middle">
                            <b><center>(9) EXPECTED OUTPUTS (6Ps)</<center></b>
                        </td>
                        <td style="width: 20%" valign="middle" colspan="5">
                            <b><center>Y1 Objectively Verifiable Indicators (OVIs)</<center></b>
                        </td>
                        <td style="width: 20%" valign="middle" colspan="5">
                            <b><center>Y2 Objectively Verifiable Indicators (OVIs)</small></center></b>
                        </td>
                        <td style="width: 20%" valign="middle" colspan="5">
                            <b><center>Y3 Objectively Verifiable Indicators (OVIs)</small></center></b>
                        </td>
                    </tr>
                    <tr>
                        <td align="center"><b>Q1</b></td>
                        <td align="center"><b>Q2</b></td>
                        <td align="center"><b>Q3</b></td>
                        <td align="center"><b>Q4</b></td>
                        <td align="center"><b>TOTAL</b></td>
                        <td align="center"><b>Q1</b></td>
                        <td align="center"><b>Q2</b></td>
                        <td align="center"><b>Q3</b></td>
                        <td align="center"><b>Q4</b></td>
                        <td align="center"><b>TOTAL</b></td>
                        <td align="center"><b>Q1</b></td>
                        <td align="center"><b>Q2</b></td>
                        <td align="center"><b>Q3</b></td>
                        <td align="center"><b>Q4</b></td>
                        <td align="center"><b>TOTAL</b></td>
                    </tr>
        </table>
        
        

        <div class="page-break"></div>
        
        <center><span style="font-size: 12px;text-align:right"><b>DOST Form 5</b></span></center>
        <center><span style="font-size: 15px"><b>C – RISK AND ASSUMPTION</b></span></center>
        <br>
        <table style="width:100%">
            <tr>
                <td colspan="3" style="border:1px solid #FFF;">(1) Program Title:</td>
            </tr>
            <tr>
                <td colspan="3" style="border:1px solid #FFF;">(2) Project Title:</td>
            </tr>
            <tr>
                <td style="border:1px solid #FFF;">(3) Project Duration (number of months): ______________</td>
                <td style="border:1px solid #FFF;">(4) Project Start Date: ________________	</td>
                <td style="border:1px solid #FFF;">(5) Project End Date: _________________ </td>
            </tr>
        </table>
        <br>
        <table style="width:100%;font-size:11px" cellpadding="1" cellspacing="0">
                    <tr>
                        <td style="width: 20%" rowspan="2" valign="middle">
                            <b><center>(9) EXPECTED OUTPUTS (6Ps)</<center></b>
                        </td>
                        <td style="width: 20%" valign="middle" colspan="5">
                            <b><center>Y1 Objectively Verifiable Indicators (OVIs)</<center></b>
                        </td>
                        <td style="width: 20%" valign="middle" colspan="5">
                            <b><center>Y2 Objectively Verifiable Indicators (OVIs)</small></center></b>
                        </td>
                        <td style="width: 20%" valign="middle" colspan="5">
                            <b><center>Y3 Objectively Verifiable Indicators (OVIs)</small></center></b>
                        </td>
                    </tr>
                    <tr>
                        <td align="center"><b>Q1</b></td>
                        <td align="center"><b>Q2</b></td>
                        <td align="center"><b>Q3</b></td>
                        <td align="center"><b>Q4</b></td>
                        <td align="center"><b>TOTAL</b></td>
                        <td align="center"><b>Q1</b></td>
                        <td align="center"><b>Q2</b></td>
                        <td align="center"><b>Q3</b></td>
                        <td align="center"><b>Q4</b></td>
                        <td align="center"><b>TOTAL</b></td>
                        <td align="center"><b>Q1</b></td>
                        <td align="center"><b>Q2</b></td>
                        <td align="center"><b>Q3</b></td>
                        <td align="center"><b>Q4</b></td>
                        <td align="center"><b>TOTAL</b></td>
                    </tr>
        </table>

        </body>
        </html>')
        ->setPaper('legal', 'landscape');
        return $pdf->stream();
    }
}
