<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class LoanTest extends TestCase
{
    /**
     * Authenticate user.
     *
     * @return void
     */
    protected function authenticate()
    {
        $user = User::create([
            'name' => 'test',
            'email' => time().'test@gmail.com',
            'password' => bcrypt('secret9874'),
        ]);

        if (!auth()->attempt(['email'=>$user->email, 'password'=>'secret9874'])) {
            return response(['message' => 'Login credentials are invaild']);
        }

        return $accessToken = auth()->user()->createToken('authToken')->accessToken;
    }

    public function testAddLoan()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->post('/api/loans', [
            'applicant_name'  => 'Test',
            'amount'  =>  100000,
            'loan_term'  =>  5,
            'phoneno'  =>  '9586039287',
            'emailid'  =>  'vyom@gmail.com',
        ]);
        
        $response->assertStatus(200);
    }

    public function testShowLoan()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->get('/api/loans');
        
        $response->assertStatus(200);
    }

    public function testApproveLoan()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->post('/api/approveloan', [
            'id' => 6
        ]);
        
        $response->assertStatus(200);
    }

    public function testRepayLoan()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->post('/api/repayment', [
            'amount_paid' => 1000,
            'loan_id' => 4
        ]);
        $response->assertStatus(200);
    }
}