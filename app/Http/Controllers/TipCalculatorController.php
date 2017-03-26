<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TipCalculatorController extends Controller
{
    public function index(Request $request){
        dump($request);

        //Create an array to map the service quality to tip percentage
        $tipPercentage = ['excellent' => 20,'good' => 18,'average' => 15,'poor' => 10,'horrible' => 0];

        $initialBill = $request->input('initialBill', null);
        $splitNumber = $request->input('splitNumber', null);
        $service = $request->input('service', null);
        $roundTip = $request->input('roundTip', null);


        dump($initialBill);
        dump($splitNumber);
        dump($service);
        dump($roundTip);


        //Need to validate the form entries prior to submitting
//        $this->validate($request, [
//            'title' => 'required|min:3',
//        ]);
//
        if ($initialBill)
        {
//            $errors = $form->validate(['initialBill' => 'required|decimal',
//                'splitNumber' => 'required|numeric',
//                'service' => 'required']);

            //Only calculate tip if there are no form validation errors
            //if (!$errors)
            //{
                //Calculate the bill based on service
                $billWithTip = self::calculateBillWithTip($initialBill, $splitNumber, $service, $tipPercentage);

                //Setting the final bill to billWithTip by default to be used in html
                //Only call roundTip and override only if rounding is selected
                //Default is to not round
                $finalBill =  $billWithTip;
                if(!is_null($roundTip))
                {
                    $finalBill = self::roundTip($billWithTip, $roundTip);
                }
           // }
        }
        dump($billWithTip);
        dump($finalBill);

        return view('/calculateTip')->with([
            'initialBill' => $request->input('initialBill', null),
            'splitNumber' => $request->input('splitNumber', null),
            'service' => $request->input('service', null),
            'roundTip' => $request->input('roundTip', null),
            'billWithTip' => $request->input('billWithTip', null),
            'finalBill' => $request->input('finalBill',null)]);
    }

    /**
     * Returns the calculated bill depending on the tip amount
     */
    public function calculateBillWithTip($initialBill, $splitNumber, $service, $tipPercentage)
    {
        //Divide the initial bill amount by the number specified in the form
        //Will only divide if greater than 0 otherwise splitAmount is the initialBill
        if ($splitNumber != 0){
            $splitAmount = $initialBill / $splitNumber;
        }else{
            $splitAmount= $initialBill;
        }

        //calculate the bill with the tip specified in the form.
        //divide tipPercentage by 100 to get percentage in decimal
        $calculateTip = $splitAmount + ($splitAmount * ($tipPercentage[$service]/100));

        //Return value needs to be rounded to 2 decimal places.
        return round($calculateTip,2,PHP_ROUND_HALF_UP);
    }

    /**
     * Returns a rounded final bill if rounding is selected
     */
    public function roundTip($amount, $roundTip)
    {
        //round if indicated
        if ($roundTip == 'roundUp') {
            return $finalBill = ceil($amount);
        } elseif ($roundTip == 'roundDown') {
            return $finalBill = floor($amount);
        }
    }
}