<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Wallet;
use App\Models\ContactHistory;
use App\Mail\CandidateContacted;
use App\Mail\CandidateHired;
use App\Lib\WalletLogic;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Exception;

class CandidateController extends Controller
{
    public function index()
    {
        return view('candidates.index');
    }

    public function getCandidates()
    {
        $candidates = Candidate::all();
        $contactHistory = ContactHistory::where('company_id', '=', 1)->get();
        return ['candidates' => $candidates, 'contactHistory' => $contactHistory];
    }

    public function contact(Request $request)
    {
        try {
            $candidateId = $request->get('candidateId');
            //using by default the company id 1 as provided instead of getting the Auth::user()
            //because the login was not to implment, or it could be passed as a parameter

            $wallet = Wallet::where('company_id',1)->first();
            $contactValue = WalletLogic::$COMPANY_CONTACTED_CANDIDATE;
            if ($wallet->coins < $contactValue) {
                return ['type' => 'error', 'msg' => 'You dont\'t have the sufficent funds!'];
            }

            DB::beginTransaction();

            $contactHistory = ContactHistory::query()
                        ->where('candidate_id', '=', $candidateId)
                        ->lockForUpdate()
                        ->get()
                        ->all();

            $recordForThisCompany = null;

            foreach($contactHistory as $contact) {
                if ($contact->hired && $contact->company_id !== 1) {
                    DB::rollBack();
                    return ['type' => 'error', 'msg' => 'This candidate was already hired by another company!'];
                }
                if ($contact->company_id === 1) {
                    $recordForThisCompany = $contact;
                }
            }

            if ($recordForThisCompany) {
                return ['type' => 'error', 'msg' => 'You already contacted this candidate!'];
            }

            ContactHistory::create([
                'company_id' => 1,
                'candidate_id' => $candidateId,
                'contacted' => true
            ]);

            $wallet->coins -= $contactValue;
            $wallet->save();

            $candidate = Candidate::find($candidateId);

            // If the email is need to be assured that is delivered instead of queue it can be send and catch the exception
            Mail::to($candidate->email)->queue(new CandidateContacted());

            // A supervisor would need to be implemented to keep the queue worker running in the background
            // Also we could use redis to add the email to the list and have a process in background consuming the list.

            DB::commit();
            return ['type' => 'success', 'msg' => 'You successfully contacted the candidate.'];
     
        } catch(Exception $e) {
            DB::rollback();
            Log::error('error saving contact_history record',
                [
                    'candidate_id' => $candidateId ?? '',
                    'company_id' => 1,
                    'message' => $e->getMessage(),
                    'stackTrace' => $e->getTraceAsString(),
                ]);
            return ['type' => 'error', 'msg' => 'Something went wrong when contacting the candidate. Please try again soon.'];
        }
    }

    public function hire(Request $request)
    {
        try {
            $candidateId = $request->get('candidateId');
            // using by default the company id 1 as provided instead of getting the Auth::user()
            // because the login was not to implment, or it could be passed as a parameter

            DB::beginTransaction();

            $contactHistory = ContactHistory::query()
                        ->where('candidate_id', '=', $candidateId)
                        ->lockForUpdate()
                        ->get()
                        ->all();

            $recordForThisCompany = null;

            foreach($contactHistory as $contact) {
                if ($contact->hired && $contact->company_id !== 1) {
                    DB::rollBack();
                    return ['type' => 'error', 'msg' => 'This candidate was already hired by another company!'];
                }
                if ($contact->company_id === 1) {
                    $recordForThisCompany = $contact;
                }
            }

            if (!$recordForThisCompany) {
                return ['type' => 'error', 'msg' => 'Please contact the candidate before you hire him!'];
            }

            if ($recordForThisCompany->hired) {
                return ['type' => 'error', 'msg' => 'You already hired this candidate!'];
            }

            $recordForThisCompany->hired = true;
            $recordForThisCompany->save();

            $candidate = Candidate::find($candidateId);

            $wallet = Wallet::where('company_id',1)->first();

            $wallet->coins += WalletLogic::$COMPANY_CONTACTED_CANDIDATE;
            $wallet->save();

            // If the email is need to be assured that is delivered instead of queue it can be send and catch the exception
            Mail::to($candidate)->queue(new CandidateHired());

            // A supervisor would need to be implemented to keep the queue worker running in the background
            // Also we could use redis to add the email to the list and have a process in background consuming the list.
            
            DB::commit();
            return ['type' => 'success', 'msg' => 'You successfully hired the candidate!'];
        } catch(Exception $e) {
            DB::rollBack();
            Log::error('error saving contact_history record',
                [
                    'candidate_id' => $candidateId ?? '',
                    'company_id' => 1,
                    'message' => $e->getMessage(),
                    'stackTrace' => $e->getTraceAsString(),
                ]);
            return ['type' => 'error', 'msg' => 'Something went wrong when contacting the candidate. Please try again soon.'];
        }
    }
}
