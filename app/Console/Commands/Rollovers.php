<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\LoanAccount;
use Carbon\Carbon;
use App\SMS;
use App\Settings;

class Rollovers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rollovers:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollover the loans if they have accrued in days and are unpaid';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public static $thirdDayStandardCharge;
    public static $rateForFiveDaysAndBelow;
    public static $rateAboveTenDays;
    public static $rateAboveFiveDays;
    
    public function __construct()
    {
        parent::__construct();
        self::$thirdDayStandardCharge = Settings::where('name','3rdDayStandardCharge')->pluck('value')->first();
        static::$rateForFiveDaysAndBelow = Settings::where('name','RateForFiveDaysAndBelow')->pluck('value')->first();
        static::$rateAboveFiveDays = Settings::where('name','RateAboveFiveDays')->pluck('value')->first();
        static::$rateAboveTenDays = Settings::where('name','RateAboveTenDays')->pluck('value')->first();
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
            if($loan->customer->rollover != 1){
                $hours = Carbon::now()->diffInHours(Carbon::parse($loan->created_at));
                $days = Carbon::now()->diffInDays(Carbon::parse($loan->created_at));
                
                //echo Carbon::now()->addDays(7);
                if($hours == 72 && $loan->hours_in_arrears != 72){
                    self::balanceChange($loan,$hours,3);
                }else if($hours == 96 && $loan->hours_in_arrears != 96){
                    self::balanceChange($loan,$hours,4);                
                }else if($hours == 120 && $loan->hours_in_arrears != 120){
                    self::balanceChange($loan,$hours,5);
                }else if($hours == 144 && $loan->hours_in_arrears != 144){
                    self::balanceChange($loan,$hours,6);
                }else if($hours == 168 && $loan->hours_in_arrears != 168){
                    self::balanceChange($loan,$hours,7);
                }else if($hours == 192 && $loan->hours_in_arrears != 192){
                    self::balanceChange($loan,$hours,8);
                }else if($hours == 216 && $loan->hours_in_arrears != 216){
                    self::balanceChange($loan,$hours,9);
                }else if($hours == 240 && $loan->hours_in_arrears != 240){
                    self::balanceChange($loan,$hours,10);
                }else if($days > 10 && $loan->days_in_arrears != $days){
                    self::balanceChangeDaily($loan,$days);
                }
            }
        }
    }

    public static function balanceChange($loan,$hours,$days){
        $standardCharge = 0;
        //0.495
        $rate = self::$rateForFiveDaysAndBelow;
        if($hours == 72){
            //15
            $standardCharge = self::$thirdDayStandardCharge;
        }
        if($hours > 120){
            //0.55
            $rate = self::$rateAboveFiveDays;
        }
        $interest = $loan->loan_balance * $rate/100;
        $loan->interest_charged += $interest;
        $loan->trn_charge += $standardCharge;
        $loan->loan_balance += ($interest + $standardCharge);
        $loan->hours_in_arrears = $hours;
        $loan->days_in_arrears = $days;
        //$loan->loan_penalty = $loan->loan_balance- $loan->loan_amount;
        $loan->save();
        if($hours == 96){
            $msg = "Dear ".$loan->customer->person->first_name.", your M-Weza Facility amount due has changed to Ksh. ".round($loan->loan_balance,0).", & will attract a fee of 0.5% daily until the 6th day. Dial *483*818# to make payment todayto avoid more charges.";
            SMS::sendsms($loan->customer->customer_account_msisdn,$msg);
        }else if($hours == 72){
            $msg = "Dear ".$loan->customer->person->first_name.", your TWIGA-MWeza Facility balance as at now is Ksh. ".round($loan->loan_balance,0).". Kindly settle it today. Dial *483*818# now to make your payment";
            SMS::sendsms($loan->customer->customer_account_msisdn,$msg);
        }else if($hours == 144){
            $msg = "Dear ".$loan->customer->person->first_name.", your M-Weza Facility balance as at now is Ksh. ".round($loan->loan_balance,0).". Kindly settle it by end of day today to avoid additionalcharges. Dial *483*818# now topay";
            SMS::sendsms($loan->customer->customer_account_msisdn,$msg);
        }else if($hours == 168){
            $msg = "Dear ".$loan->customer->person->first_name.", your M-Weza Facility amount due has changed to Ksh. ".round($loan->loan_balance,0).", & will attract a fee of 0.55% daily until the 9th day. Dial *483*818# now to pay by end of day today to reduce charges.";
             SMS::sendsms($loan->customer->customer_account_msisdn,$msg);
        }else if($hours == 216){
            $msg = "Dear ".$loan->customer->person->first_name.", your M-Weza Facility balance as at now is Ksh. ".round($loan->loan_balance,0).". You have exceeded the acceptable payment period allowed. Kindly settle it IMMEDIATELY to avoid additional higher charges daily until you pay in full";
            SMS::sendsms($loan->customer->customer_account_msisdn,$msg);
        }else if($hours == 240){
            $msg = "Dear ".$loan->customer->person->first_name.", the M-Weza Facility fee has changed to 0.65% daily until you clear all the outstanding amount. The new amount due is Ksh. ".round($loan->loan_balance,0).". Kindly settle it IMMEDIATELY to avoid additional higher charges";
            SMS::sendsms($loan->customer->customer_account_msisdn,$msg);
        }
    }

    public static function balanceChangeDaily($loan,$days){
        //0.65
        $rate = self::$rateAboveTenDays;
        $interest = $loan->loan_balance * $rate/100;
        $loan->loan_balance += $interest;
        $loan->days_in_arrears = $days;
        $loan->loan_penalty += $interest;
        $loan->save();
        if($days == 11){
            $msg = "Dear ".$loan->customer->person->first_name.", your M-Weza Facility balance as at now is Ksh. ".round($loan->loan_balance,0).". You have exceeded the acceptable payment period allowed. Kindly settle it IMMEDIATELY to avoid additional higher charges daily until you pay in full";
            SMS::sendsms($loan->customer->customer_account_msisdn,$msg);
        }
    }    
}
