<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\LoanCycle;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function index()
    {
        $loans = auth()->user()->loans;
 
        return response()->json([
            'success' => true,
            'data' => $loans
        ]);
    }
 
    public function show($id)
    {
        $loan =  auth()->user()->loans()->find($id);
 
        if (!$loan) {
            return response()->json([
                'success' => false,
                'message' => 'Loan not found'
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $loan->toArray()
        ], 400);
    }
 
    public function store(Request $request)
    {
        $this->validate($request, [
            'applicant_name' => 'required',
            'amount' => 'required',
            'loan_term' => 'required',
        ]);
        
        $loan = new Loan();
        $loan->applicant_name = $request->applicant_name;
        $loan->amount = $request->amount;
        $loan->loan_term = $request->loan_term;
        $months = $request->loan_term * 12;
        $weeks = $months * 4;
        $loan->phoneno = $request->phoneno;
        $loan->emailid = $request->emailid;
        $loan->loan_approve_date = Carbon::now()->format('Y-m-d');
        $installmant = ($request->amount / $weeks);
        $loan->next_installment_amount = $installmant;
 
        if (auth()->user()->loans()->save($loan))
            return response()->json([
                'success' => true,
                'data' => $loan->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Loan Application not added'
            ], 500);
    }

    public function repayment(Request $request)
    {
        $this->validate($request, [
            'amount_paid' => 'required',
            'loan_id' => 'required',
        ]);
        
        $current_date = Carbon::createFromFormat('Y-m-d' ,Carbon::now()->format('Y-m-d'));
        $next_replay_date = Carbon::createFromFormat('Y-m-d' ,LoanCycle::where('loan_id', $request->loan_id)->orderBy('id', 'desc')->pluck('next_replay_date')->first());
        
        $ifOverDue = $next_replay_date->gt($current_date);
        
        if($ifOverDue) {
            return response()->json([
                'success' => false,
                'msg' => 'You are a defaulter'
            ]);
        }

        $loanCycle = new LoanCycle();
        $loanCycle->repay_date = Carbon::now()->format('Y-m-d');
        $loanCycle->next_replay_date = Carbon::now()->addDays(7)->format('Y-m-d');
        $loanCycle->loan_id = $request->loan_id;
        $loanCycle->amount_paid = $request->amount_paid;
        $loanCycle = LoanCycle::create($loanCycle->toArray());

        if ($loanCycle)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Loan Application not added'
            ], 500);
    }
 
    public function approveLoan(Request $request)
    {
        $loan = auth()->user()->loans()->find($request->id);
 
        if (!$loan) {
            return response()->json([
                'success' => false,
                'message' => 'Loan not found'
            ], 400);
        }
 
        $loan->is_approved = 1;
        $updated = $loan->save();

        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Loan Status can not be updated'
            ], 500);
    }

    public function destroy($id)
    {
        $post = auth()->user()->loans()->find($id);
 
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 400);
        }
 
        if ($post->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post can not be deleted'
            ], 500);
        }
    }
}