<?php

namespace App\Http\Controllers;

use App\Models\SelectedCO;
use App\Models\SelectedPS;
use App\Models\SelectedMOOE;
use Illuminate\Http\Request;
use function Spatie\LaravelPdf\Support\pdf;

class ReportController extends Controller
{


    public function downloadBreakdown($record, $type)
    {



        switch ($type) {
            case 'ps':
                $data = SelectedPS::find($record);
                $selected = $data->p_s_expense->title;


                break;
            case 'mooe':
                $data = SelectedMOOE::find($record);
                $selected = $data->m_o_o_e_expense->title;
                break;
                case 'co':
                    $data = SelectedCO::find($record);
                    $selected = $data->description;
                break;

            default:
              $data =  [];
              $description =  '';
                //code block
        }

        // dd($record,$type);

        return pdf('report.pdf.breakdown', [
            'data' => $data,
            'type'=> $type,
            'selected'=> $selected,
        ])->download('new.pdf');
    }


}
