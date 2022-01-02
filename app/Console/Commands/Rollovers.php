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
    protected $signature = 'rollovers:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
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
        //Fetch unpaid loans
        $loans = LoanAccount::where('loan_status','0')->get();
        //print_r($loans);
        foreach ($loans as $key => $loan) {
            if($loan->customer->interest == 6 && $loan->days_in_arrears >= 8 && $loan->customer->rollover == 1){
                //Daily interest
                $daily_interest_rate = 0.86;
                $daily_interest = $daily_interest_rate/100*$loan->loan_balance;
                $new_loan_balance = $loan->loan_balance + $daily_interest;
                $sms = "Dear customer, your OVERDUE loan has attracted Ksh. ". $daily_interest ." as lateness fees. Your new outstanding balance is Ksh. ".$new_loan_balance;
                $res = SMS::sendSmsLeopard($loan->customer->customer_account_msisdn,$sms);
                Outbox::log(json_decode($res),$sms);
                //Log::alert($res);
                $loan->loan_balance = $new_loan_balance;
                $loan->loan_penalty = $loan->loan_penalty + $daily_interest;
                $loan->save();
            }

            if($loan->customer->interest == 10.5 && $loan->days_in_arrears >= 15 && $loan->customer->rollover == 1){
                //Daily interest
                $daily_interest_rate = 0.75;
                $daily_interest = $daily_interest_rate/100*$loan->loan_balance;
                $new_loan_balance = $loan->loan_balance + $daily_interest;
                $sms = "Dear customer, your OVERDUE loan has attracted Ksh. ". $daily_interest ." as lateness fees. Your new outstanding balance is Ksh. ".$new_loan_balance;
                $res = SMS::sendSmsLeopard($loan->customer->customer_account_msisdn,$sms);
                Outbox::log(json_decode($res),$sms);
                //Log::alert($res);
                $loan->loan_balance = $new_loan_balance;
                $loan->loan_penalty = $loan->loan_penalty + $daily_interest;
                $loan->save();
            }

            $dayOfTheWeek = Carbon::now()->dayOfWeek;
            //Late Payment Reminders
            if($loan->customer->interest == 6 && $loan->days_in_arrears >= 7 && ($dayOfTheWeek == 1 || $dayOfTheWeek == 3 || $dayOfTheWeek == 5)){
                $new_amt = $loan->loan_balance + $loan->loan_penalty;
                $sms = "Dear Customer, your loan balance of Ksh. ".$new_amt." is in Default!. Lipa mdogo mdogo to clear and get a new stock. Till Number 5041363";
                $res = SMS::sendSmsLeopard($loan->customer->customer_account_msisdn,$sms);
                //Log::alert($res);
                //Log::alert($loan->customer->customer_account_msisdn);
                Outbox::log(json_decode($res),$sms);                
            }

            if($loan->customer->interest == 10.5 && $loan->days_in_arrears >= 14 && ($dayOfTheWeek == 1 || $dayOfTheWeek == 3 || $dayOfTheWeek == 5)){
                $new_amt = $loan->loan_balance + $loan->loan_penalty;
                $sms = "Dear Customer, your loan balance of Ksh. ".$new_amt." is in Default!. Lipa mdogo mdogo to clear and get a new stock. Till Number 5041363";
                $res = SMS::sendSmsLeopard($loan->customer->customer_account_msisdn,$sms);
                //Log::alert($res);
                //Log::alert($loan->customer->customer_account_msisdn);
                Outbox::log(json_decode($res),$sms);                
            }
        }
    }
}
