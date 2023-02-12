<?php

namespace Tests\Feature;

use App\Lib\WalletLogic;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\ContactHistory;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CandidatesListTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_get_candidates_list()
    {
        $response = $this->get('/candidates')
            ->assertStatus(200);
    }

    public function test_contact_candidate()
    {
        $candidate = Candidate::factory()->create();
        Company::factory()->create();
        $a = Wallet::factory()->create();
        $initialCoins = $a->coins;
        $payload = ['candidateId' => $candidate->id];

        $this->post('/candidates-contact', $payload)
                ->assertJsonFragment([
                    'type' => 'success'
                ]);

        $a->refresh();
        $this->assertEquals($initialCoins - WalletLogic::$COMPANY_CONTACTED_CANDIDATE, $a->coins);
    }

    public function test_contact_candidate_already_contacted()
    {
        Wallet::factory()->create();
        $contactHistory = ContactHistory::factory()->create([
            'candidate_id' => Candidate::factory()->create()->id,
            'company_id' => Company::factory()->create()->id,
            'contacted' => true,
            'hired' => false
        ]);
        
        $payload = ['candidateId' => $contactHistory->candidate_id];
        $this->post('/candidates-contact', $payload)
                ->assertJsonFragment([
                    'type' => 'error',
                    'msg' => 'You already contacted this candidate!'
                ]);
    }

    public function test_contact_candidate_already_hired()
    {
        Wallet::factory()->create();
        Company::factory()->create();
        $contactHistory = ContactHistory::factory()->create([
            'candidate_id' => Candidate::factory()->create()->id,
            'company_id' => Company::factory()->create()->id,
            'contacted' => true,
            'hired' => true
        ]);
        
        $payload = ['candidateId' => $contactHistory->candidate_id];
        $this->post('/candidates-contact', $payload)
                ->assertJsonFragment([
                    'type' => 'error',
                    'msg' => 'This candidate was already hired by another company!'
                ]);
    }

    public function test_hire_candidate_without_contact()
    {
        $candidate = Candidate::factory()->create();
        Company::factory()->create();
        Wallet::factory()->create();
        $payload = ['candidateId' => $candidate->id];

        $this->post('/candidates-hire', $payload)
                ->assertJsonFragment([
                    'type' => 'error',
                    'msg' => 'Please contact the candidate before you hire him!'
                ]);
    }

    public function test_hire_candidate_already_hired_by_another_company()
    {
        Wallet::factory()->create();
        Company::factory()->create();
        $contactHistory = ContactHistory::factory()->create([
            'candidate_id' => Candidate::factory()->create()->id,
            'company_id' => Company::factory()->create()->id,
            'contacted' => true,
            'hired' => true
        ]);
        $payload = ['candidateId' => $contactHistory->candidate_id];

        $this->post('/candidates-hire', $payload)
                ->assertJsonFragment([
                    'type' => 'error',
                    'msg' => 'This candidate was already hired by another company!'
                ]);
    }

    public function test_hire_candidate_already_hired()
    {
        Wallet::factory()->create();
        $contactHistory = ContactHistory::factory()->create([
            'candidate_id' => Candidate::factory()->create()->id,
            'company_id' => Company::factory()->create()->id,
            'contacted' => true,
            'hired' => true
        ]);
        $payload = ['candidateId' => $contactHistory->candidate_id];

        $this->post('/candidates-hire', $payload)
                ->assertJsonFragment([
                    'type' => 'error',
                    'msg' => 'You already hired this candidate!'
                ]);
    }

    public function test_hire_candidate()
    {
        $a = Wallet::factory()->create();
        $value = WalletLogic::$COMPANY_CONTACTED_CANDIDATE;
        $initialValue = $a->coins -= $value;
        $a->save();
        $contactHistory = ContactHistory::factory()->create([
            'candidate_id' => Candidate::factory()->create()->id,
            'company_id' => Company::factory()->create()->id,
            'contacted' => true,
            'hired' => false
        ]);
        $payload = ['candidateId' => $contactHistory->candidate_id];

        $this->post('/candidates-hire', $payload)
                ->assertJsonFragment([
                    'type' => 'success',
                    'msg' => 'You successfully hired the candidate!'
                ]);

        $a->refresh();
        $this->assertEquals($initialValue + $value, $a->coins);
    }
}
