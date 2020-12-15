<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\ApiController;
use Carbon\Carbon;
use TraknPay\EloquentApproval\ApprovalTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanAccountMC extends Model
{
    
    use ApprovalTrait,SoftDeletes;

    public static function isApprover(): bool
    {
        $user = auth()->user();
        if($user->hasRole('admin') 
            //|| $user->hasPermissionTo('checker') 
        ){
            return true;
        }else{
            return false;
        }
    }
    
    protected $table = 'loan_account';

    protected $fillable = [
        'customer_account_id',
        'delivery_id',
        'principal_amount',
        'interest_charged',
        'trn_charge',
        'loan_amount',
        'loan_balance',
        'loan_penalty',
        'loan_status',
        'days_in_arrears',
        'hours_in_arrears',
        'deleted',
        'deleted_by',
        'created_by',
        'updated_by',
        'date_deleted'
    ];

    protected $with = ['customer'];

    public function delivery()
    {
        return $this->belongsTo('App\DeliveryNotification');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_account_id');
    }

    public function products()
    {
        return $this->belongsTo('App\Product');
    }

    public static function offsetUser($msisdn,$amt,$mpesaCode,$timestamp,$desc,$account_no){
        $account_no = "+254" . substr(trim($account_no), -9);
        $amtPaid = $amt;

        $customer = Customer::where('customer_account_msisdn', $account_no)->first();
        if($customer){
            //dd($customer);
            $loans = LoanAccount::where('loan_status','0')
                ->where('customer_account_id',$customer->id)
                ->get();
            //dd($loans);
            if($loans){
                foreach ($loans as $key => $loan) {
                    # code...
                    //$days = Carbon::now()->diffInDays(Carbon::parse($loan->created_at));
                    //dd($amt);
                    $amountPaidForLoan = 0;
                    $loan_amount = $loan->loan_balance;
                    if($amt > $loan->loan_balance && $amt > 0 ){
                        $amt -= $loan->loan_balance;
                        $amountPaidForLoan = $loan->loan_balance;
                        $loan->loan_balance = 0;
                        $loan->loan_status = 1;
                    }else if($amt > 0 && $amt <= $loan->loan_balance){
                        $amountPaidForLoan = $amt;
                        $loan->loan_balance -= $amt;
                        $amt -= $loan_amount;     
                    }
                    if($loan->loan_balance <= 0){
                        $loan->loan_status = 1;
                    }
                    $loan->save(); 
                    
                    //Submit Data of Repayment
                    $data = [
                        "loan_reference_id" =>  (string)$loan->id,
                        "receipt_no" => $loan->delivery->receipt_number,
                        "amount_paid" => $amountPaidForLoan,
                        "loan_amount" => $loan_amount,
                        "paid_datetime" => Carbon::now(),
                        "loan_balance" => $loan->loan_balance
                    ];
                    //ApiController::loanRepaymentTwiga($data,$loan);
                }
            }
            self::recordTransaction([
                'customer_id' => $customer->id,
                'msisdn' => $account_no,
                'paid_by' => $msisdn,
                'transaction_reference' => $mpesaCode,
                'transaction_amount' => $amtPaid,
                'transaction_time' => $timestamp,
                'transaction_status' => 1,
                'transaction_type' => $desc
            ]);
        }else{
            self::recordTransaction([
                'customer_id' => NULL,
                'msisdn' => $account_no,
                'paid_by' => $msisdn,
                'transaction_reference' => $mpesaCode,
                'transaction_amount' => $amtPaid,
                'transaction_time' => $timestamp,
                'transaction_status' => 0,
                'transaction_type' => $desc
            ]);
        }
    }

    public static function recordTransaction($data){
        $transaction = Transaction::where('transaction_reference',$data['transaction_reference'])->first();
        if(!$transaction){
            Transaction::create($data);
        }
    }
}
