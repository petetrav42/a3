<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

class TipCalculatorController extends Controller
{
    /**
     * Return the base calculateTip view
     * @param Request $request
     * @return $this
     */
    public function index(Request $request){
        return view('calculateTip')->with([
            'initialBill' => $request->initialBill,
            'splitNumber' => $request->splitNumber,
            'service' => $request->service,
            'roundTip' => $request->roundTip]);
    }

    /**
     * Return the calculated values to the calculateTip view
     * @param Request $request
     * @return $this
     */
    public function calculate(Request $request){

        //Only need to run the logic if there are submitted input values
        if ($request->input())
        {
            //Validate the form values
            $validator = $this->validateForm($request);

            //If validation fails then return to original form to display the errors
            //no need to continue with the code
            if ($validator->fails()) {
                return redirect('/')
                    ->withErrors($validator)
                    ->withInput();
            }

            //Get all the input values from the form since it is valid
            $initialBill = $request->input('initialBill', null);
            $splitNumber = $request->input('splitNumber', null);
            $service = $request->input('service', null);
            $roundTip = $request->input('roundTip', null);

            //Create an array to map the service quality to tip percentage
            $tipPercentage = ['excellent' => 20,'good' => 18,'average' => 15,'poor' => 10,'horrible' => 0];

            //Calculate the bill based on service
            $billWithTip = $this->calculateBillWithTip($initialBill, $splitNumber, $service, $tipPercentage);

            //Setting the final bill to billWithTip by default to be used in html
            //Only call roundTip and override only if rounding is selected
            //Default is to not round
            $finalBill =  $billWithTip;
            if(!is_null($roundTip))
            {
                $finalBill = $this->roundTip($billWithTip, $roundTip);
            }
        }

        //Return the input values as well as other values to be used when displaying information to the user.
        return view('calculateTip')->with([
            'initialBill' => $initialBill,
            'splitNumber' => $splitNumber,
            'service' => $service,
            'tipPercentage' => $tipPercentage[$service],
            'roundTip' => $roundTip,
            'billWithTip' => $billWithTip,
            'finalBill' => $finalBill]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function validateForm(Request $request)
    {
        //Validation rules for the form
        $rules = array(
            'initialBill' => 'required|numeric',
            'splitNumber' => 'required|numeric',
            'service' => 'required',
        );

        //Custom error messages
        $messages = [
            'initialBill.required' => 'Initial bill amount is required to calculate the tip',
            'initialBill.numeric' => 'The initial bill amount must be numeric',
            'splitNumber.required' => 'Split bill is required to calculate the tip',
            'splitNumber.numeric' => 'Split bill must be numeric',
            'service.required' => 'The level of service is required',
        ];

        //Run validation on the request according to the defined rules
        $validator = Validator::make($request->all(), $rules, $messages);

        return $validator;
    }

    /**
     * Returns the calculated bill depending on the tip amount
     * @param $initialBill
     * @param $splitNumber
     * @param $service
     * @param $tipPercentage
     * @return float
     */
    public function calculateBillWithTip($initialBill, $splitNumber, $service, $tipPercentage)
    {
        //Divide the initial bill amount by the number specified in the form
        //Will only divide if greater than 0 otherwise splitAmount is the initialBill
        if ($splitNumber > 0){
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
     * @param $amount
     * @param $roundTip
     * @return float
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