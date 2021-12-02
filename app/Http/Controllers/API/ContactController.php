<?php

namespace App\Http\Controllers\Api;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Repository\ContactRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contacts' => 'array',
            'contacts.*.name' => 'required',
            'contacts.*.phone_number' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(ApiHelper::std_response_format([
                'success' => false,
                'error' => array('message' => 'Invalid Parameters'),
                'errors' => $validator->errors(),
                'data' => []
            ]), 400);
        }
        try {
            $contacts = $request->get('contacts');
            ContactRepository::bulkInsert($contacts, auth()->user());
            $contacts = Contact::query()->where('user_id', auth()->user()->id)->get();
            return response()->json(ApiHelper::std_response_format([
                'success' => true,
                'error' => array('message' => 'Contacts Added'),
                'errors' => [],
                'data' => [
                    'contacts' => $contacts
                ]
            ]));
        } catch (\Exception $e){
            return response()->json(ApiHelper::std_response_format([
                'success' => false,
                'error' => array('message' => 'Error Occurred!'),
                'errors' => [],
                'data' => []
            ]));
        }
    }

    public function index()
    {
        $contacts = Contact::query()->where('user_id', auth()->user()->id)->get();
        return response()->json(ApiHelper::std_response_format([
            'success' => true,
            'error' => array('message' => 'Contacts List'),
            'errors' => [],
            'data' => [
                'contacts' => $contacts
            ]
        ]));
    }

    public function show(Contact $contact)
    {
        return response()->json(ApiHelper::std_response_format([
            'success' => true,
            'error' => array('message' => 'Contact Details!'),
            'errors' => [],
            'data' => [
                'contact' => $contact
            ]
        ]));
    }

    public function update(Request $request, Contact $contact)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(ApiHelper::std_response_format([
                'success' => false,
                'error' => array('message' => 'Invalid Parameters'),
                'errors' => $validator->errors(),
                'data' => []
            ]), 400);
        }
        try{
            $contact->update([
                'name' => $request->get('name'),
                'phone_number' => $request->get('phone_number'),
            ]);

            return response()->json(ApiHelper::std_response_format([
                'success' => true,
                'error' => array('message' => 'Contact Updated!'),
                'errors' => [],
                'data' => [
                    'contact' => $contact
                ]
            ]));
        } catch (\Exception $e){
            return response()->json(ApiHelper::std_response_format([
                'success' => false,
                'error' => array('message' => 'Error Occurred!'),
                'errors' => [],
                'data' => []
            ]));
        }

    }

    public function destroy(Contact $contact)
    {
        try{
            $contact->delete();
            return response()->json(ApiHelper::std_response_format([
                'success' => true,
                'error' => array('message' => 'Contact Deleted!'),
                'errors' => [],
                'data' => []
            ]));
        } catch (\Exception $e){
            return response()->json(ApiHelper::std_response_format([
                'success' => false,
                'error' => array('message' => 'Error Occurred!'),
                'errors' => [],
                'data' => []
            ]));
        }
    }

}
