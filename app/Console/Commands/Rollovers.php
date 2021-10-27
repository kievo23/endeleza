<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\LoanAccount;
use Carbon\Carbon;
use App\SMS;
use App\Outbox;
use App\Settings;
use Illuminate\Support\Facades\Log;

class Rollovers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'count_days:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Counts the number of days from when loans were taken';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    // public static $thirdDayStandardCharge;
    // public static $rateForFiveDaysAndBelow;
    // public static $rateAboveTenDays;
    // public static $rateAboveFiveDays;
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $loans = LoanAccount::where('loan_status','0')->get();
        //print_r($loans);
        foreach ($loans as $key => $loan) {
            $hours = Carbon::now()->diffInHours(Carbon::parse($loan->created_at));
            $days = Carbon::now()->diffInDays(Carbon::parse($loan->created_at));
            Log::alert("=================================================== BEGINNING OF ROLLOVER LOG ============================================");
            Log::alert("days: ".$days);
            //Log::alert("days in db: ".$loan->days_in_arrears);
            //Log::alert("Loan Id: ".$loan->id);
            Log::alert("Customer No: ".$loan->customer->customer_account_msisdn);
            //SEND SMS FOR ONE WEEK LOAN
            if($loan->customer->interest == 6 && $loan->days_in_arrears == 5 && $days == 6){
                $sms = "REMINDER! Your stock loan balance of Ksh. ".$loan->loan_balance." is due TOMORROW. Kindly CLEAR via Till Number 5041363 or dial *483*209# and select option 2.";
                $res = SMS::sendSmsLeopard($loan->customer->customer_account_msisdn,$sms);
                Outbox::log(json_decode($res),$sms);
                Log::alert($res);
            }
            //Rollovers
            if($loan->customer->interest == 6 && $loan->days_in_arrears >= 8 && $loan->customer->rollover == 0){
                //Daily interest
                $daily_interest_rate = 0.86;
                $daily_interest = $daily_interest_rate/100*$loan->loan_balance;
                $new_loan_balance = $loan->loan_balance + $daily_interest;
                $sms = "Dear customer, your OVERDUE loan has attracted Ksh. ". $daily_interest ." as lateness fees. Your new outstanding balance is Ksh. ".$new_loan_balance;
                $res = SMS::sendSmsLeopard($loan->customer->customer_account_msisdn,$sms);
                Outbox::log(json_decode($res),$sms);
                //Log::alert($res);
                $loan->loan_balance = $new_loan_balance;
                $loan->penalty = $loan->penalty + $daily_interest;
                $loan->save();
            }
            if($loan->customer->interest == 10.5 && $loan->days_in_arrears == 12 && $days == 13){
                //SEND SMS FOR TWO WEEK LOAN
                $sms = "REMINDER! Your stock loan balance of Ksh. ".$loan->loan_balance." is due TOMORROW. Kindly CLEAR via Till Number 5041363 or dial *483*209# and select option 2.";
                $res = SMS::sendSmsLeopard($loan->customer->customer_account_msisdn,$sms);
                Outbox::log(json_decode($res),$sms);
                Log::alert($res);
            }
            //SEND SMS THAT PAYMENT IS DUE
            if($loan->customer->interest == 6 && $loan->days_in_arrears == 6 && $days == 7){
                $sms = "Dear Customer, your stock loan balance of Ksh. ".$loan->loan_balance." is due TODAY. Kindly pay via Buy Goods Till Number 5041363 to access new stock.";
                $res = SMS::sendSmsLeopard($loan->customer->customer_account_msisdn,$sms);
                //Log::alert($res);
                //Log::alert($loan->customer->customer_account_msisdn);
                Outbox::log(json_decode($res),$sms);                
            }
            if($loan->customer->interest == 10.5 && $loan->days_in_arrears == 13 && $days == 14){
                //SEND SMS FOR TWO WEEK LOAN
                $sms = "Dear Customer, your stock loan balance of Ksh. ".$loan->loan_balance." is due TODAY. Kindly pay via Buy Goods Till Number 5041363 to access new stock.";
                $res = SMS::sendSmsLeopard($loan->customer->customer_account_msisdn,$sms);
                Outbox::log(json_decode($res),$sms);
                Log::alert($res);
            }
            if($loan->customer->interest == 10.5 && $loan->days_in_arrears >= 15 && $loan->customer->rollover == 0){
                //Daily interest
                $daily_interest_rate = 0.75;
                $daily_interest = $daily_interest_rate/100*$loan->loan_balance;
                $new_loan_balance = $loan->loan_balance + $daily_interest;
                $sms = "Dear customer, your OVERDUE loan has attracted Ksh. ". $daily_interest ." as lateness fees. Your new outstanding balance is Ksh. ".$new_loan_balance;
                $res = SMS::sendSmsLeopard($loan->customer->customer_account_msisdn,$sms);
                Outbox::log(json_decode($res),$sms);
                //Log::alert($res);
                $loan->loan_balance = $new_loan_balance;
                $loan->penalty = $loan->penalty + $daily_interest;
                $loan->save();
            }
            //Log::alert("=================================================== END OF ROLLOVER LOG============================================");
            if($loan->customer->rollover != 1){
                
            }

            $loan->hours_in_arrears = $hours;
            $loan->days_in_arrears = $days;
            $loan->save();
        }
    }

    // public static function balanceChange($loan,$hours,$days){
    //     // $standardCharge = 0;
    //     // //0.495
    //     // $rate = self::$rateForFiveDaysAndBelow;
    //     // if($hours == 72){
    //     //     //15
    //     //     $standardCharge = self::$thirdDayStandardCharge;
    //     // }
    //     // if($hours > 120){
    //     //     //0.55
    //     //     $rate = self::$rateAboveFiveDays;
    //     // }
    //     // $interest = $loan->loan_balance * $rate/100;
    //     //$loan->interest_charged += $interest;
    //     //$loan->trn_charge += $standardCharge;
    //     //$loan->loan_balance += ($interest + $standardCharge);
    //     $loan->hours_in_arrears = $hours;
    //     $loan->days_in_arrears = $days;
    //     //$loan->loan_penalty = $loan->loan_balance- $loan->loan_amount;
    //     $loan->save();
    //     // if($hours == 96){
    //     //     $msg = "Dear ".$loan->customer->person->first_name.", your M-Weza Facility amount due has changed to Ksh. ".round($loan->loan_balance,0).", & will attract a fee of 0.5% daily until the 6th day. Dial *483*818# to make payment todayto avoid more charges.";
    //     //     SMS::sendsms($loan->customer->customer_account_msisdn,$msg);
    //     // }else if($hours == 72){
    //     //     $msg = "Dear ".$loan->customer->person->first_name.", your TWIGA-MWeza Facility balance as at now is Ksh. ".round($loan->loan_balance,0).". Kindly settle it today. Dial *483*818# now to make your payment";
    //     //     SMS::sendsms($loan->customer->customer_account_msisdn,$msg);
    //     // }else if($hours == 144){
    //     //     $msg = "Dear ".$loan->customer->person->first_name.", your M-Weza Facility balance as at now is Ksh. ".round($loan->loan_balance,0).". Kindly settle it by end of day today to avoid additionalcharges. Dial *483*818# now topay";
    //     //     SMS::sendsms($loan->customer->customer_account_msisdn,$msg);
    //     // }else if($hours == 168){
    //     //     $msg = "Dear ".$loan->customer->person->first_name.", your M-Weza Facility amount due has changed to Ksh. ".round($loan->loan_balance,0).", & will attract a fee of 0.55% daily until the 9th day. Dial *483*818# now to pay by end of day today to reduce charges.";
    //     //      SMS::sendsms($loan->customer->customer_account_msisdn,$msg);
    //     // }else if($hours == 216){
    //     //     $msg = "Dear ".$loan->customer->person->first_name.", your M-Weza Facility balance as at now is Ksh. ".round($loan->loan_balance,0).". You have exceeded the acceptable payment period allowed. Kindly settle it IMMEDIATELY to avoid additional higher charges daily until you pay in full";
    //     //     SMS::sendsms($loan->customer->customer_account_msisdn,$msg);
    //     // }else if($hours == 240){
    //     //     $msg = "Dear ".$loan->customer->person->first_name.", the M-Weza Facility fee has changed to 0.65% daily until you clear all the outstanding amount. The new amount due is Ksh. ".round($loan->loan_balance,0).". Kindly settle it IMMEDIATELY to avoid additional higher charges";
    //     //     SMS::sendsms($loan->customer->customer_account_msisdn,$msg);
    //     // }
    // }

    // public static function balanceChangeDaily($loan,$days){
    //     //0.65
    //     //$rate = self::$rateAboveTenDays;
    //     //$interest = $loan->loan_balance * $rate/100;
    //     //$loan->loan_balance += $interest;
    //     $loan->days_in_arrears = $days;
    //     //$loan->loan_penalty += $interest;
    //     $loan->save();
    //     //if($days == 11){
    //     //    $msg = "Dear ".$loan->customer->person->first_name.", your M-Weza Facility balance as at now is Ksh. ".round($loan->loan_balance,0).". You have exceeded the acceptable payment period allowed. Kindly settle it IMMEDIATELY to avoid additional higher charges daily until you pay in full";
    //     //    SMS::sendsms($loan->customer->customer_account_msisdn,$msg);
    //     //}
    // }    
}
